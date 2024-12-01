<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Branch Managers</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT.'/views/HeadM/inc/sidebar.php'; ?>

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
                            <input type="text" id="branchmanager_name" name="branchmanager_name" required
                                pattern="[A-Za-z\s]+">

                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" required pattern="[A-Za-z\s]{2,}">


                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required
                                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}">

                            <label for="contact_number">Contact Number:</label>
                            <input type="text" id="contact_number" name="contact_number" required pattern="[0-9]+">

                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">

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
                            <h2>Update Branch Manager</h2>
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
                                <input type="text" id="edit_branchmanager_name" name="branchmanager_name" required
                                    pattern="[A-Za-z\s]+" title="Please enter a valid name">

                                <label for="edit_address">Address:</label>
                                <input type="text" id="edit_address" name="address" required pattern="[A-Za-z\s]+"
                                    title="Please enter a valid address">

                                <!--label for="edit_email">Email:</label-->
                                <!--input type="email" id="edit_email" name="email" required-->

                                <label for="edit_contact_number">Contact Number:</label>
                                <input type="text" id="edit_contact_number" name="contact_number" required
                                    pattern="[0-9]+">

                                <label for="edit_password">Password (leave empty to keep current):</label>
                                <input type="password" id="edit_password" name="password">

                                <div class="buttons">
                                    <button type="reset" class="btn reset">Reset</button>
                                    <button type="submit" name="submit" class="btn submit">Update Branch
                                        Manager</button>
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
                                    <!--th>Email</th-->
                                    <th>Contact Number</th>
                                    <th>Update/Delete</th>
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
                                        <!--td><!-?php echo $branchManager->email; ?></td-->
                                        <td><?php echo $branchManager->contact_number; ?></td>
                                        <td>
                                            <button class="btn edit"
                                                onclick="editEmployee(<?php echo $branchManager->branchmanager_id; ?>)">Update</button>
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