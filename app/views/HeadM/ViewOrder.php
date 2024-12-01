<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Head Manager - View Orders</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-container">
                <img src="<?php echo URLROOT; ?>/public/img/HeadM/FrostineLogo2.png" alt="Logo" class="logo">
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/dashboard"><i class="fas fa-tachometer-alt"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/cashierManagement"><i class="fas fa-cash-register icon-cashier"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/productManagement"><i class="fas fa-birthday-cake"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/inventoryManagement"><i class="fas fa-warehouse icon-inventory"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/branchManager"><i class="fas fa-user-tie icon-branch-manager"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/customization"><i class="fas fa-palette"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/viewOrder"><i class="fas fa-clipboard-list"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/preOrder"><i class="fas fa-clock"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/dailyBranchOrder"><i class="fas fa-calendar-check"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/feedback"><i class="fas fa-comments"></i></a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </aside>

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