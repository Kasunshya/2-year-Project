<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SysAdmin/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <style>
        .employee-container {
            width: 90%;
            margin-left: 120px;
            margin-right: 30px;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #5d2e46;
            padding: 2rem;
            color: white;
            font-size: 2.5rem;
            text-transform: uppercase;
            margin-left: 120px;
            margin-right: 0px;
            border-radius: 5px;
            z-index: 1;
            text-align: left;
        }

        header i {
            margin-right: 10px;
            text-align: left;
            display: inline-block;
            vertical-align: middle;
        }

        body {
            background-color: #e8d7e5;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        table {
            width: 100%;
            min-width: 1200px;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px 0;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        table th:first-child {
            border-top-left-radius: 8px;
        }

        table th:last-child {
            border-top-right-radius: 8px;
        }

        table tr:last-child td:first-child {
            border-bottom-left-radius: 8px;
        }

        table tr:last-child td:last-child {
            border-bottom-right-radius: 8px;
        }

        table th {
            background-color: #a26b98;
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e0e0e0;
        }

        table tbody tr:hover {
            background-color: #f9f5f0;
        }

        .btn {
            background-color: #a26b98;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            
            font-size: 14px;
            margin-left: 100px
        }

        .btn:hover {
            background-color: #5d2e46;
        }

        .search-container {
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-input {
            padding: 8px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            width: 300px;
            margin-right: 0;
        }

        .btn-sm {
            padding: 5px 10px;
            margin: 0 5px;
            background-color: #a26b98;
            color: white;
            min-width: 100px; /* Set a minimum width */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-success {
            background-color: #28a745;
        }

        .table-container {
            overflow-x: auto;
            
            margin-left: 100px
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 8px;
            position: relative;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            cursor: pointer;
            color: #5d2e46;
        }

        .modal-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
            color: #5d2e46;
        }

        .modal-title {
            color: #5d2e46;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            color: #5d2e46;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: right;
        }

        .btn-outline {
            background-color: #6c757d;
            color: white;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
            background-color: #a26b98;
            color: white;
        }

        .cv-download {
            color: #a26b98;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .cv-download i {
            margin-right: 5px;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }

        .content {
            margin: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .status-badge.active {
            background-color: #28a745;
            color: white;
        }

        .status-badge.inactive {
            background-color: #dc3545;
            color: white;
        }

        .search-section {
            background-color: white;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
            margin-left: 100px
        }

        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: flex-end;
        }

        .search-field {
            flex: 1;
            min-width: 200px;
        }

        .search-field input,
        .search-field select {
            width: 100%;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .search-btn {
            background-color: #a26b98;
            margin: 0;
        }

        .reset-btn {
            background-color: #6c757d;
            margin: 0;
        }
    </style>
</head>
<body>
    <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

    <header>
        <h7><i class="fas fa-user-tie"></i>Employee Management</h7>
    </header>

    <div class="content">
        <?php flash('employee_message'); ?>
        
        <div class="search-section">
            <div class="search-bar">
                <form method="GET" action="<?php echo URLROOT; ?>/sysadmin/employeeManagement" class="search-form">
                    <div class="search-field">
                        <input type="text" name="search" placeholder="Search by Name or ID" 
                               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                    <div class="search-field">
                        <select name="branch_id">
                            <option value="">All Branches</option>
                            <?php foreach ($data['branches'] as $branch): ?>
                                <option value="<?php echo $branch->branch_id; ?>" <?php echo (isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->branch_id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($branch->branch_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="search-field">
                        <select name="status">
                            <option value="active" <?php echo (!isset($_GET['status']) || $_GET['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo (isset($_GET['status']) && $_GET['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            <option value="">All Status</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <button class="btn search-btn" type="submit"><i class="fas fa-search"></i> Search</button>
                        <a href="<?php echo URLROOT; ?>/sysadmin/employeeManagement" class="btn reset-btn"><i class="fas fa-times"></i> Reset</a>
                    </div>
                </form>
            </div>
        </div>
        
        <button class="btn" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Add Employee
        </button>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>NIC</th>
                        <th>Address</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>Branch</th>
                        <th>User Role</th>
                        <th>CV</th>
                        <th>Actions</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="employeeTable">
                    <?php foreach($data['employees'] as $employee): ?>
                    <tr data-dob="<?php echo $employee->dob; ?>" data-join-date="<?php echo $employee->join_date; ?>">
                        
                        <td><?php echo htmlspecialchars($employee->full_name); ?></td>
                        <td><?php echo htmlspecialchars($employee->nic); ?></td>
                        <td><?php echo htmlspecialchars($employee->address); ?></td>
                        <td><?php echo htmlspecialchars($employee->contact_no); ?></td>
                        <td><?php echo htmlspecialchars($employee->email); ?></td>
                        <td><?php echo htmlspecialchars($employee->branch_name ?? 'No Branch'); ?></td>
                        <td>
                            <span class="badge" style="background-color: var(--primary-light); color: var(--primary-dark); padding: 5px 10px; border-radius: var(--radius-md); font-weight: 500;">
                                <?php echo ucfirst(htmlspecialchars($employee->user_role)); ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($employee->cv_upload)): ?>
                                <a href="<?php echo URLROOT . '/uploads/' . $employee->cv_upload; ?>" download class="cv-download">
                                    <i class="fas fa-download"></i> Download CV
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No CV Uploaded</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <button class="btn btn-sm" onclick="openEditModal(<?php echo $employee->employee_id; ?>)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <?php if($employee->status === 'active'): ?>
                            <button class="btn btn-sm btn-danger" onclick="deactivateEmployee(<?php echo $employee->employee_id; ?>)">
                                <i class="fas fa-user-slash"></i> Deactivate
                            </button>
                            <?php else: ?>
                            <button class="btn btn-sm btn-success" onclick="reactivateEmployee(<?php echo $employee->employee_id; ?>)">
                                <i class="fas fa-user-check"></i> Activate
                            </button>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge <?php echo $employee->status; ?>">
                            <?php echo ucfirst(htmlspecialchars($employee->status ?? 'active')); ?>
                            </span>
                        </td>
                        
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


        <!-- Add Employee Modal -->
        <div class="modal" id="addEmployeeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-plus-circle"></i>
                        Add New Employee
                    </h3>
                    <button type="button" class="close" onclick="closeModal('addEmployeeModal')">&times;</button>
                </div>
                
                <form action="<?php echo URLROOT; ?>/sysadmin/addEmployee" method="POST" enctype="multipart/form-data" onsubmit="return validateAddEmployeeForm()">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="full_name">Full Name:</label>
                            <input type="text" class="form-control" name="full_name" id="full_name" 
                                   pattern="^[A-Za-z\s\-'\.]{3,50}$"
                                   title="Name can only contain letters, spaces, hyphens, apostrophes and periods (3-50 characters)"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="nic">NIC:</label>
                            <input type="text" class="form-control" name="nic" id="nic" 
                                   pattern="([0-9]{9}[VvXx]|[0-9]{12})"
                                   title="Enter a valid NIC format: 9 digits followed by V/X or 12 digits"
                                   required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="address">Address:</label>
                        <input type="text" class="form-control" name="address" id="address"
                               pattern="^[A-Za-z0-9\s\-\.,#'/]{5,100}$"
                               title="Enter a valid address (5-100 characters)"
                               required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="contact_no">Contact Number:</label>
                            <input type="text" class="form-control" name="contact_no" id="contact_no"
                                   pattern="(?:\+94|0)[0-9]{9}"
                                   title="Enter a valid phone number: starting with 0 or +94 followed by 9 digits"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="gender">Gender:</label>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="dob">Date of Birth:</label>
                            <input type="date" class="form-control" name="dob" id="dob" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="join_date">Join Date:</label>
                            <input type="date" class="form-control" name="join_date" id="join_date" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" 
                                   pattern="[^\s@]+@[^\s@]+\.[^\s@]+"
                                   title="Enter a valid email address"
                                   onblur="validateEmailUniquenessForNew(this.value)" required>
                            <span id="newEmailError" class="error-message"></span>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="password">Password:</label>
                            <input type="password" class="form-control" name="password" id="password"
                                   pattern=".{8,}"
                                   title="Password must be at least 8 characters long"
                                   required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="cv_upload">Upload CV:</label>
                        <input type="file" class="form-control" name="cv_upload" id="cv_upload">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="branch_id">Branch:</label>
                            <select class="form-select" name="branch_id" id="branch_id" required>
                                <option value="">Select Branch</option>
                                <?php if(isset($data['branches'])): ?>
                                    <?php foreach($data['branches'] as $branch): ?>
                                        <option value="<?php echo $branch->branch_id; ?>"><?php echo htmlspecialchars($branch->branch_name); ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">Branch 1</option>
                                    <option value="2">Branch 2</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="user_role">User Role:</label>
                            <select class="form-select" name="user_role" id="user_role" required>
                                <option value="cashier">Cashier</option>
                                <option value="branchmanager">Branch Manager</option>
                                <option value="headmanager">Head Manager</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('addEmployeeModal')">Cancel</button>
                        <button type="submit" class="btn">
                            <i class="fas fa-plus"></i> Add Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Employee Modal -->
        <div id="editEmployeeModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-edit"></i>
                        Edit Employee
                    </h3>
                    <button type="button" class="close" onclick="closeModal('editEmployeeModal')">&times;</button>
                </div>
                
                <form action="<?php echo URLROOT; ?>/sysadmin/updateEmployee" method="POST" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                    <input type="hidden" name="employee_id" id="edit_employee_id">

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="edit_full_name">Full Name:</label>
                            <input type="text" class="form-control" name="full_name" id="edit_full_name"
                                   pattern="^[A-Za-z\s\-'\.]{3,50}$"
                                   title="Name can only contain letters, spaces, hyphens, apostrophes and periods (3-50 characters)"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_nic">NIC:</label>
                            <input type="text" class="form-control" name="nic" id="edit_nic"
                                   pattern="([0-9]{9}[VvXx]|[0-9]{12})"
                                   title="Enter a valid NIC format: 9 digits followed by V/X or 12 digits"
                                   required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_address">Address:</label>
                        <input type="text" class="form-control" name="address" id="edit_address"
                               pattern="^[A-Za-z0-9\s\-\.,#'/]{5,100}$" 
                               title="Enter a valid address (5-100 characters)"
                               required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="edit_contact_no">Contact Number:</label>
                            <input type="text" class="form-control" name="contact_no" id="edit_contact_no"
                                   pattern="(?:\+94|0)[0-9]{9}"
                                   title="Enter a valid phone number: starting with 0 or +94 followed by 9 digits"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_gender">Gender:</label>
                            <select class="form-select" name="gender" id="edit_gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="edit_dob">Date of Birth:</label>
                            <input type="date" class="form-control" name="dob" id="edit_dob" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_join_date">Join Date:</label>
                            <input type="date" class="form-control" name="join_date" id="edit_join_date" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="edit_email">Email:</label>
                            <input type="email" class="form-control" name="email" id="edit_email"
                                   pattern="[^\s@]+@[^\s@]+\.[^\s@]+"
                                   title="Enter a valid email address"
                                   required>
                            <span id="emailError" class="error-message"></span>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_password">Password (Leave blank to keep unchanged):</label>
                            <input type="password" class="form-control" name="password" id="edit_password"
                                   pattern=".{8,}"
                                   title="Password must be at least 8 characters long">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_cv_upload">Upload CV (Leave blank to keep unchanged):</label>
                        <input type="file" class="form-control" name="cv_upload" id="edit_cv_upload">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="edit_branch_id">Branch:</label>
                            <select class="form-select" name="branch_id" id="edit_branch_id" required>
                                <!-- Branch options will be populated dynamically -->
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_user_role">User Role:</label>
                            <select class="form-select" name="user_role" id="edit_user_role" required>
                                <option value="cashier">Cashier</option>
                                <option value="branchmanager">Branch Manager</option>
                                <option value="headmanager">Head Manager</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('editEmployeeModal')">Cancel</button>
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Update Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal" id="deleteEmployeeModal">
            <div class="modal-content" style="max-width: 450px;">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-exclamation-triangle" style="color: var(--error-main);"></i>
                        Confirm Delete
                    </h3>
                    <button type="button" class="close" onclick="closeModal('deleteEmployeeModal')">&times;</button>
                </div>
                
                <div style="padding: var(--space-lg);">
                    <p>This action will permanently delete the employee and their user account. Do you want to proceed?</p>
                    
                    <div class="modal-footer" style="justify-content: space-between; margin-top: var(--space-lg);">
                        <button type="button" class="btn btn-outline" onclick="closeModal('deleteEmployeeModal')">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteButton">
                            <i class="fas fa-trash"></i> Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
    // Helper functions for validation
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function isValidNIC(nic) {
        const oldNICRegex = /^[0-9]{9}[VvXx]$/;
        const newNICRegex = /^[0-9]{12}$/;
        return oldNICRegex.test(nic) || newNICRegex.test(nic);
    }
    
    function isValidPhone(phone) {
        const phoneRegex = /^(?:\+94|0)[0-9]{9}$/;
        return phoneRegex.test(phone);
    }
    
    // Form validation functions
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

        return true;
    }
    
    function validateEditForm() {
        const email = document.getElementById('edit_email').value;
        const employeeId = document.getElementById('edit_employee_id').value;
        
        // Check email uniqueness before submission
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `<?php echo URLROOT; ?>/sysadmin/checkEmailExistsExcept/${encodeURIComponent(email)}/${employeeId}`, false); // Synchronous request
        xhr.send();
        
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.exists) {
                alert('This email is already in use by another employee. Please use a different email.');
                return false;
            }
        }
        
        return true;
    }
    
    // Search function
    function searchEmployee() {
        const input = document.getElementById('searchEmployeeInput').value.trim();
        const branch = document.getElementById('branchFilter').value;
        const table = document.getElementById('employeeTable');
        const rows = table.getElementsByTagName('tr');
        let found = false;

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length > 0) {
                const employeeId = cells[0].textContent || cells[0].innerText;
                const employeeName = cells[1].textContent || cells[1].innerText;
                const employeeBranch = cells[6].textContent || cells[6].innerText;
                if ((employeeId === input || employeeName.toLowerCase().includes(input.toLowerCase())) && 
                    (branch === "" || employeeBranch === branch)) {
                    rows[i].style.display = '';
                    found = true;
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }

        if (!found && input !== '') {
            alert('No employee found with the given ID or name.');
        } else if (input === '') {
            // Show all rows if search input is empty
            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = '';
            }
        }
    }

    function resetSearch() {
        document.getElementById('searchEmployeeInput').value = '';
        document.getElementById('branchFilter').value = '';
        searchEmployee();
    }

    // Modal handling functions
    function openAddModal() {
        document.getElementById('addEmployeeModal').style.display = 'flex';
        
        // Set default dates
        const today = new Date();
        const eighteenYearsAgo = new Date();
        eighteenYearsAgo.setFullYear(today.getFullYear() - 18);
        
        document.getElementById('dob').valueAsDate = eighteenYearsAgo;
        document.getElementById('join_date').valueAsDate = today;
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
                    document.getElementById('editEmployeeModal').style.display = 'flex';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load employee details. Please try again.');
            });
    }

    // 
    // Replace deleteEmployee function with this
function deactivateEmployee(employeeId) {
    // Set up the confirm deactivate button
    const confirmDeactivateButton = document.getElementById('confirmDeleteButton');
    
    // Update modal title and content
    document.querySelector('#deleteEmployeeModal .modal-title').innerHTML = 
        '<i class="fas fa-user-slash" style="color: var(--error-main);"></i> <span style="color:var(--primary-main);">Confirm Deactivate</span>';
    document.querySelector('#deleteEmployeeModal p').textContent = 
        'This action will deactivate the employee. They will no longer have access to the system but their records will be preserved. Do you want to proceed?';
    document.getElementById('confirmDeleteButton').innerHTML = 
        '<i class="fas fa-user-slash"></i> Yes, Deactivate';
    
    confirmDeactivateButton.onclick = function() {
        window.location.href = `<?php echo URLROOT; ?>/sysadmin/deactivateEmployee/${employeeId}`;
    };
    
    // Display the modal
    document.getElementById('deleteEmployeeModal').style.display = 'flex';
}

// Add reactivateEmployee function
function reactivateEmployee(employeeId) {
    // Set up the confirm reactivate button
    const confirmReactivateButton = document.getElementById('confirmDeleteButton');
    
    // Update modal title and content
    document.querySelector('#deleteEmployeeModal .modal-title').innerHTML = 
        '<i class="fas fa-user-check" style="color: var(--success-main);"></i> Confirm Reactivate';
    document.querySelector('#deleteEmployeeModal p').textContent = 
        'This action will reactivate the employee. They will regain access to the system. Do you want to proceed?';
    document.getElementById('confirmDeleteButton').innerHTML = 
        '<i class="fas fa-user-check"></i> Yes, Reactivate';
    
    confirmReactivateButton.className = 'btn btn-success';
    
    confirmReactivateButton.onclick = function() {
        window.location.href = `<?php echo URLROOT; ?>/sysadmin/reactivateEmployee/${employeeId}`;
    };
    
    // Display the modal
    document.getElementById('deleteEmployeeModal').style.display = 'flex';
}

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function validateEmailUniqueness(email, employeeId) {
        if (!email) return;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `<?php echo URLROOT; ?>/sysadmin/checkEmailExistsExcept/${encodeURIComponent(email)}/${employeeId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const emailError = document.getElementById('emailError');
                if (response.exists) {
                    emailError.textContent = 'This email is already in use by another employee.';
                    emailError.style.display = 'block';
                } else {
                    emailError.textContent = '';
                    emailError.style.display = 'none';
                }
            }
        };
        xhr.send();
    }

    // Add this function to validate email uniqueness for new employees
function validateEmailUniquenessForNew(email) {
    if (!email) return;
    
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `<?php echo URLROOT; ?>/sysadmin/checkEmailExists/${encodeURIComponent(email)}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            const emailError = document.getElementById('newEmailError');
            if (response.exists) {
                emailError.textContent = 'This email is already in use by another employee.';
                emailError.style.display = 'block';
            } else {
                emailError.textContent = '';
                emailError.style.display = 'none';
            }
        }
    };
    xhr.send();
}

    // Close modals when clicking outside
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