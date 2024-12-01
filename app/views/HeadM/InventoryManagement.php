<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Inventory Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT . '/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-warehouse icon-inventory"></i>&nbsp INVENTORY</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">
                <button class="btn">+ Add New Item</button>
                <!-- Add employee Modal -->
                <div id="employeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New employee</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <label for="first_Name">First Name:</label>
                            <input type="text" id="first_Name" name="first_Name" required pattern="[A-Za-z]{1,}"
                                title="Please enter a valid first name(letters only)">

                            <label for="last_Name">Last Name:</label>
                            <input type="text" id="last_Name" name="last_Name" required pattern="[A-Za-z]{1,}"
                                title="Please enter a valid last name(letters only)">

                            <label for="user_Name">User Name:</label>
                            <input type="text" id="user_Name" name="user_Name" required pattern="[A-Za-z0-9]{1,}"
                                title="Please enter a valid user name(letters and numbers only)">

                            <label for="employee_Password">Password:</label>
                            <input type="password" id="employee_Password" name="employee_Password" required
                                pattern="[A-Za-z0-9]{1,}"
                                title="Please enter a valid password(letters and numbers only)">

                            <label for="contact_Number">Contact No:</label>
                            <input type="text" id="contact_Number" name="contact_Number" required pattern="[0-9]{10}"
                                title="Please enter a 10-digit contact number">

                            <div class="buttons">
                                <button type="reset" class="btn reset">Reset</button>
                                <button type="submit" name="add_employee" class="btn submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit employee Modal -->
                <div id="editemployeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Edit Employee</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="hidden" id="edit_employee_ID" name="employee_ID">
                            <label for="edit_first_Name">First Name:</label>
                            <input type="text" id="edit_first_Name" name="first_Name" required>

                            <label for="edit_last_Name">Last Name:</label>
                            <input type="text" id="edit_last_Name" name="last_Name" required>

                            <label for="edit_user_Name">User Name:</label>
                            <input type="text" id="edit_user_Name" name="user_Name" required>

                            <label for="edit_employee_Password">Password:</label>
                            <input type="password" id="edit_employee_Password" name="employee_Password" required>

                            <label for="edit_contact_Number">Contact No:</label>
                            <input type="text" id="edit_contact_Number" name="contact_Number" required>

                            <div class="buttons">
                                <button type="submit" name="edit_employee" class="btn submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="deleteemployeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Delete employee</h2>
                        <p>Are you sure you want to delete this employee?</p>
                        <div class="buttons">
                            <button type="submit" id="confirmDelete" class="btn reset">Yes</button>
                            <button type="reset" class="btn submit">No</button>
                        </div>
                    </div>
                </div>

                <div class="employee-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by User Name">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>Price(1kg)</th>
                                    <th>Status</th>
                                    <th>Expiry Date</th>
                                    <th>Total</th>
                                    <th>Edit/Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>I001</td>
                                    <td>Wheat Flour</td>
                                    <td>100kg</td>
                                    <td>Rs. 100</td>
                                    <td>Available</td>
                                    <td>2022-12-31</td>
                                    <td>Rs. 10000</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>I002</td>
                                    <td>Sugar</td>
                                    <td>50kg</td>
                                    <td>Rs. 80</td>
                                    <td>Available</td>
                                    <td>2022-12-31</td>
                                    <td>Rs. 4000</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>I003</td>
                                    <td>Tea Leaves</td>
                                    <td>20kg</td>
                                    <td>Rs. 200</td>
                                    <td>Available</td>
                                    <td>2022-12-31</td>
                                    <td>Rs. 4000</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>I004</td>
                                    <td>Butter</td>
                                    <td>10kg</td>
                                    <td>Rs. 150</td>
                                    <td>Available</td>
                                    <td>2022-12-31</td>
                                    <td>Rs. 1500</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>I005</td>
                                    <td>Milk</td>
                                    <td>50kg</td>
                                    <td>Rs. 50</td>
                                    <td>Available</td>
                                    <td>2022-12-31</td>
                                    <td>Rs. 2500</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>I006</td>
                                    <td>Yogurt</td>
                                    <td>20kg</td>
                                    <td>Rs. 60</td>
                                    <td>Available</td>
                                    <td>2022-12-31</td>
                                    <td>Rs. 1200</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/InventoryManagement.js"></script>

</body>

</html>