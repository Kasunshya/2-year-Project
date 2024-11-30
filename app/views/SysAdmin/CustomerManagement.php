<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SystemAdmin/main.css">
    <title>Customer Management</title>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="<?php echo URLROOT; ?>/index"><i class="fas fa-th"></i>Dashboard</a></li>
                <li><a href="<?php echo URLROOT; ?>/UserManagement"><i class="fas fa-user"></i>User Management</a></li>
                <li><a href="<?php echo URLROOT; ?>/ProductManagement"><i class="fas fa-truck"></i>Product Management</a></li>
                <li><a href="#"><i class="fas fa-users"></i>Customer Management</a></li>
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
                    <button class="btn add-new">+ Add New Customer</button>

                    <!-- Add Customer Modal -->
                    <div id="customerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Add New Customer</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <label for="full_Name">Full Name:</label>
                                <input type="text" id="full_Name" name="full_Name" required pattern="[A-Za-z\s]+" title="Please enter a valid full name (letters and spaces only)">

                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" required>

                                <label for="contact_No">Contact No:</label>
                                <input type="text" id="contact_No" name="contact_No" required pattern="[0-9]{10}" title="Please enter a 10-digit contact number">

                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>

                                <div class="buttons">
                                    <button type="reset" class="btn reset">Reset</button>
                                    <button type="submit" name="add_customer" class="btn submit">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Edit Customer Modal -->
                    <div id="editCustomerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Edit Customer</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" id="edit_customer_ID" name="customer_ID">
                                
                                <label for="edit_full_Name">Full Name:</label>
                                <input type="text" id="edit_full_Name" name="full_Name" required>

                                <label for="edit_address">Address:</label>
                                <input type="text" id="edit_address" name="address" required>

                                <label for="edit_contact_No">Contact No:</label>
                                <input type="text" id="edit_contact_No" name="contact_No" required>

                                <label for="edit_email">Email:</label>
                                <input type="email" id="edit_email" name="email" required>

                                <div class="buttons">
                                    <button type="submit" name="edit_customer" class="btn submit">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div id="deleteCustomerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Delete Customer</h2>
                            <p>Are you sure you want to delete this customer?</p>
                            <div class="buttons">
                                <button type="submit" id="confirmDelete" class="btn reset">Yes</button>
                                <button type="reset" class="btn submit">No</button>
                            </div>
                        </div>
                    </div>

                    <div class="view-new-list">
                        <div class="search-bar">
                            <form method="GET" action="">
                                <input type="text" placeholder="Search by Name">
                                <button class="search-btn">🔍</button>
                            </form>
                        </div>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Customer Id</th>
                                        <th>Full Name</th>
                                        <th>Address</th>
                                        <th>Contact No</th>
                                        <th>Email</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['customer_id']}</td>
                                                    <td>{$row['full_name']}</td>
                                                    <td>{$row['address']}</td>
                                                    <td>{$row['contact_no']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td>
                                                        <button class='btn edit-btn' 
                                                            data-id='{$row['customer_id']}'
                                                            data-fullName='{$row['full_name']}'
                                                            data-address='{$row['address']}'
                                                            data-contactNo='{$row['contact_no']}'
                                                            data-email='{$row['email']}'>
                                                            Edit
                                                        </button>
                                                        <button class='btn delete-btn' 
                                                            data-id='{$row['customer_id']}'>
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No customers found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/SystemAdmin/CustomerManagement.js"></script>
</body>
</html>