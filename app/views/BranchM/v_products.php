<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/branchmdashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Common container styles for perfect alignment */
        .header-container, .products-container {
            width: 90%;
            margin-left: 120px;  /* Set explicit left margin */
            margin-right: 30px;  /* Set explicit right margin */
            padding: 0;          /* Remove padding that might cause misalignment */
            box-sizing: border-box;
        }

        /* Specific header styling */
        .header-container {
            padding: 20px 0;
            display: flex;
            align-items: center;
        }
        
        /* Specific products container styling */
        .products-container {
            margin-top: 20px;
            overflow-x: auto;
        }
        
        /* Table styles */
        .products-table {
            width: 100%;         /* Take full width of container */
            min-width: 1200px;
            border-collapse: collapse;
            margin: 0;           /* Remove any table margins */
        }

        /* Header might have h7 with margin - reset this */
        header h7 {
            margin: 0;           /* Remove any margins from the header text */
            padding-left: 0;      /* Remove any padding from the header text */
        }

        .products-table th {
            background-color: #a26b98; /* var(--primary-main) */
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            border: none;
        }

        .products-table th:first-child {
            border-top-left-radius: 4px; /* var(--radius-sm) */
        }

        .products-table th:last-child {
            border-top-right-radius: 4px; /* var(--radius-sm) */
        }

        .products-table td {
            background-color: white; /* var(--neutral-white) */
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #e0e0e0; /* var(--neutral-gray) */
            transition: background-color 0.2s ease;
        }

        .products-table tbody tr:hover td {
            background-color: #f9f5f0; /* var(--accent-cream) */
        }
        
        .products-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Stock form styling */
        .stock-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .quantity-input, .date-input {
            padding: 8px 10px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 14px;
        }

        .quantity-input {
            width: 80px;
        }

        .btn-update {
            background-color: #a26b98;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-update:hover {
            background-color: #5d2e46;
        }
    </style>
</head>
<body>
    <!-- Header with just the title -->
    <header>
        <div class="header-container">
            <h7><i class="fas fa-cookie">&nbsp;</i>Products</h7>
        </div>
    </header>
    
    <div class="products-container">
        <table class="products-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Current Stock</th>
                    <th>Update Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['products'] as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product->product_name); ?></td>
                        <td><?php echo htmlspecialchars($product->category_name); ?></td>
                        <td>LKR <?php echo number_format($product->price, 2); ?></td>
                        <td>
                            <?php
                            $currentStock = 0;
                            foreach($data['branchStock'] as $stock) {
                                if($stock->product_id == $product->product_id) {
                                    $currentStock = $stock->quantity;
                                    break;
                                }
                            }
                            echo $currentStock;
                            ?>
                        </td>
                        <td>
                            <form action="<?php echo URLROOT; ?>/Branch/updateDailyStock" method="POST" class="stock-form">
                                <input type="hidden" name="productId" value="<?php echo $product->product_id; ?>">
                                <input type="number" name="quantity" min="0" required class="quantity-input">
                                <input type="date" name="expiryDate" required class="date-input" 
                                       min="<?php echo date('Y-m-d'); ?>">
                                <button type="submit" class="btn-update">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>