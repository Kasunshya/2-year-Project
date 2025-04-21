<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SysAdmin/EmployeeManagement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f1ec ;
        }

        /* Header Styling */
.header {
    background-color: var(--primary-color);
    color: var(--white);
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 10px;
    margin-left: 150px;
    margin-top:10px;
    margin-bottom: 20px;
    font-size: 1.5rem;
    font-weight: bold;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 50px;
    font-size: 1.8rem;
}

.header-left i {
    font-size: 2rem;
    color: var(--white);
}

.header-role {
    font-size: 1.2rem;
    font-weight: normal;
    color: var(--white);
    text-align: right;
}

        /* Main content styles */
        .content {
            margin-left: 150px; /* Matches sidebar width */
            padding: 20px;
            width: calc(100% - 250px);
        }

        .btn {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #c98d83;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: #783b31;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #c98d83;
            color: white;
        }

        table td {
            background-color: #ffff;

        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 40%; /* Adjust width as needed */
            max-width: 500px;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal-content h2 {
            margin-bottom: 15px;
            color: #783b31;
        }

        .modal-content p {
            margin-bottom: 20px;
            color: #333;
        }

        .modal-content .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #783b31;
        }

        .modal-content .close:hover {
            color: #c98d83;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .buttons .btn {
            flex: 1;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
        }

        .buttons .btn.submit {
            background-color: #c98d83;
            color: white;
        }

        .buttons .btn.submit:hover {
            background-color: #783b31;
        }

        .buttons .btn.reset {
            background-color: #f44336;
            color: white;
        }

        .buttons .btn.reset:hover {
            background-color: #d32f2f;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-bar input {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .search-bar button {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #c98d83;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #783b31;
        }

        .modal-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #783b31;
            text-align: left; /* Align labels to the left */
        }

        .modal-content input,
        .modal-content select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

        <header class="header">
                <div class="header-left">
                    <i class="fas fa-user"></i>
                    <span>Employee Management</span>
                </div>
                <div class="header-role">
                    <span>System Administrator</span>
                </div>
            </header>

    
        <div class="content">
            <div class="search-bar">
                <input type="text" id="searchEmployeeInput" placeholder="Search Employee by ID">
                <button onclick="searchEmployee()">Search</button>
            </div>
            <button class="btn" onclick="openAddModal()">+ Add Employee</button>
            <table>
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Full Name</th>
                        <th>NIC</th>
                        <th>Address</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>Branch</th>
                        <th>User Role</th>
                        <th>CV</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTable">
                    <?php foreach($data['employees'] as $employee): ?>
                    <tr data-dob="<?php echo $employee->dob; ?>" data-join-date="<?php echo $employee->join_date; ?>">
                        <td><?php echo $employee->employee_id; ?></td>
                        <td><?php echo $employee->full_name; ?></td>
                        <td><?php echo $employee->nic; ?></td>
                        <td><?php echo $employee->address; ?></td>
                        <td><?php echo $employee->contact_no; ?></td>
                        <td><?php echo $employee->email; ?></td>
                        <td><?php echo $employee->branch; ?></td>
                        <td><?php echo $employee->user_role; ?></td>
                        <td>
                            <?php if (!empty($employee->cv_upload)): ?>
                                <a href="<?php echo URLROOT . '/uploads/' . $employee->cv_upload; ?>" download>Download CV</a>
                            <?php else: ?>
                                No CV Uploaded
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <button class="btn" onclick="openEditModal(<?php echo $employee->employee_id; ?>)">Edit</button>
                            <button class="btn delete-btn" onclick="deleteEmployee(<?php echo $employee->employee_id; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Employee Modal -->
        <div class="modal" id="addEmployeeModal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addEmployeeModal')">&times;</span>
                <h2>Add New Employee</h2>
                <form action="<?php echo URLROOT; ?>/sysadmin/addEmployee" method="POST" enctype="multipart/form-data">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" required>

                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" required>

                    <label for="contact_no">Contact Number:</label>
                    <input type="text" name="contact_no" id="contact_no" required>

                    <label for="nic">NIC:</label>
                    <input type="text" name="nic" id="nic" required>

                    <label for="dob">Date of Birth:</label>
                    <input type="date" name="dob" id="dob" required>

                    <label for="gender">Gender:</label>
                    <select name="gender" id="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>

                    <label for="join_date">Join Date:</label>
                    <input type="date" name="join_date" id="join_date" required>

                    <label for="cv_upload">Upload CV:</label>
                    <input type="file" name="cv_upload" id="cv_upload">

                    <label for="branch_id">Branch:</label>
                    <select name="branch_id" id="branch_id" required>
                        <option value="">Select Branch</option>
                        <option value="1">Branch 1</option>
                        <option value="2">Branch 2</option>
                        <!-- Add more branches as needed -->
                    </select>

                    <label for="user_role">User Role:</label>
                    <select name="user_role" id="user_role" required>
                        <option value="cashier">Cashier</option>
                        <option value="branchmanager">Branch Manager</option>
                        <option value="headmanager">Head Manager</option>
                    </select>

                    <button type="submit" class="btn submit">Add Employee</button>
                </form>
            </div>
        </div>

        <!-- Edit Employee Modal -->
        <div id="editEmployeeModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editEmployeeModal')">&times;</span>
                <h2>Edit Employee</h2> <!-- Updated title -->
                <form id="editEmployeeForm" action="<?php echo URLROOT; ?>/sysadmin/updateEmployee" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="employee_id" id="edit_employee_id">

                    <label for="edit_full_name">Full Name:</label>
                    <input type="text" name="full_name" id="edit_full_name" required>

                    <label for="edit_address">Address:</label>
                    <input type="text" name="address" id="edit_address" required>

                    <label for="edit_contact_no">Contact Number:</label>
                    <input type="text" name="contact_no" id="edit_contact_no" required>

                    <label for="edit_nic">NIC:</label>
                    <input type="text" name="nic" id="edit_nic" required>

                    <label for="edit_dob">Date of Birth:</label>
                    <input type="date" name="dob" id="edit_dob" required>

                    <label for="edit_gender">Gender:</label>
                    <select name="gender" id="edit_gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>

                    <label for="edit_email">Email:</label>
                    <input type="email" name="email" id="edit_email" required>

                    <label for="edit_password">Password (Leave blank to keep unchanged):</label>
                    <input type="password" name="password" id="edit_password">

                    <label for="edit_join_date">Join Date:</label>
                    <input type="date" name="join_date" id="edit_join_date" required>

                    <label for="edit_cv_upload">Upload CV (Leave blank to keep unchanged):</label>
                    <input type="file" name="cv_upload" id="edit_cv_upload">

                    <label for="edit_branch_id">Branch:</label>
                    <select name="branch_id" id="edit_branch_id" required>
                        <!-- Branch options will be populated dynamically -->
                    </select>

                    <label for="edit_user_role">User Role:</label>
                    <select name="user_role" id="edit_user_role" required>
                        <option value="cashier">Cashier</option>
                        <option value="branchmanager">Branch Manager</option>
                        <option value="headmanager">Head Manager</option>
                    </select>

                    <button type="submit" class="btn submit">Update Employee</button>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal" id="deleteEmployeeModal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('deleteEmployeeModal')">&times;</span>
                <h2>Are you sure?</h2>
                <p>This action will permanently delete the employee and their user account. Do you want to proceed?</p>
                <div class="buttons">
                    <button class="btn submit" id="confirmDeleteButton">Yes, Delete</button>
                    <button class="btn reset" onclick="closeModal('deleteEmployeeModal')">Cancel</button>
                </div>
            </div>
        </div>
    </div>

        
        <script>
            function searchEmployee() {
                const input = document.getElementById('searchEmployeeInput').value.trim();
                const table = document.getElementById('employeeTable');
                const rows = table.getElementsByTagName('tr');
                let found = false;

                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    if (cells.length > 0) {
                        const employeeId = cells[0].textContent || cells[0].innerText;
                        if (employeeId === input) {
                            rows[i].style.display = '';
                            found = true;
                        } else {
                            rows[i].style.display = 'none';
                        }
                    }
                }

                if (!found) {
                    alert('No employee found with the given ID.');
                }
            }

            function openAddModal() {
                document.getElementById('addEmployeeModal').style.display = 'block';
            }

            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }

            function openEditModal(employeeId) {
                fetch(`<?php echo URLROOT; ?>/sysadmin/getEmployeeDetails/${employeeId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            // Populate the form fields with the employee data
                            document.getElementById('edit_employee_id').value = data.employee_id;
                            document.getElementById('edit_full_name').value = data.full_name;
                            document.getElementById('edit_address').value = data.address;
                            document.getElementById('edit_contact_no').value = data.contact_no;
                            document.getElementById('edit_nic').value = data.nic;
                            document.getElementById('edit_dob').value = data.dob;
                            document.getElementById('edit_email').value = data.email;
                            document.getElementById('edit_join_date').value = data.join_date;

                            // Pre-select gender
                            document.getElementById('edit_gender').value = data.gender;

                            // Populate branch dropdown
                            fetch(`<?php echo URLROOT; ?>/sysadmin/getBranches`)
                                .then(response => response.json())
                                .then(branches => {
                                    const branchSelect = document.getElementById('edit_branch_id');
                                    branchSelect.innerHTML = ''; // Clear existing options
                                    branches.forEach(branch => {
                                        const option = document.createElement('option');
                                        option.value = branch.branch_id;
                                        option.textContent = branch.branch_name;
                                        if (branch.branch_id == data.branch) {
                                            option.selected = true;
                                        }
                                        branchSelect.appendChild(option);
                                    });
                                });

                            // Pre-select user role
                            document.getElementById('edit_user_role').value = data.user_role;

                            // Show the modal
                            document.getElementById('editEmployeeModal').style.display = 'block';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function deleteEmployee(employeeId) {
                // Open the delete confirmation modal
                openModal('deleteEmployeeModal');

                // Set up the confirm delete button
                const confirmDeleteButton = document.getElementById('confirmDeleteButton');
                confirmDeleteButton.onclick = function () {
                    fetch(`<?php echo URLROOT; ?>/sysadmin/deleteEmployee/${employeeId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const table = document.getElementById('employeeTable');
                                const rows = table.getElementsByTagName('tr');
                                for (let i = 0; i < rows.length; i++) {
                                    const cells = rows[i].getElementsByTagName('td');
                                    if (cells.length > 0 && cells[0].textContent === employeeId.toString()) {
                                        rows[i].remove();
                                        break;
                                    }
                                }
                                alert(`Employee ${employeeId} deleted successfully.`);
                            } else {
                                alert('Failed to delete the employee.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting the employee.');
                        })
                        .finally(() => {
                            closeModal('deleteEmployeeModal');
                        });
                };
            }

            function openModal(modalId) {
                document.getElementById(modalId).style.display = 'block';
            }

            window.onclick = function(event) {
                const modals = document.getElementsByClassName('modal');
                for (let i = 0; i < modals.length; i++) {
                    if (event.target === modals[i]) {
                        modals[i].style.display = 'none';
                    }
                }
            };
        </script>
</body>
</html>