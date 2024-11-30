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
                <li><a href="<?php echo URLROOT; ?>/Dashboard"><i class="fas fa-th"></i>Dashboard</a></li>
                <li><a href="#"><i class="fas fa-user"></i>User Management</a></li>
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
                <p><i class="fas fa-user"></i>&nbsp; User Management</p>
            </div>
            <div class="table-elements">
                <div class="role-details">
                    <button class="btn add-new">+ Add New User</button>

                    <!-- Add User Modal -->
                    <div id="customerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Add New User</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <label for="full_name">Full Name:</label>
                                <input type="text" id="full_name" name="full_name" required>

                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" required>

                                <label for="contact_no">Contact No:</label>
                                <input type="text" id="contact_no" name="contact_no" required>

                                <label for="user_role">User Role:</label>
                                <input type="text" id="user_role" name="user_role" required>

                                <div class="buttons">
                                    <button type="reset" class="btn reset">Reset</button>
                                    <button type="submit" name="add_user" class="btn submit">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Edit User Modal -->
                    <div id="editCustomerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Edit User</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" id="edit_employee_id" name="employee_id">
                                
                                <label for="edit_full_name">Full Name:</label>
                                <input type="text" id="edit_full_name" name="full_name" required>

                                <label for="edit_address">Address:</label>
                                <input type="text" id="edit_address" name="address" required>

                                <label for="edit_contact_no">Contact No:</label>
                                <input type="text" id="edit_contact_no" name="contact_no" required>

                                <label for="edit_user_role">User Role:</label>
                                <input type="text" id="edit_user_role" name="user_role" required>

                                <div class="buttons">
                                    <button type="submit" name="edit_user" class="btn submit">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div id="deleteCustomerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Delete User</h2>
                            <p>Are you sure you want to delete this user?</p>
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
                                        <th>Employee Id</th>
                                        <th>Employee Name</th>
                                        <th>Address</th>
                                        <th>Contact No</th>
                                        <th>User Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['employee_id']) ?></td>
                                                <td><?= htmlspecialchars($row['full_name']) ?></td>
                                                <td><?= htmlspecialchars($row['address']) ?></td>
                                                <td><?= htmlspecialchars($row['contact_no']) ?></td>
                                                <td><?= htmlspecialchars($row['user_role']) ?></td>
                                                <td class="action-icons">
                                                    <a href="<?php echo URLROOT; ?>/editEmployee/<?= $row['employee_id'] ?>" class="edit" title="Edit">&#9998;</a>
                                                    <a href="<?php echo URLROOT; ?>/deleteEmployee/<?= $row['employee_id'] ?>" class="delete" title="Delete" onclick="return confirm('Are you sure you want to delete this employee?');">&#128465;</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">No employees found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/SystemAdmin/UserManagement.js"></script>
</body>
</html>
