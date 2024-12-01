<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback View - Head Manager</title>
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
                <h1><i class="fas fa-comments"></i>&nbsp FEEDBACK VIEW</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">
                <div class="search-bar">
                    <form method="GET" action="">
                        <input type="text" placeholder="Search by Customer Name">
                        <button class="search-btn"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Feedback ID</th>
                                <th>Customer ID</th>
                                <th>Customer Name</th>
                                <th>Message</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>F001</td>
                                <td>101</td>
                                <td>John Doe</td>
                                <td>The cake was amazing!</td>
                                <td><span class="rating">★★★★★</span></td>
                                <td>2024-11-20</td>
                                <td><button class="btn delete">Delete</button></td>
                            </tr>
                            <tr>
                                <td>F002</td>
                                <td>102</td>
                                <td>Jane Smith</td>
                                <td>Delivery was on time and perfect.</td>
                                <td><span class="rating">★★★★★</span></td>
                                <td>2024-11-21</td>
                                <td><button class="btn delete">Delete</button></td>
                            </tr>
                            <tr>
                                <td>F003</td>
                                <td>103</td>
                                <td>Michael Brown</td>
                                <td>Great customization options!</td>
                                <td><span class="rating">★★★★★</span></td>
                                <td>2024-11-22</td>
                                <td><button class="btn delete">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>