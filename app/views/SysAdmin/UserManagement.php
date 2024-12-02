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

        <?php require_once APPROOT.'/views/SysAdmin/SideNavBar.php'; ?>
        
        <div class="sub-container-2">
            <div class="header">
                <div class="page-title">
                    <span>&nbsp;&nbsp;<i class="fas fa-user"></i>&nbsp;Employee Management</span>
                </div>
                <div class="user-info">
                    <div>
                        <span>System Administrator</span>
                    </div>
                </div>
            </div>
            <div class="table-elements">
                <div class="role-details">
                    <button class="btn add-new">+ Add New Employee</button>

                    <!-- Add User Modal -->
                    <div id="customerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Add New User</h2>
                            <form action="<?php echo URLROOT; ?>/SysAdmin/addUser" method="POST">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>

                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required>

                                <label for="user_role">User Role:</label>
                                <select id="user_role" name="user_role" required>
                                    <option value="cashier">Cashier</option>
                                    <option value="inventorykeeper">Inventory Keeper</option>
                                    <option value="branchmanager">Branch Manager</option>
                                    <option value="headmanager">Head Manager</option>
                                    <option value="admin">Admin</option>
                                </select>

                                <div class="buttons">
                                    <button type="reset" class="btn reset">Reset</button>
                                    <button type="submit" name="add_user" class="btn submit">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Update User Modal -->
                    <div id="editCustomerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Edit User</h2>
                            <form action="<?php echo URLROOT; ?>/SysAdmin/editUser" method="post">
                                <input type="hidden" id="edit_id" name="id">
                                
                                <label for="edit_email">Email:</label>
                                <input type="email" id="edit_email" name="email" required>

                                <label for="edit_password">Password:</label>
                                <input type="password" id="edit_password" name="password" placeholder="Leave empty to keep current password">

                                <label for="edit_user_role">User Role:</label>
                                <select id="edit_user_role" name="user_role" required>
                                    <option value="cashier">Cashier</option>
                                    <option value="inventorykeeper">Inventory Keeper</option>
                                    <option value="branchmanager">Branch Manager</option>
                                    <option value="headmanager">Head Manager</option>
                                    <option value="admin">Admin</option>
                                </select>

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
                            <form action="<?php echo URLROOT; ?>/SysAdmin/deleteUser" method="POST">
                                <input type="hidden" id="delete_employee_id" name="employee_id">
                                <div class="buttons">
                                    <button type="submit" class="btn reset">Yes</button>
                                    <button type="button" class="btn submit" onclick="closeDeleteModal()">No</button>
                                </div>
                            </form>
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
                                        <th>User ID</th>
                                        <th>Email</th>
                                        <th>User Role</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['users'] as $user): ?>
                                        <tr>
                                            <td><?php echo $user->id; ?></td>
                                            <td><?php echo $user->email; ?></td>
                                            <td><?php echo $user->user_role; ?></td>
                                            <td><?php echo $user->created_at; ?></td>
                                            <td>
                                                <button class="btn edit-btn" 
                                                    onclick="editUser('<?php echo $user->id; ?>')"
                                                    data-id="<?php echo $user->id; ?>"
                                                    data-email="<?php echo $user->email; ?>"
                                                    data-role="<?php echo $user->user_role; ?>">
                                                    Edit
                                                </button>
                                                <button class="btn delete-btn" 
                                                    onclick="deleteUser('<?php echo $user->id; ?>')"
                                                    data-id="<?php echo $user->id; ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
