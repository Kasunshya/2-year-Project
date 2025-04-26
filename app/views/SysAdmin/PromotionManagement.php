<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Management</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/bakery-design-system.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SysAdmin/sidebar.css">
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

        /* Page-specific styles */
        .promotion-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease;
        }

        tr:hover .promotion-image {
            transform: scale(1.05);
            box-shadow: var(--shadow-md);
        }

        .date-range {
            background-color: var(--neutral-light);
            padding: 8px 12px;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            display: inline-block;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: var(--space-md);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            transition: transform 0.3s ease;
        }

        .image-preview:hover {
            transform: scale(1.02);
        }

        .file-input-container {
            background-color: var(--neutral-light);
            padding: var(--space-md);
            border-radius: var(--radius-md);
            margin-bottom: var(--space-md);
            border: 1px solid var(--neutral-gray);
        }

        .status {
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status i {
            font-size: 0.75rem;
        }

        .status.active {
            background-color: var(--success-light);
            color: var(--success-dark);
        }

        .status.inactive {
            background-color: var(--error-light);
            color: var(--error-dark);
        }

        /* Switch toggle for active status */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin-left: var(--space-md);
        }

        .switch input {
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
            background-color: var(--primary-main);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        .form-row {
            display: flex;
            gap: var(--space-md);
            margin-bottom: var(--space-md);
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        #currentImageText {
            font-size: var(--font-size-sm);
            color: var(--neutral-dark);
            margin-top: var(--space-xs);
        }
    </style>
</head>
<body>
<div class="sysadmin-page-container">
    <div class="container">
        <?php require APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>
        
        <header class="header">
            <div class="header-left">
                <i class="fas fa-tag"></i>
                <span>Promotion Management</span>
            </div>
            
        </header>

        <div class="content">
            <?php flash('promotion_message'); ?>

            <div class="search-bar">
                <form>
                    <input type="text" placeholder="Search promotions..." id="searchInput" onkeyup="searchPromotions()">
                    <button type="button" class="btn">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>

            <button class="btn" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Promotion
            </button>

            <div class="table-container">
                <table id="promotionsTable">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Discount</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['promotions'])): ?>
                            <?php foreach($data['promotions'] as $promotion): ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo URLROOT; ?>/public/img/promotions/<?php echo $promotion->image_path; ?>" 
                                             alt="<?php echo htmlspecialchars($promotion->title); ?>" 
                                             class="promotion-image"
                                             onerror="this.src='<?php echo URLROOT; ?>/public/img/default-promotion.jpg'">
                                    </td>
                                    <td><?php echo htmlspecialchars($promotion->title); ?></td>
                                    <td><?php echo htmlspecialchars(substr($promotion->description, 0, 100)) . (strlen($promotion->description) > 100 ? '...' : ''); ?></td>
                                    <td>
                                        <span class="badge" style="background-color: var(--accent-gold); color: var(--primary-dark); padding: 5px 10px; border-radius: var(--radius-md); font-weight: 600;">
                                            <?php echo $promotion->discount_percentage; ?>%
                                        </span>
                                    </td>
                                    <td>
                                        <div class="date-range">
                                            <i class="far fa-calendar-alt"></i>
                                            <?php echo date('M d, Y', strtotime($promotion->start_date)); ?> to 
                                            <?php echo date('M d, Y', strtotime($promotion->end_date)); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status <?php echo $promotion->is_active ? 'active' : 'inactive'; ?>">
                                            <i class="fas <?php echo $promotion->is_active ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                            <?php echo $promotion->is_active ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <button class="btn edit-btn" onclick='openEditModal(<?php echo json_encode($promotion); ?>)'>
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                        <button class="btn delete-btn" onclick="confirmDelete(<?php echo $promotion->id; ?>)">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">No promotions available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Promotion Modal -->
        <div id="addPromotionModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-plus-circle"></i>
                        Add New Promotion
                    </h3>
                    <button type="button" class="close" onclick="closeModal('addPromotionModal')">&times;</button>
                </div>
                
                <form action="<?php echo URLROOT; ?>/SysAdminP/addPromotion" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label" for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required placeholder="Enter promotion title">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" required placeholder="Enter promotion details" rows="3"></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="discount_percentage">Discount Percentage:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" min="0" max="100" required placeholder="e.g. 15">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="is_active">Status:</label>
                            <div style="display: flex; align-items: center;">
                                <span>Inactive</span>
                                <label class="switch">
                                    <input type="checkbox" id="is_active" name="is_active" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>Active</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="start_date">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="end_date">End Date:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    
                    <div class="file-input-container">
                        <label class="form-label" for="promotion_image">Promotion Image:</label>
                        <input type="file" class="form-control" id="promotion_image" name="promotion_image" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                        <p class="form-text">Recommended size: 800x400px, Max: 2MB</p>
                        <img id="imagePreview" class="image-preview" style="display: none;">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('addPromotionModal')">Cancel</button>
                        <button type="submit" class="btn">
                            <i class="fas fa-plus"></i> Add Promotion
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Promotion Modal -->
        <div id="editPromotionModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-edit"></i>
                        Edit Promotion
                    </h3>
                    <button type="button" class="close" onclick="closeModal('editPromotionModal')">&times;</button>
                </div>
                
                <form action="<?php echo URLROOT; ?>/SysAdminP/updatePromotion" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit_promotion_id" name="promotion_id">
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_title">Title:</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_description">Description:</label>
                        <textarea class="form-control" id="edit_description" name="description" required rows="3"></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="edit_discount_percentage">Discount Percentage:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="edit_discount_percentage" name="discount_percentage" min="0" max="100" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_is_active">Status:</label>
                            <div style="display: flex; align-items: center;">
                                <span>Inactive</span>
                                <label class="switch">
                                    <input type="checkbox" id="edit_is_active" name="is_active">
                                    <span class="slider"></span>
                                </label>
                                <span>Active</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="edit_start_date">Start Date:</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="edit_end_date">End Date:</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                    </div>
                    
                    <div class="file-input-container">
                        <label class="form-label" for="edit_promotion_image">Promotion Image:</label>
                        <input type="file" class="form-control" id="edit_promotion_image" name="promotion_image" accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                        <p class="form-text">Recommended size: 800x400px, Max: 2MB</p>
                        <img id="editImagePreview" class="image-preview" style="display: none;">
                        <p id="currentImageText"></p>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('editPromotionModal')">Cancel</button>
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Update Promotion
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Initialize date inputs with today and next month defaults
            document.addEventListener('DOMContentLoaded', function() {
                // Set default dates for new promotion (today to 30 days from now)
                const today = new Date();
                const nextMonth = new Date(today);
                nextMonth.setDate(today.getDate() + 30);
                
                document.getElementById('start_date').valueAsDate = today;
                document.getElementById('end_date').valueAsDate = nextMonth;
                
                // Set min dates to prevent past dates
                const dateInputs = document.querySelectorAll('input[type="date"]');
                const todayStr = today.toISOString().split('T')[0];
                dateInputs.forEach(input => {
                    input.min = todayStr;
                });
                
                // Validate end date is after start date in add form
                document.getElementById('start_date').addEventListener('change', function() {
                    const startDate = new Date(this.value);
                    const endDateInput = document.getElementById('end_date');
                    
                    if (new Date(endDateInput.value) <= startDate) {
                        // Set end date to start date + 7 days
                        const newEndDate = new Date(startDate);
                        newEndDate.setDate(startDate.getDate() + 7);
                        endDateInput.valueAsDate = newEndDate;
                    }
                    
                    // Set min value of end date to start date
                    endDateInput.min = this.value;
                });
            });
        
            function openAddModal() {
                document.getElementById('addPromotionModal').style.display = 'flex';
                document.getElementById('imagePreview').style.display = 'none';
            }

            function openEditModal(promotion) {
                const modal = document.getElementById('editPromotionModal');
                
                // Set form values
                document.getElementById('edit_promotion_id').value = promotion.id;
                document.getElementById('edit_title').value = promotion.title;
                document.getElementById('edit_description').value = promotion.description;
                document.getElementById('edit_discount_percentage').value = promotion.discount_percentage;
                
                // Format dates as YYYY-MM-DD for input fields
                document.getElementById('edit_start_date').value = promotion.start_date.split(' ')[0];
                document.getElementById('edit_end_date').value = promotion.end_date.split(' ')[0];
                
                // Set active status toggle
                document.getElementById('edit_is_active').checked = promotion.is_active == 1;
                
                // Handle image preview
                if (promotion.image_path) {
                    document.getElementById('currentImageText').textContent = 'Current image: ' + promotion.image_path;
                    document.getElementById('editImagePreview').src = '<?php echo URLROOT; ?>/public/img/promotions/' + promotion.image_path;
                    document.getElementById('editImagePreview').style.display = 'block';
                } else {
                    document.getElementById('currentImageText').textContent = 'No image currently uploaded';
                    document.getElementById('editImagePreview').style.display = 'none';
                }
                
                // Apply same end date validation as in add form
                document.getElementById('edit_start_date').addEventListener('change', function() {
                    const startDate = new Date(this.value);
                    const endDateInput = document.getElementById('edit_end_date');
                    
                    if (new Date(endDateInput.value) <= startDate) {
                        // Set end date to start date + 7 days
                        const newEndDate = new Date(startDate);
                        newEndDate.setDate(startDate.getDate() + 7);
                        endDateInput.valueAsDate = newEndDate;
                    }
                    
                    // Set min value of end date to start date
                    endDateInput.min = this.value;
                });
                
                // Show modal
                modal.style.display = 'flex';
            }

            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
                if (modalId === 'editPromotionModal') {
                    document.getElementById('editImagePreview').style.display = 'none';
                    document.getElementById('currentImageText').textContent = '';
                }
            }

            function confirmDelete(id) {
                if (confirm('Are you sure you want to delete this promotion?')) {
                    window.location.href = '<?php echo URLROOT; ?>/SysAdminP/deletePromotion/' + id;
                }
            }

            function previewImage(input, previewId) {
                const preview = document.getElementById(previewId);
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            
            function searchPromotions() {
                const input = document.getElementById('searchInput');
                const filter = input.value.toUpperCase();
                const table = document.getElementById('promotionsTable');
                const tr = table.getElementsByTagName('tr');
                
                // Loop through all table rows, and hide those that don't match the search query
                for (let i = 1; i < tr.length; i++) { // Start at 1 to skip header row
                    let titleColumn = tr[i].getElementsByTagName('td')[1]; // Title is in second column
                    let descColumn = tr[i].getElementsByTagName('td')[2]; // Description is in third column
                    
                    if (titleColumn || descColumn) {
                        let titleText = titleColumn.textContent || titleColumn.innerText;
                        let descText = descColumn.textContent || descColumn.innerText;
                        
                        if (titleText.toUpperCase().indexOf(filter) > -1 || descText.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

            // Close modals when clicking outside
            window.onclick = function(event) {
                if (event.target.className === 'modal') {
                    event.target.style.display = 'none';
                }
            }

            // Auto-hide alerts after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        alert.classList.add('fade-out');
                        setTimeout(function() {
                            alert.remove();
                        }, 500);
                    }, 5000);
                });
            });
        </script>
    </div>
</div>
</body>
</html>