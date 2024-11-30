<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    <title>Add New Customer</title>
</head>
<body>
    <div class="container">
        <div class="sidebar">
        <ul>
                <li><a href="<?php echo URLROOT; ?>/Dashboard"><i class="fas fa-th"></i>Dashboard</a></li>
                <li><a href="<?php echo URLROOT; ?>/UserManagement"><i class="fas fa-user"></i>User Management</a></li>
                <li><a href="<?php echo URLROOT; ?>/ProductManagement"><i class="fas fa-truck"></i>Product Management</a></li>
                <li><a href="<?php echo URLROOT; ?>/CustomerManagement"><i class="fas fa-users"></i>Customer Management</a></li>
                <li><a href="<?php echo URLROOT; ?>/ViewOrders"><i class="fas fa-eye"></i>View Orders</a></li>
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
                        <span>System Administrator</span>
                    </div>
                    <div>
                        <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/admin-profile.png" alt="User Avatar">
                    </div>
                </div>
            </div>
            <div class="dashboard">
                <p><i class="fas fa-users"></i>&nbsp; Customer Management</p>
            </div>
            <div class="table-elements">
                <div class="role-details">
                    <div class="users">
                        <h2>Add New Customer</h2>
                    </div>

                    <div class="form-container">
                        <h2>Customer Registration</h2>
                        <form method="POST" action="{{form_submission_action}}">
                            <div class="form-group inline">
                                <div class="form-control">
                                    <label for="customer-name">Customer Name</label>
                                    <input type="text" id="customer-name" name="customer-name" placeholder="Enter customer name" required>
                                </div>
                                <div class="form-control">
                                    <label for="contact-no">Contact No</label>
                                    <input type="text" id="contact-no" name="contact-no" placeholder="Enter contact number" required>
                                </div>
                            </div>
                
                            <div class="form-group">
                                <label for="email-address">Email Address</label>
                                <input type="email" id="email-address" name="email-address" placeholder="Enter email address" required>
                            </div>
                
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" name="address" rows="3" placeholder="Enter address" required></textarea>
                            </div>
                
                            <div class="buttons">
                                <button type="reset" class="reset-btn">Reset</button>
                                <button type="submit" class="register-btn">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
