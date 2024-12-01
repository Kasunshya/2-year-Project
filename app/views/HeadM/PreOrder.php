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
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by Preorder ID">
                            <button class="search-btn">🔍</button>
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
                                    <th>Contact Number</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P001</td>
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>john.doe@example.com</td>
                                    <td>9876543210</td>
                                    <td>Wedding Cake for 150 guests</td>
                                    <td>
                                        <button class="btn edit">View</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>P002</td>
                                    <td>Jane</td>
                                    <td>Smith</td>
                                    <td>jane.smith@example.com</td>
                                    <td>9123456780</td>
                                    <td>Customized Birthday Cake</td>
                                    <td>
                                        <button class="btn edit">View</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>P003</td>
                                    <td>Michael</td>
                                    <td>Brown</td>
                                    <td>michael.brown@example.com</td>
                                    <td>9988776655</td>
                                    <td>Anniversary Cake with a heart design</td>
                                    <td>
                                        <button class="btn edit">View</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>