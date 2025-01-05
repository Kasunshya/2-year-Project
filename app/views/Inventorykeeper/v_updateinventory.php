<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Inventory</title>
    <link rel="stylesheet" href="../../public/css/Inventorykeeper/updateinventory.css">
</head>
<body>
    <form action="<?php echo URLROOT; ?>/Inventorykeeper/updateinventory/<?php echo $data['inventory_id']; ?>" method="POST">
        <label for="update_inventory_name">Name:</label>
        <input type="text" name="update_inventory_name" value="<?php echo $data['update_inventory_name']; ?>" required>
        <span class="error"><?php echo $data['name_err']; ?></span>

        <label for="update_quantity">Quantity:</label>
        <input type="text" name="update_quantity" value="<?php echo $data['update_quantity']; ?>" required>
        <span class="error"><?php echo $data['quantity_err']; ?></span>

        <label for="update_price">Price:</label>
        <input type="text" name="update_price" value="<?php echo $data['update_price']; ?>" required>
        <span class="error"><?php echo $data['price_err']; ?></span>

        <label for="update_expiry_date">Expiry Date:</label>
        <input type="date" name="update_expiry_date" value="<?php echo $data['update_expiry_date']; ?>" required>
        <span class="error"><?php echo $data['expiry_date_err']; ?></span>

        <button type="submit">Update</button>
    </form>
</body>
</html>
