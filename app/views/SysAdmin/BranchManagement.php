<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
     
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f1ec ;
            
        }

        .header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px;
            margin-left: 150px;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .content {
            margin-left: 150px;
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
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 40%;
            position: relative;
        }

        .modal-content h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .modal-content label {
            display: block;
            margin: 10px 0 5px;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
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
    <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

    <header class="header">
        <div class="header-left">
            <i class="fas fa-building"></i>
            <span>Branch Management</span>
        </div>
        <div class="header-role">
            <span>System Administrator</span>
        </div>
    </header>

    <div class="content">
        <?php flash('branch_message'); ?>
        
        <div class="search-bar">
            <input type="text" id="searchBranchInput" placeholder="Search Branch by name...">
            <button onclick="searchBranch()">Search</button>
        </div>
        
        <button class="btn" onclick="openAddModal()">+ Add Branch</button>
        
        <table>
            <thead>
                <tr>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="branchTable">
                <?php if(isset($data['branches'])) : ?>
                    <?php foreach($data['branches'] as $branch) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($branch->branch_name); ?></td>
                            <td><?php echo htmlspecialchars($branch->branch_address); ?></td>
                            <td><?php echo htmlspecialchars($branch->branch_contact); ?></td>
                            <td class="actions">
                                <button class="btn" onclick="openEditModal(<?php echo $branch->branch_id; ?>, 
                                    '<?php echo htmlspecialchars(addslashes($branch->branch_name)); ?>', 
                                    '<?php echo htmlspecialchars(addslashes($branch->branch_address)); ?>', 
                                    '<?php echo htmlspecialchars($branch->branch_contact); ?>')">Edit</button>
                                <button class="btn delete-btn" onclick="confirmDelete(<?php echo $branch->branch_id; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="modal" id="addBranchModal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addBranchModal')">&times;</span>
                <h2>Add Branch</h2>
                <form id="addBranchForm" action="<?php echo URLROOT; ?>/SysAdminP/addBranch" method="POST" onsubmit="return validateForm('addBranchForm')">
                    <label for="add_branch_name">Branch Name:</label>
                    <input type="text" id="add_branch_name" name="branch_name" required>
                    <label for="add_branch_address">Address:</label>
                    <input type="text" id="add_branch_address" name="branch_address" required>
                    <label for="add_branch_contact">Contact No:</label>
                    <input type="text" id="add_branch_contact" name="branch_contact" required pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
                    <button type="submit" class="btn">Add Branch</button>
                </form>
            </div>
        </div>

        <div class="modal" id="editBranchModal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editBranchModal')">&times;</span>
                <h2>Edit Branch</h2>
                <form id="editBranchForm" action="<?php echo URLROOT; ?>/SysAdminP/updateBranch" method="POST" onsubmit="return validateForm('editBranchForm')">
                    <input type="hidden" name="branch_id" id="edit_branch_id">
                    <label for="edit_branch_name">Branch Name:</label>
                    <input type="text" id="edit_branch_name" name="branch_name" required>
                    <label for="edit_branch_address">Address:</label>
                    <input type="text" id="edit_branch_address" name="branch_address" required>
                    <label for="edit_branch_contact">Contact No:</label>
                    <input type="text" id="edit_branch_contact" name="branch_contact" required pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
                    <button type="submit" class="btn">Update Branch</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addBranchModal').style.display = 'flex';
        }

        function openEditModal(branchId, branchName, branchAddress, branchContact) {
            document.getElementById('edit_branch_id').value = branchId;
            document.getElementById('edit_branch_name').value = branchName;
            document.getElementById('edit_branch_address').value = branchAddress;  // Changed from edit_address
            document.getElementById('edit_branch_contact').value = branchContact;  // Changed from edit_contact
            document.getElementById('editBranchModal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function confirmDelete(branchId) {
            if (confirm('Are you sure you want to delete this branch?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `<?php echo URLROOT; ?>/SysAdminP/deleteBranch/${branchId}`;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function searchBranch() {
            const input = document.getElementById('searchBranchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('branchTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 0; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[1]; // Branch Name column
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? '' : 'none';
                }
            }
        }

        function validateForm(formId) {
            const form = document.getElementById(formId);
            const branchName = form.querySelector('[name="branch_name"]').value.trim();
            const branchAddress = form.querySelector('[name="branch_address"]').value.trim();
            const branchContact = form.querySelector('[name="branch_contact"]').value.trim();

            // Clear any previous error styling
            form.querySelectorAll('input').forEach(input => {
                input.style.borderColor = '#ddd';
            });

            let isValid = true;

            if (branchName === '') {
                form.querySelector('[name="branch_name"]').style.borderColor = 'red';
                alert('Please enter a branch name');
                isValid = false;
            }

            if (branchAddress === '') {
                form.querySelector('[name="branch_address"]').style.borderColor = 'red';
                alert('Please enter an address');
                isValid = false;
            }

            if (!branchContact || !/^\d{10}$/.test(branchContact)) {
                form.querySelector('[name="branch_contact"]').style.borderColor = 'red';
                alert('Please enter a valid 10-digit contact number');
                isValid = false;
            }

            return isValid;
        }

        // Add event listeners to handle modal clicks outside
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>
