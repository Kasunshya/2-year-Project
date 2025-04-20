<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Head Manager Customization</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Dashboard.css">
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
                <h1><i class="fas fa-palette icon-customization"></i> CUSTOMIZED ORDERS</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>

                <!-- Customization Table -->
                <div class="customization-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by Customisation ID">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <section class="dashboard-content">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Customization ID</th>
                                    <th>Customer Name</th>
                                    <th>Flavor</th>
                                    <th>Size</th>
                                    <th>Toppings</th>
                                    <th>Custom Message</th>
                                    <th>Delivery Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['customizations'])): ?>
                                    <?php foreach ($data['customizations'] as $customization): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($customization->customisation_id); ?></td>
                                            <td><?php echo htmlspecialchars($customization->customer_name); ?></td>
                                            <td><?php echo htmlspecialchars($customization->flavour); ?></td>
                                            <td><?php echo htmlspecialchars($customization->size); ?></td>
                                            <td><?php echo htmlspecialchars($customization->toppings); ?></td>
                                            <td><?php echo htmlspecialchars($customization->custom_message); ?></td>
                                            <td><?php echo htmlspecialchars($customization->delivery_date); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No customizations found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                </div>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/BranchManagers.js"></script>
</body>

</html>