<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Keeper - Delete Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/Inventorykeeper/deleteinventory.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">FROSTINE</div>
            <nav>
                <ul>
                    <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fas fa-trash-alt"></i> Delete Inventory</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main>
            <div class="header">
                <h1>Delete Inventory Item</h1>
            </div>

            <div class="form">
                <h2>Delete Inventory Item</h2>
                <form action="<?php echo URLROOT; ?>/Inventorykeeper/deleteInventory" method="POST">
                    <div class="form-group">
                        <label for="delete-inventory-id">Inventory ID <span style="color:red;">*</span></label>
                        <input type="text" id="delete-inventory-id" name="delete_inventory_id" placeholder="Enter Inventory ID to Delete" value="<?php echo $data['delete_inventory_id']; ?>" required>
                        <span class="form-invalid"><?php echo $data['delete_inventory_id_err']; ?></span>
                    </div>
                    <button type="submit">Delete Inventory</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
