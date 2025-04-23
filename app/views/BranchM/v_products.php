
<?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/salesReport.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/products.css">

<header><i class="fas fa-cookie">&nbsp</i> Products</header>
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
                        <td>$<?php echo number_format($product->price, 2); ?></td>
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
</div>