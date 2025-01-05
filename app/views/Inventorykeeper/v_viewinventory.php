<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Keeper - View Inventory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="../public/css/Inventorykeeper/viewinventory.css">
    <?php require APPROOT . '/views/inc/components/ivertical.php'; ?>
</head>
<body>
    <div class="container">
        <!-- Main Content -->
        <main>
            <!-- Header Section -->
            <header class="header">
                <h1><a href="#"><i class="fas fa-chart-bar"></i></a> Dashboard</h1>
                <div class="user-info">
                    Inventory Keeper<br>
                </div>
            </header>

            <!-- Inventory Chart and Table -->
            <section class="content-container">
                <!-- Inventory Table -->
                <div class="inventory-table-container">
                    <h2>Inventory Table</h2>
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Inventory ID</th>
                                <th>Inventory Name</th>
                                <th>Price</th>
                                <th>Quantity (kg)</th>
                                <th>Expiry Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['inventory'] as $item): ?>
                                <tr>
                                    <td><?php echo $item->inventory_id; ?></td>
                                    <td><?php echo $item->name; ?></td>
                                    <td><?php echo $item->Price_per_kg; ?></td>
                                    <td><?php echo $item->quantity_available; ?></td>
                                    <td><?php echo $item->Expiry_date; ?></td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/Inventorykeeper/updateinventory/<?php echo $item->inventory_id; ?>">
                                            <i class="fas fa-edit" style="color: green; cursor: pointer;"></i>
                                        </a>
                                        <a href="<?php echo URLROOT; ?>/Inventorykeeper/deleteInventory/<?php echo $item->inventory_id; ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                            <i class="fas fa-trash" style="color: red; cursor: pointer;"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
