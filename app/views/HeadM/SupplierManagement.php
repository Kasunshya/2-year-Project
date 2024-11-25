<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Supplier Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/SupplierManagement.css">
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
                    <li><a href="<?php echo URLROOT; ?>/HeadM/supplierManagement"><i class="fas fa-truck"></i></a></li>
                    <li><a href="#"><i class="fas fa-birthday-cake"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/inventoryManagement"><i class="fas fa-warehouse icon-inventory"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/branchManager"><i class="fas fa-user-tie icon-branch-manager"></i></a></li>
                    <li><a href="#"><i class="fas fa-clipboard-list icon-order"></i></a></li>
                </ul>
                </nav>
                <div class="logout">
                    <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </aside>

            <!-- Main Content -->
            <main>
                <header class="header">
                    <h1><i class="fas fa-truck"></i> Suppliers</h1>
                    <div class="user-info">
                        <span>Head Manager</span>
                    </div>
                </header>
                <div class="content">
                <button class="btn">+ Add New Supplier</button>
                <!-- Add employee Modal -->
                <div id="employeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New employee</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <label for="first_Name">First Name:</label>
                            <input type="text" id="first_Name" name="first_Name" required pattern="[A-Za-z]{1,}" title="Please enter a valid first name(letters only)">

                            <label for="last_Name">Last Name:</label>
                            <input type="text" id="last_Name" name="last_Name" required pattern="[A-Za-z]{1,}" title="Please enter a valid last name(letters only)">

                            <label for="user_Name">User Name:</label>
                            <input type="text" id="user_Name" name="user_Name" required pattern="[A-Za-z0-9]{1,}" title="Please enter a valid user name(letters and numbers only)">

                            <label for="employee_Password">Password:</label>
                            <input type="password" id="employee_Password" name="employee_Password" required pattern="[A-Za-z0-9]{1,}" title="Please enter a valid password(letters and numbers only)">

                            <label for="contact_Number">Contact No:</label>
                            <input type="text" id="contact_Number" name="contact_Number" required pattern="[0-9]{10}" title="Please enter a 10-digit contact number">

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
                                    <th>Supplier ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Company Name</th>
                                    <th>Password</th>
                                    <th>Created At</th>
                                    <th>Edit/Delete</th>
                                </tr>
                            </thead>
                            <tbody>                      
                                <tr>
                                    <td>S001</td>
                                    <td>Lalitra</td>
                                    <td>lali@gmail.com</td>
                                    <td>0777891234</td>
                                    <td>Lali Bakery</td>
                                    <td>lalitra123</td>
                                    <td>2023-08-20 10:30:00</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>S002</td>
                                    <td>Saman</td>
                                    <td>saman@gmail.com</td>
                                    <td>0777891234</td>
                                    <td>Saman Bakery</td>
                                    <td>saman12</td>
                                    <td>2023-08-20 10:30:00</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>S003</td>
                                    <td>Chamara</td>
                                    <td>chamara@gmail.com</td>
                                    <td>0777891234</td>
                                    <td>Chamara Bakery</td>
                                    <td>chamara123</td>
                                    <td>2023-08-20 10:30:00</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>S004</td>
                                    <td>Tharindu</td>
                                    <td>tharindu@gmail.com</td>
                                    <td>0777891234</td>
                                    <td>Tharindu Bakery</td>
                                    <td>tharindu123</td>
                                    <td>2023-08-20 10:30:00</td>
                                    <td>
                                        <button class="btn edit">Edit</button>
                                        <button class="btn delete">Delete</button>
                                    </td>       
                            </tbody>
                        </table>
                    </div>

                </>
            </div>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/SupplierManagement.js"></script>

</body>
</html>
