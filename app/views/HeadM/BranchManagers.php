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
        <?php require_once APPROOT . '/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-user-tie icon-branch-manager"></i> Branch Managers</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">


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
                                pattern="[A-Za-z\s]+" title="Name should only contain letters and spaces">

                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" required pattern="^[A-Za-z0-9\s,.-/]{5,100}$"
                                title="Address should only contain letters, numbers, spaces, and special characters">


                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required
                                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}"
                                title="Please enter a valid email address">

                            <label for="contact_number">Contact Number:</label>
                            <input type="text" id="contact_number" name="contact_number" required pattern="[0-9]{10}"
                                title="Contact number should be 10 digits">

                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                title="Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit">

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
                        <form method="GET" action="<?php echo URLROOT; ?>/HeadM/branchManager" class="search-form">
                            <div class="search-field">
                                <input type="text" name="search" placeholder="Search by Manager Name"
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <select name="branch_id">
                                    <option value="">All Branches</option>
                                    <?php foreach ($data['branches'] as $branch): ?>
                                        <option value="<?php echo $branch->branch_id; ?>" <?php echo (isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->branch_id) ? 'selected' : ''; ?>>
                                            <?php echo $branch->branch_name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i> Search
                            </button>
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
                                    pattern="[A-Za-z\s]+" title="Name should only contain letters and spaces">

                                <label for="edit_address">Address:</label>
                                <input type="text" id="edit_address" name="address" required
                                    pattern="^[A-Za-z0-9\s,.-/]{5,100}$" title="Please enter a valid address">

                                <!--label for="edit_email">Email:</label-->
                                <!--input type="email" id="edit_email" name="email" required-->

                                <label for="edit_contact_number">Contact Number:</label>
                                <input type="text" id="edit_contact_number" name="contact_number" required
                                    pattern="[0-9]{10}" title="Please enter a valid 10-digit contact number">

                                <label for="edit_password">Password (leave empty to keep current):</label>
                                <input type="password" id="edit_password" name="password"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.">

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
                                    <th>Manager Name</th>
                                    <th>Address</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <th>CV</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['branchManagers'])): ?>
                                    <?php foreach ($data['branchManagers'] as $branchManager): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($branchManager->branchmanager_id); ?></td>
                                            <td><?php echo htmlspecialchars($branchManager->branch_name); ?></td>
                                            <td><?php echo htmlspecialchars($branchManager->branchmanager_name); ?></td>
                                            <td><?php echo htmlspecialchars($branchManager->address); ?></td>
                                            <td><?php echo htmlspecialchars($branchManager->contact_no); ?></td>
                                            <td><?php echo htmlspecialchars($branchManager->employee_email); ?></td>
                                            <td>
                                                <?php if (!empty($branchManager->cv_upload)): ?>
                                                    <a href="<?php echo URLROOT; ?>/HeadM/downloadCV/<?php echo $branchManager->employee_id; ?>"
                                                        class="btn download-cv">
                                                        <i class="fas fa-download"></i> Download CV
                                                    </a>
                                                <?php else: ?>
                                                    <span>No CV available</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No branch managers found.</td>
                                    </tr>
                                <?php endif; ?>
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