<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Customer Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/CustomerManagement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <b>
                    <li><a href="../Dashboard/Dashboard.php"><i class="fas fa-tachometer-alt"></i>&nbsp;Dashboard</a></li>
                    <li><a href="../Employee Management/EmployeeManagement.php"><i class="fas fa-users"></i>&nbsp;Employees</a></li>
                    <li><a href="#"><i class="fas fa-truck"></i>&nbsp;Suppliers</a></li>
                    <li><a href="../Product Management/ProductManagement.php"><i class="fas fa-box"></i>&nbsp;Inventory</a></li>
                    <li><a href="../Customer Management/CustomerManagement.php"><i class="fas fa-user"></i>&nbsp;Customers</a></li>
                    <li><a href="#"><i class="fas fa-shopping-cart"></i>&nbsp;Orders</a></li>
                    </b>
                </ul>
            </nav>
            <div class="logo">
                <img src="<?php echo URLROOT; ?>/public/img/HeadM/FrostineLogo.png" alt="Frostine Logo">
            </div>
        </aside>
        <main>
            <header>
                <h1><i class="fas fa-user"></i>&nbsp&nbsp;Customers</h1>
                <div class="user-info">
                    <span>Dasun Pathirana</span>
                    <span>(Head Manager)</span>
                </div>
            </header>
            <div class="content">
                <button class="add-customer">+ Add New Customer</button>
                <!-- Add Customer Modal -->
                <div id="customerModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New Customer</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <label for="customer_Name">Customer Name:</label>
                            <input type="text" id="customer_Name" name="customer_Name" required pattern="[a-zA-Z\s]+" title="Please enter a valid name (letters only)">

                            <label for="customer_Address">Address:</label>
                            <input type="text" id="customer_Address" name="customer_Address" required>

                            <label for="contact_Number">Contact No:</label>
                            <input type="text" id="contact_Number" name="contact_Number" required pattern="[0-9]{10}" title="Please enter a 10-digit contact number">

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
                            <label for="edit_customer_Name">Customer Name:</label>
                            <input type="text" id="edit_customer_Name" name="customer_Name" required>

                            <label for="edit_customer_Address">Address:</label>
                            <input type="text" id="edit_customer_Address" name="customer_Address" required>

                            <label for="edit_contact_Number">Contact No:</label>
                            <input type="text" id="edit_contact_Number" name="contact_Number" required>

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

                <div class="customer-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by Customer Name">
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
                                    <th>Update/Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($customer['customer_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['customer_Name']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['customer_Address']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['contact_Number']); ?></td>
                                    <td>
                                        <!--button class="edit-btn" data-id="<?php echo $customer['customer_ID']; ?>" data-name="<?php echo htmlspecialchars($customer['customer_Name']); ?>" data-address="<?php echo htmlspecialchars($customer['customer_Address']); ?>" data-contact="<?php echo htmlspecialchars($customer['contact_Number']); ?>">✏️</button-->
                                        <!--button class="delete-btn" data-id="<?php echo $customer['customer_ID']; ?>">🗑️</button-->
                                        <button class="edit-btn" data-id="<?php echo $customer['customer_ID']; ?>" data-name="<?php echo htmlspecialchars($customer['customer_Name']); ?>" data-address="<?php echo htmlspecialchars($customer['customer_Address']); ?>" data-contact="<?php echo htmlspecialchars($customer['contact_Number']); ?>"><i class="fas fa-edit icon"></i></button>
                                        <button class="delete-btn" data-id="<?php echo $customer['customer_ID']; ?>"><i class="fas fa-trash icon"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/CustomerManagement.js"></script>
</body>
</html>