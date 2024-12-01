<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Keeper - Update Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="../public/css/Inventorykeeper/updateinventory.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <?php require APPROOT.'/views/inc/components/ivertical.php'?>
</head>
<body>
    
        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-box"></i> Update Inventory Item</h1>
            </header>

            <!-- Update Inventory Form -->
            <section>
                <div class="form-container">
                    <form action="<?php echo URLROOT; ?>/Inventorykeeper/updateInventory" method="POST">
                        <div class="form-group">
                            <label for="inventory_id">Inventory ID <span style="color:red;">*</span></label>
                            <input type="text" id="inventory_id" name="inventory_id" value="<?php echo $data['inventory_id']; ?>" required>
                            <span class="form-invalid"><?php echo $data['inventory_id_err']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="update_inventory_name">Inventory Name</label>
                            <input type="text" id="update_inventory_name" name="update_inventory_name" value="<?php echo $data['update_inventory_name']; ?>">
                            <span class="form-invalid"><?php echo $data['update_inventory_name_err']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="update_quantity">Quantity (kg)</label>
                            <input type="number" id="update_quantity" name="update_quantity" value="<?php echo $data['update_quantity']; ?>">
                            <span class="form-invalid"><?php echo $data['update_quantity_err']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="update_price">Price per kg (LKR)</label>
                            <input type="number" id="update_price" name="update_price" value="<?php echo $data['update_price']; ?>">
                            <span class="form-invalid"><?php echo $data['update_price_err']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="update_expiry_date">Expiry Date</label>
                            <input type="date" id="update_expiry_date" name="update_expiry_date" value="<?php echo $data['update_expiry_date']; ?>">
                            <span class="form-invalid"><?php echo $data['update_expiry_date_err']; ?></span>
                        </div>
                        <button type="submit">Update Inventory</button>
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
