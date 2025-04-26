<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Management</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/bakery-design-system.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        .header {
          background-color: #5d2e46;
          padding: 2rem;
          text-align: center;
          color: var(--white);
          font-size: 2.5rem;
          text-transform: uppercase;
          margin-top: 10px;
          margin-left: 120px;
          margin-right: 20px;
          border-radius: 5px;
          width: 90%;
}
        /* Page-specific styles only */
        .table-container {
            margin: var(--space-lg) 0;
        }
        
        /* Status Toggle Switch */
        .status-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin-left: var(--space-md);
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
            background-color: var(--neutral-gray);
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
            background-color: var(--success-main);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        .status-container {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }
        
        .status-text {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .status-text.active {
            color: var(--success-dark);
        }
        
        .status-text.inactive {
            color: var(--error-dark);
        }
        
        .error-message {
            color: var(--error-dark);
            background-color: var(--error-light);
            padding: var(--space-sm) var(--space-md);
            border-radius: var(--radius-md);
            margin-top: var(--space-sm);
            display: none;
        }
    </style>
</head>
<body>
<div class="sysadmin-page-container">
    <div class="container">
        <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

        <header class="header">
            <div class="header-left">
                <i class="fas fa-building"></i>
                <span>Branch Management</span>
            </div>
            
        </header>

        <div class="content">
            <?php flash('branch_message'); ?>
            
            <div class="search-bar">
                <form onsubmit="searchBranch(); return false;">
                    <input type="text" 
                        class="form-control"
                        id="searchBranchInput" 
                        placeholder="Search by branch name..." 
                        value="">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>
            
            <button class="btn" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Branch
            </button>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Branch Name</th>
                            <th>Address</th>
                            <th>Contact No</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="branchTable">
                        <?php if(isset($data['branches']) && !empty($data['branches'])) : ?>
                            <?php foreach($data['branches'] as $branch) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($branch->branch_name); ?></td>
                                    <td><?php echo htmlspecialchars($branch->branch_address); ?></td>
                                    <td><?php echo htmlspecialchars($branch->branch_contact); ?></td>
                                    <td>
                                        <div class="status-container">
                                            <span class="status-text <?php echo $branch->status === 'active' ? 'active' : 'inactive'; ?>">
                                                <?php echo ucfirst($branch->status); ?>
                                            </span>
                                            <label class="status-switch">
                                                <input type="checkbox" 
                                                    onchange="updateBranchStatus(<?php echo $branch->branch_id; ?>, this.checked)"
                                                    <?php echo ($branch->status === 'active') ? 'checked' : ''; ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <button class="btn edit-btn" onclick="openEditModal(<?php echo $branch->branch_id; ?>, 
                                            '<?php echo htmlspecialchars(addslashes($branch->branch_name)); ?>', 
                                            '<?php echo htmlspecialchars(addslashes($branch->branch_address)); ?>', 
                                            '<?php echo htmlspecialchars($branch->branch_contact); ?>')">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">No branches found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Branch Modal -->
        <div class="modal" id="addBranchModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-plus-circle"></i>
                        Add New Branch
                    </h3>
                    <button type="button" class="close" onclick="closeModal('addBranchModal')">&times;</button>
                </div>
                
                <form id="addBranchForm" action="<?php echo URLROOT; ?>/SysAdminP/addBranch" method="POST" onsubmit="return validateForm('addBranchForm')">
                    <div class="form-group">
                        <label class="form-label" for="add_branch_name">Branch Name:</label>
                        <input type="text" class="form-control" id="add_branch_name" name="branch_name" required placeholder="Enter branch name">
                        <div id="add_name_error" class="error-message"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="add_branch_address">Address:</label>
                        <input type="text" class="form-control" id="add_branch_address" name="branch_address" required placeholder="Enter branch address">
                        <div id="add_address_error" class="error-message"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="add_branch_contact">Contact No:</label>
                        <input type="text" class="form-control" id="add_branch_contact" name="branch_contact" required pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number" placeholder="10-digit phone number">
                        <div id="add_contact_error" class="error-message"></div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('addBranchModal')">Cancel</button>
                        <button type="submit" class="btn">
                            <i class="fas fa-plus"></i> Add Branch
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Branch Modal -->
        <div class="modal" id="editBranchModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-edit"></i>
                        Edit Branch
                    </h3>
                    <button type="button" class="close" onclick="closeModal('editBranchModal')">&times;</button>
                </div>
                
                <form id="editBranchForm" action="<?php echo URLROOT; ?>/SysAdminP/updateBranch" method="POST" onsubmit="return validateForm('editBranchForm')">
                    <input type="hidden" name="branch_id" id="edit_branch_id">
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_branch_name">Branch Name:</label>
                        <input type="text" class="form-control" id="edit_branch_name" name="branch_name" required>
                        <div id="edit_name_error" class="error-message"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_branch_address">Address:</label>
                        <input type="text" class="form-control" id="edit_branch_address" name="branch_address" required>
                        <div id="edit_address_error" class="error-message"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_branch_contact">Contact No:</label>
                        <input type="text" class="form-control" id="edit_branch_contact" name="branch_contact" required pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
                        <div id="edit_contact_error" class="error-message"></div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('editBranchModal')">Cancel</button>
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Update Branch
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openAddModal() {
                document.getElementById('addBranchModal').style.display = 'flex';
                
                // Clear any previous error styling
                document.querySelectorAll('.error-message').forEach(el => {
                    el.style.display = 'none';
                });
                
                document.querySelectorAll('.form-control').forEach(input => {
                    input.style.borderColor = '';
                });
            }

            function openEditModal(branchId, branchName, branchAddress, branchContact) {
                document.getElementById('edit_branch_id').value = branchId;
                document.getElementById('edit_branch_name').value = branchName;
                document.getElementById('edit_branch_address').value = branchAddress;
                document.getElementById('edit_branch_contact').value = branchContact;
                
                // Clear any previous error styling
                document.querySelectorAll('.error-message').forEach(el => {
                    el.style.display = 'none';
                });
                
                document.querySelectorAll('.form-control').forEach(input => {
                    input.style.borderColor = '';
                });
                
                document.getElementById('editBranchModal').style.display = 'flex';
            }

            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }

            function searchBranch() {
                const input = document.getElementById('searchBranchInput');
                const filter = input.value.toUpperCase();
                const table = document.getElementById('branchTable');
                const tr = table.getElementsByTagName('tr');

                for (let i = 0; i < tr.length; i++) {
                    const td = tr[i].getElementsByTagName('td')[0]; // Branch Name column
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
                
                const prefix = formId === 'addBranchForm' ? 'add_' : 'edit_';

                // Clear any previous error styling
                form.querySelectorAll('.error-message').forEach(el => {
                    el.style.display = 'none';
                });
                
                form.querySelectorAll('.form-control').forEach(input => {
                    input.style.borderColor = '';
                });

                let isValid = true;

                if (branchName === '') {
                    const input = form.querySelector('[name="branch_name"]');
                    const error = document.getElementById(`${prefix}name_error`);
                    
                    input.style.borderColor = 'var(--error-main)';
                    error.textContent = 'Please enter a branch name';
                    error.style.display = 'block';
                    isValid = false;
                }

                if (branchAddress === '') {
                    const input = form.querySelector('[name="branch_address"]');
                    const error = document.getElementById(`${prefix}address_error`);
                    
                    input.style.borderColor = 'var(--error-main)';
                    error.textContent = 'Please enter an address';
                    error.style.display = 'block';
                    isValid = false;
                }

                if (!branchContact || !/^\d{10}$/.test(branchContact)) {
                    const input = form.querySelector('[name="branch_contact"]');
                    const error = document.getElementById(`${prefix}contact_error`);
                    
                    input.style.borderColor = 'var(--error-main)';
                    error.textContent = 'Please enter a valid 10-digit contact number';
                    error.style.display = 'block';
                    isValid = false;
                }

                return isValid;
            }

            function updateBranchStatus(branchId, isActive) {
                fetch(`<?php echo URLROOT; ?>/SysAdminP/updateBranchStatus/${branchId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ status: isActive ? 'active' : 'inactive' })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                        
                        // Update the status text without reloading the page
                        const row = document.querySelector(`tr:has(input[onchange*="updateBranchStatus(${branchId}"])`);
                        if (row) {
                            const statusText = row.querySelector('.status-text');
                            if (statusText) {
                                statusText.className = `status-text ${isActive ? 'active' : 'inactive'}`;
                                statusText.textContent = isActive ? 'Active' : 'Inactive';
                            }
                        }
                        
                    } else {
                        showAlert('error', data.message || 'Failed to update branch status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'An error occurred while updating branch status');
                });
            }

            function showAlert(type, message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type}`;
                alertDiv.innerHTML = `
                    <div class="alert-content">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                        <span>${message}</span>
                    </div>
                    <button class="close-btn" onclick="closeAlert(this.parentElement)">&times;</button>
                `;
                
                const content = document.querySelector('.content');
                content.insertBefore(alertDiv, content.firstChild);

                // Auto-hide after 5 seconds
                setTimeout(() => {
                    closeAlert(alertDiv);
                }, 5000);
            }

            function closeAlert(alert) {
                alert.classList.add('fade-out');
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }

            // Close modals when clicking outside
            window.onclick = function(event) {
                if (event.target.className === 'modal') {
                    event.target.style.display = 'none';
                }
            }
        </script>
    </div>
</div>
</body>
</html>
