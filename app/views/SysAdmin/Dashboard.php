<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SystemAdmin/main.css">
    <title>Employee Management</title>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="#"><i class="fas fa-th"></i>Dashboard</a></li>
                <li><a href="<?php echo URLROOT; ?>/SysAdmin/UserManagement"><i class="fas fa-user"></i>User Management</a></li>
                <li><a href="<?php echo URLROOT; ?>/SysAdmin/ProductManagement"><i class="fas fa-truck"></i>Product Management</a></li>
                <li><a href="<?php echo URLROOT; ?>/SysAdmin/CustomerManagement"><i class="fas fa-users"></i>Customer Management</a></li>
                <li><a href="<?php echo URLROOT; ?>/SysAdmin/ViewOrders"><i class="fas fa-eye"></i>View Orders</a></li>
            </ul>
            <div class="logo">
            <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/logo.jpg" alt="Logo">
            </div>
            <div class="logout">
                <button onclick="window.location.href='<?php echo URLROOT; ?>/logout'">Logout</button>
            </div>
        </div>
        <div class="sub-container-2">
            <div class="header">
                <div class="user-info">
                    <div>
                        <span>Danuka Kalhara</span>
                        <span>System-Administrator</span>
                    </div>
                    <div>
                        <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/admin-profile.png" alt="User Avatar">
                    </div>
                </div>
            </div>
            <div class="dashboard">
                <p><i class="fas fa-th"></i>&nbsp; Dashboard</p>
            </div>
            <div class="body-elements">
                <div class="body-elements-1">
                    <div class="users">
                        <h2>Team Members</h2>
                            <div>
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Sachini">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Jerom">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Ann">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Maya">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Sachini">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Jerom">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Ann">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Maya">
                            </div>
                    </div>

                    <div class="products">
                        <h2>Top Products</h2>
                        <div class="product-item">
                            <div class="item">
                                <img src="https://via.placeholder.com/80" alt="Honey Waffles">
                                <p>Honey Waffles</p>
                            </div>
                            <div class="item">
                                <img src="https://via.placeholder.com/80" alt="Butter & Honey Bread">
                                <p>Butter & Honey Bread</p>
                            </div>
                            <div class="item">
                                <img src="https://via.placeholder.com/80" alt="Strawberry Pancake">
                                <p>Strawberry Pancake</p>
                            </div>
                            <div class="item">
                                <img src="https://via.placeholder.com/80" alt="Honey Waffles">
                                <p>Honey Waffles</p>
                            </div>
                            <div class="item">
                                <img src="https://via.placeholder.com/80" alt="Butter & Honey Bread">
                                <p>Butter & Honey Bread</p>
                            </div>
                        </div>
                    </div>

                    <div class="overview">
                        <div class="card">
                            <h2>15</h2>
                            <p>Total Users</p>
                        </div>
                        <div class="card">
                            <h2>120</h2>
                            <p>Total Products</p>
                        </div>
                        <div class="card">
                            <h2>350</h2>
                            <p>Total Customers</p>
                        </div>
                    </div>

                </div>
                <div class="calendar">
                    <p>Calendar is placed here</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>