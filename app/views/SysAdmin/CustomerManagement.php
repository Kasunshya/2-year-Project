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
        
        <?php require_once APPROOT.'/views/SysAdmin/SideNavBar.php'; ?>

        <div class="sub-container-2">
            <div class="header">
                <div class="user-info">
                    <div>
                        <span>SystemAdministrator</span>
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

                    <!-- Update Customer Modal -->
                    <div id="editCustomerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Update Customer</h2>
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
                                        <th>Update/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['customers'] as $customer): ?>
                                        <tr data-id="<?php echo $customer->customer_id; ?>">
                                            <td><?php echo $customer->customer_id; ?></td>
                                            <td><?php echo $customer->full_name; ?></td>
                                            <td><?php echo $customer->address; ?></td>
                                            <td><?php echo $customer->contact_no; ?></td>
                                            <td><?php echo $customer->email; ?></td>
                                            <td>
                                                <button class="btn edit-btn" 
                                                    data-id="<?php echo $customer->customer_id; ?>"
                                                    data-name="<?php echo $customer->full_name; ?>"
                                                    data-address="<?php echo $customer->address; ?>"
                                                    data-contact="<?php echo $customer->contact_no; ?>"
                                                    data-email="<?php echo $customer->email; ?>">
                                                    Update
                                                </button>
                                                <button class="btn delete-btn" 
                                                    data-id="<?php echo $customer->customer_id; ?>">
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
    <script src="<?php echo URLROOT; ?>/public/js/SystemAdmin/CustomerManagement.js"></script>
</body>
</html>