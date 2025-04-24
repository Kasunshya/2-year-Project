<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SysAdmin/EmployeeManagement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
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
            <!-- Updated Professional Search Bar -->
<div class="search-bar">
    <form id="searchForm" method="GET" action="<?php echo URLROOT; ?>/sysadmin/employeeManagement" class="search-form">
        <div class="search-field">
            <input type="text" name="search" id="searchInput" placeholder="Search by name or email" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        </div>
        
        <div class="search-field">
            <select name="branch" id="branchFilter">
                <option value="">All Branches</option>
                <?php foreach ($data['branches'] as $branch): ?>
                    <option value="<?php echo $branch->branch_id; ?>" <?php echo (isset($_GET['branch']) && $_GET['branch'] == $branch->branch_id) ? 'selected' : ''; ?>>
                        <?php echo $branch->branch_name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="search-btn">
            <i class="fas fa-search"></i> Search
        </button>
        
        <a href="<?php echo URLROOT; ?>/sysadmin/employeeManagement" class="filter-btn">
            Reset
        </a>
    </form>
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
                        <td><?php echo $employee->branch_name;?></td>
                        <td><?php echo $employee->user_role; ?></td>
                        <td>
    <?php if (!empty($employee->cv_upload)): ?>
        <a href="<?php echo URLROOT . '/uploads/' . $employee->cv_upload; ?>" download class="btn download-cv" style="background-color: #c98d83; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; font-size: 0.9rem;">
            <i class="fas fa-download" style="margin-right: 5px;"></i>Download CV
        </a>
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
                <form action="<?php echo URLROOT; ?>/sysadmin/addEmployee" method="POST" enctype="multipart/form-data" onsubmit="return validateAddEmployeeForm()">
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
    <!-- Branch options will be populated dynamically -->
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
                <form id="editEmployeeForm" action="<?php echo URLROOT; ?>/sysadmin/updateEmployee" method="POST" enctype="multipart/form-data" onsubmit="return validateEditEmployeeForm()">
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
    // Add this before your existing script functions

    // Function to validate email format
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Function to validate NIC format (Sri Lankan)
    function isValidNIC(nic) {
        // Accept both old (9 digits + V/X) and new (12 digits) NIC formats
        const oldNICRegex = /^[0-9]{9}[VvXx]$/;
        const newNICRegex = /^[0-9]{12}$/;
        return oldNICRegex.test(nic) || newNICRegex.test(nic);
    }
    
    // Function to validate phone number
    function isValidPhone(phone) {
        // Allow +94 format or 0 starting 10 digit numbers
        const phoneRegex = /^(?:\+94|0)[0-9]{9}$/;
        return phoneRegex.test(phone);
    }
    
    // Function to validate the Add Employee form
    function validateAddEmployeeForm() {
        const fullName = document.getElementById('full_name').value.trim();
        const address = document.getElementById('address').value.trim();
        const contactNo = document.getElementById('contact_no').value.trim();
        const nic = document.getElementById('nic').value.trim();
        const dob = document.getElementById('dob').value;
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const joinDate = document.getElementById('join_date').value;
        const branchId = document.getElementById('branch_id').value;
        const userRole = document.getElementById('user_role').value;
        
        // Basic field validations
        if (fullName === '' || address === '' || contactNo === '' || nic === '' || 
            dob === '' || email === '' || password === '' || joinDate === '' || 
            branchId === '' || userRole === '') {
            alert('All fields are required');
            return false;
        }
        
        // Email format validation
        if (!isValidEmail(email)) {
            alert('Please enter a valid email address');
            return false;
        }
        
        // NIC format validation
        if (!isValidNIC(nic)) {
            alert('Please enter a valid NIC number');
            return false;
        }
        
        // Phone number validation
        if (!isValidPhone(contactNo)) {
            alert('Please enter a valid contact number (format: 0XXXXXXXXX or +94XXXXXXXXX)');
            return false;
        }
        
        // Password strength validation
        if (password.length < 8) {
            alert('Password must be at least 8 characters long');
            return false;
        }
        
        // Date validations
        const currentDate = new Date();
        const dobDate = new Date(dob);
        const joinDateObj = new Date(joinDate);
        
        // Check if person is at least 18 years old
        const minAge = 18;
        const ageDate = new Date(currentDate - dobDate);
        const age = Math.abs(ageDate.getUTCFullYear() - 1970);
        
        if (age < minAge) {
            alert(`Employee must be at least ${minAge} years old`);
            return false;
        }
        
        // Join date cannot be in the future
        if (joinDateObj > currentDate) {
            alert('Join date cannot be in the future');
            return false;
        }
        
        // Join date should be after birth date + 18 years
        const minJoinDate = new Date(dobDate);
        minJoinDate.setFullYear(minJoinDate.getFullYear() + minAge);
        
        if (joinDateObj < minJoinDate) {
            alert('Join date must be after person is 18 years old');
            return false;
        }

        // Check branch manager uniqueness via AJAX before submitting
        if (userRole === 'branchmanager') {
            // We'll use a synchronous AJAX call for simplicity
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `<?php echo URLROOT; ?>/sysadmin/checkBranchManagerExists/${branchId}`, false);
            xhr.send();
            
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    alert('This branch already has a Branch Manager assigned. Only one Branch Manager is allowed per branch.');
                    return false;
                }
            }
        }
        
        // Check email uniqueness via AJAX
        const emailXhr = new XMLHttpRequest();
        emailXhr.open('GET', `<?php echo URLROOT; ?>/sysadmin/checkEmailExists/${encodeURIComponent(email)}`, false);
        emailXhr.send();
        
        if (emailXhr.status === 200) {
            const response = JSON.parse(emailXhr.responseText);
            if (response.exists) {
                alert('This email address is already in use by another employee.');
                return false;
            }
        }
        
        // Check NIC uniqueness via AJAX
        const nicXhr = new XMLHttpRequest();
        nicXhr.open('GET', `<?php echo URLROOT; ?>/sysadmin/checkNicExists/${encodeURIComponent(nic)}`, false);
        nicXhr.send();
        
        if (nicXhr.status === 200) {
            const response = JSON.parse(nicXhr.responseText);
            if (response.exists) {
                alert('This NIC number is already in use by another employee.');
                return false;
            }
        }
        
        return true;
    }
    
    // Function to validate the Edit Employee form
    function validateEditEmployeeForm() {
        const employeeId = document.getElementById('edit_employee_id').value;
        const fullName = document.getElementById('edit_full_name').value.trim();
        const address = document.getElementById('edit_address').value.trim();
        const contactNo = document.getElementById('edit_contact_no').value.trim();
        const nic = document.getElementById('edit_nic').value.trim();
        const dob = document.getElementById('edit_dob').value;
        const email = document.getElementById('edit_email').value.trim();
        const password = document.getElementById('edit_password').value;
        const joinDate = document.getElementById('edit_join_date').value;
        const branchId = document.getElementById('edit_branch_id').value;
        const userRole = document.getElementById('edit_user_role').value;
        
        // Basic field validations (exclude password as it can be empty on edit)
        if (fullName === '' || address === '' || contactNo === '' || nic === '' || 
            dob === '' || email === '' || joinDate === '' || 
            branchId === '' || userRole === '') {
            alert('All fields except password are required');
            return false;
        }
        
        // Email format validation
        if (!isValidEmail(email)) {
            alert('Please enter a valid email address');
            return false;
        }
        
        // NIC format validation
        if (!isValidNIC(nic)) {
            alert('Please enter a valid NIC number');
            return false;
        }
        
        // Phone number validation
        if (!isValidPhone(contactNo)) {
            alert('Please enter a valid contact number (format: 0XXXXXXXXX or +94XXXXXXXXX)');
            return false;
        }
        
        // Password strength validation (only if password is being changed)
        if (password !== '' && password.length < 8) {
            alert('Password must be at least 8 characters long');
            return false;
        }
        
        // Date validations
        const currentDate = new Date();
        const dobDate = new Date(dob);
        const joinDateObj = new Date(joinDate);
        
        // Check if person is at least 18 years old
        const minAge = 18;
        const ageDate = new Date(currentDate - dobDate);
        const age = Math.abs(ageDate.getUTCFullYear() - 1970);
        
        if (age < minAge) {
            alert(`Employee must be at least ${minAge} years old`);
            return false;
        }
        
        // Join date cannot be in the future
        if (joinDateObj > currentDate) {
            alert('Join date cannot be in the future');
            return false;
        }
        
        // Join date should be after birth date + 18 years
        const minJoinDate = new Date(dobDate);
        minJoinDate.setFullYear(minJoinDate.getFullYear() + minAge);
        
        if (joinDateObj < minJoinDate) {
            alert('Join date must be after person is 18 years old');
            return false;
        }

        // Check branch manager uniqueness via AJAX before submitting
        if (userRole === 'branchmanager') {
            // We'll use a synchronous AJAX call for simplicity
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `<?php echo URLROOT; ?>/sysadmin/checkBranchManagerExistsExcept/${branchId}/${employeeId}`, false);
            xhr.send();
            
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    alert('This branch already has a Branch Manager assigned. Only one Branch Manager is allowed per branch.');
                    return false;
                }
            }
        }
        
        // Check email uniqueness via AJAX (excluding current employee)
        const emailXhr = new XMLHttpRequest();
        emailXhr.open('GET', `<?php echo URLROOT; ?>/sysadmin/checkEmailExistsExcept/${encodeURIComponent(email)}/${employeeId}`, false);
        emailXhr.send();
        
        if (emailXhr.status === 200) {
            const response = JSON.parse(emailXhr.responseText);
            if (response.exists) {
                alert('This email address is already in use by another employee.');
                return false;
            }
        }
        
        // Check NIC uniqueness via AJAX (excluding current employee)
        const nicXhr = new XMLHttpRequest();
        nicXhr.open('GET', `<?php echo URLROOT; ?>/sysadmin/checkNicExistsExcept/${encodeURIComponent(nic)}/${employeeId}`, false);
        nicXhr.send();
        
        if (nicXhr.status === 200) {
            const response = JSON.parse(nicXhr.responseText);
            if (response.exists) {
                alert('This NIC number is already in use by another employee.');
                return false;
            }
        }
        
        return true;
    }
    
    // Your existing functions below...

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

            // Modify your openAddModal() function to load branches
function openAddModal() {
    // Fetch branches and populate branch dropdown
    fetch(`<?php echo URLROOT; ?>/sysadmin/getBranches`)
        .then(response => response.json())
        .then(branches => {
            const branchSelect = document.getElementById('branch_id');
            branchSelect.innerHTML = ''; // Clear existing options
            // Add a default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '-- Select Branch --';
            branchSelect.appendChild(defaultOption);
            // Add branches from database
            branches.forEach(branch => {
                const option = document.createElement('option');
                option.value = branch.branch_id;
                option.textContent = branch.branch_name;
                branchSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading branches:', error));
        
    // Show the modal
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