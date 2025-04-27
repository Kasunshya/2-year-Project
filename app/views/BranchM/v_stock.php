<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>
    <?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/branchmdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .header-container {
            width: 90%;
            padding: 5px ;
            display: flex;
            align-items: left;
        }
        
        /* Updated Search container styling */
        .search-wrapper {
            width: 90%;
            margin: 20px auto;
            margin-left: 120px; /* Match with table's left margin */
            margin-right: auto; /* Remove the 1500px fixed margin */
            max-width: calc(90% - 30px); /* Match width with header container */
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .search-input-group {
            display: flex;
            align-items: center;
            flex-grow: 1;
            position: relative;
        }
        
        .search-wrapper input {
            flex-grow: 1;
            padding: 10px 15px;
            padding-right: 40px; /* Space for the icon */
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }
        
        .search-icon {
            position: absolute;
            right: 10px;
            color: #a26b98;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            padding: 5px;
            transition: color 0.2s ease;
        }
        
        .search-icon:hover {
            color: #5d2e46;
        }
        
        .search-wrapper select {
            min-width: 150px;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            background-color: white;
            font-size: 14px;
        }
        
        .search-wrapper input:focus,
        .search-wrapper select:focus {
            outline: none;
            border-color: #a26b98;
            box-shadow: 0 0 0 2px rgba(162, 107, 152, 0.2);
        }
        
        /* New table styles */
        .stock-table {
            width: 90%;
            margin: 0 auto;
            margin-left: 120px;
            min-width: 1200px;
            border-collapse: collapse;
        }

        .stock-table th {
            background-color: #a26b98; /* var(--primary-main) */
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            border: none;
        }

        .stock-table th:first-child {
            border-top-left-radius: 4px; /* var(--radius-sm) */
        }

        .stock-table th:last-child {
            border-top-right-radius: 4px; /* var(--radius-sm) */
        }

        .stock-table td {
            background-color: white; /* var(--neutral-white) */
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #e0e0e0; /* var(--neutral-gray) */
            transition: background-color 0.2s ease;
        }

        .stock-table tbody tr:hover td {
            background-color: #f9f5f0; /* var(--accent-cream) */
        }

        .stock-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Keep existing status styling */
        .low-stock {
            color: red;
        }
        
        .expiring-soon {
            color: orange;
        }
        
        main {
            padding: 20px 0;
            overflow-x: auto; /* Add horizontal scrolling for small screens */
        }
    </style>
</head>
<body>
    <!-- Header with just the title -->
    <header>
        <div class="header-container">
            <h7><i class="fas fa-box-open">&nbsp;</i>Stock Management</h7>
        </div>
    </header>
    
    <!-- Search and filter section moved BELOW the header -->
    <div class="search-wrapper">
        <div class="search-input-group">
            <input type="text" id="stockSearch" placeholder="Search products...">
            <button class="search-icon" id="searchBtn">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <select id="categoryFilter">
            <option value="">All Categories</option>
            <?php foreach(array_unique(array_column($data['stocks'], 'category_name')) as $category): ?>
                <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <main>
        <table class="stock-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['stocks'] as $stock): ?>
                    <tr>
                        <td><?php echo $stock->product_name; ?></td>
                        <td><?php echo $stock->category_name; ?></td>
                        <td class="<?php echo ($stock->quantity < 10) ? 'low-stock' : ''; ?>">
                            <?php echo $stock->quantity; ?>
                        </td>
                        <td><?php echo number_format($stock->price, 2); ?></td>
                        <td class="<?php echo (strtotime($stock->expiry_date) - time() < 604800) ? 'expiring-soon' : ''; ?>">
                            <?php echo $stock->expiry_date; ?>
                        </td>
                        <td>
                            <?php if($stock->quantity < 10): ?>
                                <span class="low-stock">Low Stock</span>
                            <?php elseif(strtotime($stock->expiry_date) - time() < 604800): ?>
                                <span class="expiring-soon">Expiring Soon</span>
                            <?php else: ?>
                                <span>Normal</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
    document.getElementById('stockSearch').addEventListener('keyup', filterStock);
    document.getElementById('categoryFilter').addEventListener('change', filterStock);
    document.getElementById('searchBtn').addEventListener('click', filterStock);

    function filterStock() {
        const searchText = document.getElementById('stockSearch').value.toLowerCase();
        const category = document.getElementById('categoryFilter').value.toLowerCase();
        const rows = document.querySelectorAll('.stock-table tbody tr');

        rows.forEach(row => {
            const productName = row.cells[0].textContent.toLowerCase();
            const productCategory = row.cells[1].textContent.toLowerCase();
            const matchesSearch = productName.includes(searchText);
            const matchesCategory = !category || productCategory === category;
            row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
        });
    }
    </script>
</body>
</html>