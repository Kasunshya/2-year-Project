<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Branch Managers</title>
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
                    <li><a href="<?php echo URLROOT; ?>/HeadM/cashierManagement"><i
                                class="fas fa-cash-register icon-cashier"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/productManagement"><i
                                class="fas fa-birthday-cake"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/inventoryManagement"><i
                                class="fas fa-warehouse icon-inventory"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/branchManager"><i
                                class="fas fa-user-tie icon-branch-manager"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/customization"><i class="fas fa-palette"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/viewOrder"><i class="fas fa-clipboard-list"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/preOrder"><i class="fas fa-clock"></i></a></li>
                    <li><a href="<?php echo URLROOT; ?>/HeadM/dailyBranchOrder"><i
                                class="fas fa-calendar-check"></i></a></li>
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
                <h1><i class="fas fa-user-tie icon-branch-manager"></i> BRANCH MANAGERS</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">
                <button class="btn add-employee">+ Add New Branch Manager</button>

                <!-- Add employee Modal -->
                <div id="employeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New Branch Manager</h2>
                        <form action="<?php echo URLROOT; ?>/HeadM/addBranchManager" method="post">
                            <label for="branch_id">Branch:</label>
                            <select id="branch_id" name="branch_id" required>
                                <?php foreach ($data['branches'] as $branch): ?>
                                    <option value="<?php echo $branch->branch_id; ?>"><?php echo $branch->branch_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <label for="branchmanager_name">Name:</label>
                            <input type="text" id="branchmanager_name" name="branchmanager_name" required>

                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" required>

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>

                            <label for="contact_number">Contact Number:</label>
                            <input type="text" id="contact_number" name="contact_number" required>

                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required>

                            <div class="buttons">
                                <button type="reset" class="btn reset">Reset</button>
                                <button type="submit" name="submit" class="btn submit">Add Branch Manager</button>
                            </div>
                        </form>
                    </div>
                </div>



                <!-- Delete Confirmation Modal -->
                <div id="deleteemployeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Delete Branch Manager</h2>
                        <p>Are you sure you want to delete this Branch Manager?</p>
                        <form action="<?php echo URLROOT; ?>/HeadM/deleteBranchManager" method="post">
                            <input type="hidden" id="delete_branchmanager_id" name="branchmanager_id">
                            <div class="buttons">
                                <button type="submit" class="btn reset">Yes, Delete</button>
                                <button type="button" class="btn submit"
                                    onclick="document.getElementById('deleteemployeeModal').style.display='none'">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="employee-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by User Name">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <!-- Edit employee Modal -->
                    <div id="editemployeeModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Edit Branch Manager</h2>
                                                        <form action="<?php echo URLROOT; ?>/HeadM/editBranchManager" method="post">
                                                            <input type="hidden" id="edit_branchmanager_id" name="branchmanager_id">
                                                            <input type="hidden" id="edit_user_id" name="user_id">
                                
                                                            <label for="edit_branch_id">Branch:</label>
                                                            <select id="edit_branch_id" name="branch_id" required>
                                                                <?php foreach ($data['branches'] as $branch): ?>
                                                                    <option value="<?php echo $branch->branch_id; ?>">
                                                                        <?php echo $branch->branch_name; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>

                                                            <label for="edit_branchmanager_name">Name:</label>
                                                            <input type="text" id="edit_branchmanager_name" name="branchmanager_name" required>

                                                            <label for="edit_address">Address:</label>
                                                            <input type="text" id="edit_address" name="address" required>

                                                            <label for="edit_email">Email:</label>
                                                            <input type="email" id="edit_email" name="email" required>

                                                            <label for="edit_contact_number">Contact Number:</label>
                                                            <input type="text" id="edit_contact_number" name="contact_number" required>

                                                            <label for="edit_password">Password (leave empty to keep current):</label>
                                                            <input type="password" id="edit_password" name="password">

                                                            <div class="buttons">
                                                                <button type="submit" class="btn submit">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                    <!-- Table to display branch managers -->
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Branch Manager ID</th>
                                    <th>Branch Name</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Edit/Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['branchManagers'] as $branchManager): ?>
                                    <tr data-id="<?php echo $branchManager->branchmanager_id; ?>">
                                        <td><?php echo $branchManager->branchmanager_id; ?></td>
                                        <td data-user-id="<?php echo $branchManager->user_id; ?>"
                                            data-branch-id="<?php echo $branchManager->branch_id; ?>">
                                            <?php echo $branchManager->branch_name; ?>
                                        </td>
                                        <td><?php echo $branchManager->branchmanager_name; ?></td>
                                        <td><?php echo $branchManager->address; ?></td>
                                        <td><?php echo $branchManager->email; ?></td>
                                        <td><?php echo $branchManager->contact_number; ?></td>
                                        <td>
                                            <button class="btn edit"
                                                onclick="editEmployee(<?php echo $branchManager->branchmanager_id; ?>)">Edit</button>
                                            <button class="btn delete"
                                                onclick="deleteEmployee(<?php echo $branchManager->branchmanager_id; ?>)">Delete</button>
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
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/BranchManagers.js"></script>
</body>

</html>