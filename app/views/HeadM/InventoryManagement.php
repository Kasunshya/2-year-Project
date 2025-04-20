<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Inventory Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT . '/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-warehouse icon-inventory"></i>&nbsp INVENTORY</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">
                <div class="employee-list">
                    <!-- Search Bar -->
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" name="search" placeholder="Search by Branch or Product Name" value="<?php echo htmlspecialchars($data['search'] ?? ''); ?>">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Expiry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['inventoryData'])): ?>
                                    <?php foreach ($data['inventoryData'] as $inventory): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($inventory->branch_name); ?></td>
                                            <td><?php echo htmlspecialchars($inventory->product_name); ?></td>
                                            <td><?php echo htmlspecialchars($inventory->quantity); ?></td>
                                            <td><?php echo htmlspecialchars($inventory->expiry_date); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No inventory data available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>