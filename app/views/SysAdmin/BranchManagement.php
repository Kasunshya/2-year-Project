<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Management</title>
    <?php require APPROOT.'/views/SysAdmin/SideNavBar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SystemAdmin/branchmanagement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <!-- Add Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
        /* Typography */
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Common container styles for perfect alignment */
        .branch-container {
            width: 90%;
            margin-left: 120px;
            margin-right: 30px;
            padding: 0;
            box-sizing: border-box;
        }

        /* Header styling */
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
        }

        /* Table styles */
        .branch-table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            border-radius: 4px;
            overflow: hidden;
        }

        .branch-table th {
            background-color: #a26b98;
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .branch-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .branch-table tbody tr:hover {
            background-color: #f9f5f0;
        }

        /* Add Branch Button */
        .add-branch-btn {
            background-color: #a26b98;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin: 20px 0;
            font-size: 14px;
        }

        .add-branch-btn:hover {
            background-color: #5d2e46;
        }

        /* Search Bar */
        .search-container {
            margin: 20px 0;
        }

        .search-input {
            padding: 8px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            width: 300px;
            margin-right: 10px;
        }

        /* Status Toggle Switch */
        .status-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .status-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #4CAF50;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Action Buttons */
        .action-btn {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
        }

        .action-btn:hover {
            background-color: #5d2e46;
        }

        /* Modal Styles */
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
        }

        .close-modal {
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #5d2e46;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: right;
        }

        .modal-btn {
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            margin-left: 10px;
        }

        .save-btn {
            background-color: #a26b98;
            color: white;
        }

        .cancel-btn {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h7><i class="fas fa-building"></i>Branch Management</h7>
    </header>

    <div class="branch-container">
        <?php flash('branch_message'); ?>

        <!-- Search and Add Branch Section -->
        <div class="search-container">
            <input type="text" class="search-input" id="searchBranch" placeholder="Search branch...">
            <button class="add-branch-btn" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Branch
            </button>
        </div>

        <!-- Branch Table -->
        <table class="branch-table">
            <thead>
                <tr>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['branches'] as $branch) : ?>
                    <tr>
                        <td><?php echo $branch->branch_name; ?></td>
                        <td><?php echo $branch->branch_address; ?></td>
                        <td><?php echo $branch->branch_contact; ?></td>
                        <td>
                            <label class="status-switch">
                                <input type="checkbox" 
                                       <?php echo $branch->status === 'active' ? 'checked' : ''; ?>
                                       onchange="updateStatus(<?php echo $branch->branch_id; ?>, this)">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <button class="action-btn" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($branch)); ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Branch Modal -->
    <div id="addBranchModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('addBranchModal')">&times;</span>
            <div class="modal-header">
                <h2>Add New Branch</h2>
            </div>
            <form id="addBranchForm" method="POST" action="<?php echo URLROOT; ?>/SysAdminP/addBranch">
                <div class="form-group">
                    <label for="branch_name">Branch Name</label>
                    <input type="text" id="branch_name" name="branch_name" required>
                </div>
                <div class="form-group">
                    <label for="branch_address">Address</label>
                    <input type="text" id="branch_address" name="branch_address" required>
                </div>
                <div class="form-group">
                    <label for="branch_contact">Contact Number</label>
                    <input type="text" id="branch_contact" name="branch_contact" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel-btn" onclick="closeModal('addBranchModal')">Cancel</button>
                    <button type="submit" class="modal-btn save-btn">Save Branch</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Branch Modal -->
    <div id="editBranchModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('editBranchModal')">&times;</span>
            <div class="modal-header">
                <h2>Edit Branch</h2>
            </div>
            <form id="editBranchForm" method="POST" action="<?php echo URLROOT; ?>/SysAdminP/updateBranch">
                <input type="hidden" id="edit_branch_id" name="branch_id">
                <div class="form-group">
                    <label for="edit_branch_name">Branch Name</label>
                    <input type="text" id="edit_branch_name" name="branch_name" required>
                </div>
                <div class="form-group">
                    <label for="edit_branch_address">Address</label>
                    <input type="text" id="edit_branch_address" name="branch_address" required>
                </div>
                <div class="form-group">
                    <label for="edit_branch_contact">Contact Number</label>
                    <input type="text" id="edit_branch_contact" name="branch_contact" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel-btn" onclick="closeModal('editBranchModal')">Cancel</button>
                    <button type="submit" class="modal-btn save-btn">Update Branch</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addBranchModal').style.display = 'block';
        }

        function openEditModal(branch) {
            document.getElementById('edit_branch_id').value = branch.branch_id;
            document.getElementById('edit_branch_name').value = branch.branch_name;
            document.getElementById('edit_branch_address').value = branch.branch_address;
            document.getElementById('edit_branch_contact').value = branch.branch_contact;
            document.getElementById('editBranchModal').style.display = 'block';
        }

        function closeModal(modalId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Any unsaved changes will be lost!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#a26b98',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, close it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(modalId).style.display = 'none';
                }
            });
        }

        // Update status using AJAX with SweetAlert
        function updateStatus(branchId, checkbox) {
            fetch(`<?php echo URLROOT; ?>/SysAdminP/updateBranchStatus/${branchId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    status: checkbox.checked
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Branch status updated successfully',
                        icon: 'success',
                        confirmButtonColor: '#a26b98'
                    });
                } else {
                    checkbox.checked = !checkbox.checked;
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update branch status',
                        icon: 'error',
                        confirmButtonColor: '#a26b98'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                checkbox.checked = !checkbox.checked;
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update branch status',
                    icon: 'error',
                    confirmButtonColor: '#a26b98'
                });
            });
        }

        // Add form submission with SweetAlert
        document.getElementById('addBranchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Add Branch',
                text: 'Are you sure you want to add this branch?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#a26b98',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, add it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Edit form submission with SweetAlert
        document.getElementById('editBranchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Update Branch',
                text: 'Are you sure you want to update this branch?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#a26b98',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        }

        // Search functionality
        document.getElementById('searchBranch').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let rows = document.querySelectorAll('.branch-table tbody tr');
            
            rows.forEach(row => {
                let branchName = row.cells[0].textContent.toLowerCase();
                let address = row.cells[1].textContent.toLowerCase();
                let contact = row.cells[2].textContent.toLowerCase();
                
                if (branchName.includes(searchText) || 
                    address.includes(searchText) || 
                    contact.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Display flash messages using SweetAlert if they exist
        <?php if(isset($_SESSION['flash_message'])): ?>
            Swal.fire({
                title: '<?php echo $_SESSION['flash_message']['title']; ?>',
                text: '<?php echo $_SESSION['flash_message']['message']; ?>',
                icon: '<?php echo $_SESSION['flash_message']['type']; ?>',
                confirmButtonColor: '#a26b98'
            });
        <?php endif; ?>
    </script>
</body>
</html>
