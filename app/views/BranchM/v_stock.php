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
            margin: 0 auto;
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stock-table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-left: 120px;
        }
        .stock-table th, .stock-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .stock-table th {
            background-color: #f4f4f4;
        }
        .low-stock {
            color: red;
        }
        .expiring-soon {
            color: orange;
        }
        .search-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .search-container input, .search-container select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        main {
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h7><i class="fas fa-box-open">&nbsp;</i>Stock Management</h7>
            <div class="search-container">
                <input type="text" id="stockSearch" placeholder="Search products...">
                <select id="categoryFilter">
                    <option value="">All Categories</option>
                    <?php foreach(array_unique(array_column($data['stocks'], 'category_name')) as $category): ?>
                        <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </header>
    
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