<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Keeper - Add Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../public/css/Inventorykeeper/addinventory.css">
    <?php require APPROOT.'/views/inc/components/ivertical.php'?>
</head>
<body>
    

        <!-- Main Content -->
        <main>
            <!-- Header Section -->
            <header class="header">
                <h1><i class="fas fa-plus-circle"></i> Add Inventory Item</h1>
                <div class="user-info">
                    Inventory Keeper<br>
                </div>
            </header>

            <!-- Add Inventory Form -->
            <section>
                <div class="add-inventory-form">
                    <h2>Add New Inventory Item</h2>
                    <form action="<?php echo URLROOT; ?>/Inventorykeeper/addinventory" method="POST">
                        <div class="form-group">
                            <label for="name">Inventory Name:</label>
                            <input type="text" id="name" name="name" value="<?php echo $data['name']; ?>" required>
                            <span class="form-invalid"><?php echo $data['name_err']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity Available (kg):</label>
                            <input type="number" id="quantity" name="quantity_available" value="<?php echo $data['quantity_available']; ?>" required>
                            <span class="form-invalid"><?php echo $data['quantity_available_err']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="price">Price per kg (LKR):</label>
                            <input type="number" id="price" name="Price_per_kg" value="<?php echo $data['Price_per_kg']; ?>" required>
                            <span class="form-invalid"><?php echo $data['Price_per_kg_err']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date:</label>
                            <input type="date" id="expiry_date" name="Expiry_date" value="<?php echo $data['Expiry_date']; ?>">
                            <span class="form-invalid"><?php echo $data['Expiry_date_err']; ?></span>
                        </div>
                        <button type="submit">Add Inventory</button>
                    </form>
                </div>
            </section>
        </main>
    </div>
   
</body>
</html>
