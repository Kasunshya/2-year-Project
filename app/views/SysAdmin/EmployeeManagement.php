<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
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
            width: 50%;
            position: relative;
        }

        .modal-content h2 {
            margin-bottom: 20px;
        }

        .modal-content label {
            display: block;
            margin: 10px 0 5px;
        }

        .modal-content input, .modal-content select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal-content .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            cursor: pointer;
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
                    <tr>
                        <td>1</td>
                        <td>David Kumar</td>
                        <td>991234567V</td>
                        <td>321 Hill Street, Colombo</td>
                        <td>0774567890</td>
                        <td>david@example.com</td>
                        <td>Colombo</td>
                        <td>Manager</td>
                        <td><a href="#">Download CV</a></td>
                        <td class="actions">
                            <button class="btn" onclick="openEditModal(1)">Edit</button>
                            <button class="btn delete-btn" onclick="deleteEmployee(1)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Add Employee Modal -->
        <div class="modal" id="addEmployeeModal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addEmployeeModal')">&times;</span>
                <h2>Add New Employee</h2>
                <form id="addEmployeeForm">
                    <label for="add_full_name">Full Name:</label>
                    <input type="text" id="add_full_name" required>

                    <label for="add_nic">NIC:</label>
                    <input type="text" id="add_nic" required>

                    <label for="add_address">Address:</label>
                    <input type="text" id="add_address" required>

                    <label for="add_contact_no">Contact No:</label>
                    <input type="text" id="add_contact_no" required>

                    <label for="add_email">Email:</label>
                    <input type="email" id="add_email" required>

                    <label for="add_branch">Branch:</label>
                    <select id="add_branch">
                        <option value="Colombo">Colombo</option>
                        <option value="Galle">Galle</option>
                    </select>

                    <label for="add_user_role">User Role:</label>
                    <select id="add_user_role">
                        <option value="Manager">Manager</option>
                        <option value="Cashier">Cashier</option>
                    </select>

                    <label for="cv_upload">Upload CV:</label>
                    <input type="file" id="cv_upload" accept=".pdf,.doc,.docx" required>

                    <button type="submit" class="btn">Add Employee</button>
                </form>
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
                document.getElementById('editEmployeeModal').style.display = 'block';
            }

            function deleteEmployee(employeeId) {
                if (confirm("Are you sure you want to delete this employee?")) {
                    alert(`Employee ${employeeId} deleted.`);
                }
            }

            // Open Edit Modal and Populate Data
    function openEditModal(employeeId) {
        // Fetch the row details based on employeeId
        const table = document.getElementById('employeeTable');
        const rows = table.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length > 0 && cells[0].textContent === employeeId.toString()) {
                // Populate the Edit Form with the current employee details
                document.getElementById('edit_employee_id').value = employeeId;
                document.getElementById('edit_full_name').value = cells[1].textContent.trim();
                document.getElementById('edit_nic').value = cells[2].textContent.trim();
                document.getElementById('edit_address').value = cells[3].textContent.trim();
                document.getElementById('edit_contact_no').value = cells[4].textContent.trim();
                document.getElementById('edit_email').value = cells[5].textContent.trim();
                document.getElementById('edit_branch').value = cells[6].textContent.trim();
                document.getElementById('edit_user_role').value = cells[7].textContent.trim();
                break;
            }
        }
        document.getElementById('editEmployeeModal').style.display = 'block';
    }

    // Close Modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Handle Edit Form Submission
    document.getElementById('editEmployeeForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Retrieve updated data from the form
        const employeeId = document.getElementById('edit_employee_id').value;
        const fullName = document.getElementById('edit_full_name').value;
        const nic = document.getElementById('edit_nic').value;
        const address = document.getElementById('edit_address').value;
        const contactNo = document.getElementById('edit_contact_no').value;
        const email = document.getElementById('edit_email').value;
        const branch = document.getElementById('edit_branch').value;
        const userRole = document.getElementById('edit_user_role').value;

        // Update the table row dynamically (Frontend only for demo purposes)
        const table = document.getElementById('employeeTable');
        const rows = table.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length > 0 && cells[0].textContent === employeeId) {
                cells[1].textContent = fullName;
                cells[2].textContent = nic;
                cells[3].textContent = address;
                cells[4].textContent = contactNo;
                cells[5].textContent = email;
                cells[6].textContent = branch;
                cells[7].textContent = userRole;
                break;
            }
        }

        // Simulate backend update (replace with actual backend call in production)
        alert(`Employee with ID ${employeeId} updated successfully.`);

        closeModal('editEmployeeModal');
    });
        </script>
         <div class="modal" id="editEmployeeModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editEmployeeModal')">&times;</span>
            <h2>Edit Employee</h2>
            <form id="editEmployeeForm">
                <label for="edit_employee_id">Employee ID:</label>
                <input type="text" id="edit_employee_id" required>
                <label for="edit_full_name">Full Name:</label>
                <input type="text" id="edit_full_name" required>
                <label for="edit_nic">NIC:</label>
                <input type="text" id="edit_nic" required>
                <label for="edit_address">Address:</label>
                <input type="text" id="edit_address" required>
                <label for="edit_contact_no">Contact No:</label>
                <input type="text" id="edit_contact_no" required>
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" required>
                <button type="submit" class="btn">Update Employee</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(employeeId) {
        document.getElementById('editEmployeeModal').style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>
    </main>
</body>
</html>
