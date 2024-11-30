<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Keeper - Update Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="../public/css/Inventorykeeper/updateinventory.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">FROSTINE</div>
            <nav>
                <ul>
                    <li><a href="#"><i class="fas fa-tachometer-alt"></i></a></li>
                    <li><a href="#"><i class="fas fa-plus-circle"></i></a></li>
                    <li><a href="#"><i class="fas fa-warehouse"></i></a></li>
                    <li><a href="#"><i class="fas fa-edit"></i></a></li>
                    <li><a href="#"><i class="fas fa-trash-alt"></i></a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="#"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </aside>

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
