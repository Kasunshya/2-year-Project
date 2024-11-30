<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Head Manager - View Orders</title>
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
                <h1><i class="fas fa-clipboard-list"></i>&nbsp VIEW ORDERS</h1>
                <div class="user-info">
                <span><b>HEAD MANAGER</b></span>
                </div>
            </header>

            <div class="content">
                <!-- Orders Table -->
                <div class="order-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by Order ID">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer ID</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>O001</td>
                                    <td>101</td>
                                    <td>2024-11-25</td>
                                    <td>LKR 10,500.00</td>
                                    <td>
                                        <button class="btn view">View Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>O002</td>
                                    <td>102</td>
                                    <td>2024-11-24</td>
                                    <td>LKR 8,250.00</td>
                                    <td>
                                        <button class="btn view">View Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>O003</td>
                                    <td>103</td>
                                    <td>2024-11-23</td>
                                    <td>LKR 5,750.00</td>
                                    <td>
                                        <button class="btn view">View Details</button>
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