<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Head Manager - View Preorders</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT.'/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-clock"></i>&nbsp VIEW PRE ORDERS</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>

            <div class="content">
                <!-- Preorders Table -->
                <div class="preorder-list">
                    <div class="search-bar">
                        <form method="GET" action="<?php echo URLROOT; ?>/HeadM/preOrder" class="search-form">
                            <div class="search-field">
                                <input type="text" name="search" placeholder="Search by Name or Email" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <button class="btn search-btn" type="submit"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Preorder ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['preOrders'])): ?>
                                    <?php foreach ($data['preOrders'] as $preOrder): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($preOrder->preorder_id); ?></td>
                                            <td><?php echo htmlspecialchars($preOrder->first_name); ?></td>
                                            <td><?php echo htmlspecialchars($preOrder->last_name); ?></td>
                                            <td><?php echo htmlspecialchars($preOrder->email); ?></td>
                                            <td><?php echo htmlspecialchars($preOrder->phone_number); ?></td>
                                            <td><?php echo htmlspecialchars($preOrder->description); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">No preorders found.</td>
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