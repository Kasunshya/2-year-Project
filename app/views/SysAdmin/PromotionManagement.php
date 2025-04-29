<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Management</title>
    <?php require APPROOT.'/views/SysAdmin/SideNavBar.php'?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Add Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Add SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <style>
        /* Typography */
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Container styles */
        .promotion-container {
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
        .promotion-table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            border-radius: 4px;
            overflow: hidden;
        }

        .promotion-table th {
            background-color: #a26b98;
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .promotion-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .promotion-table tbody tr:hover {
            background-color: #f9f5f0;
        }

        /* Add Promotion Button */
        .add-promotion-btn {
            background-color: #a26b98;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin: 20px 0;
            font-size: 14px;
        }

        .add-promotion-btn:hover {
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

        .form-group input, .form-group textarea {
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

        .promotion-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h7><i class="fas fa-tags"></i>Promotion Management</h7>
    </header>

    <div class="promotion-container">
        <?php flash('promotion_message'); ?>

        <!-- Search and Add Promotion Section -->
        <div class="search-container">
            <input type="text" class="search-input" id="searchPromotion" placeholder="Search promotion...">
            <button class="add-promotion-btn" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Promotion
            </button>
        </div>

        <!-- Promotion Table -->
        <table class="promotion-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Discount %</th>
                    <th>Image</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['promotions'] as $promotion) : ?>
                    <tr>
                        <td><?php echo $promotion->title; ?></td>
                        <td><?php echo $promotion->description; ?></td>
                        <td><?php echo $promotion->discount_percentage; ?>%</td>
                        <td>
                            <?php if($promotion->image_path): ?>
                                <img src="<?php echo URLROOT; ?>/public/img/promotions/<?php echo $promotion->image_path; ?>" 
                                     class="promotion-image" alt="Promotion Image">
                            <?php endif; ?>
                        </td>
                        <td><?php echo $promotion->start_date; ?></td>
                        <td><?php echo $promotion->end_date; ?></td>
                        <td>
                            <label class="status-switch">
                                <input type="checkbox" 
                                       <?php echo $promotion->is_active ? 'checked' : ''; ?>
                                       onchange="updateStatus(<?php echo $promotion->id; ?>, this)">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <button class="action-btn" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($promotion)); ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Promotion Modal -->
    <div id="addPromotionModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('addPromotionModal')">&times;</span>
            <div class="modal-header">
                <h2>Add New Promotion</h2>
            </div>
            <form id="addPromotionForm" method="POST" action="<?php echo URLROOT; ?>/SysAdminP/addPromotion" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="discount_percentage">Discount Percentage</label>
                    <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel-btn" onclick="closeModal('addPromotionModal')">Cancel</button>
                    <button type="submit" class="modal-btn save-btn">Save Promotion</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Promotion Modal -->
    <div id="editPromotionModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('editPromotionModal')">&times;</span>
            <div class="modal-header">
                <h2>Edit Promotion</h2>
            </div>
            <form id="editPromotionForm" method="POST" action="<?php echo URLROOT; ?>/SysAdminP/updatePromotion" enctype="multipart/form-data">
                <input type="hidden" id="edit_promotion_id" name="id">
                <div class="form-group">
                    <label for="edit_title">Title</label>
                    <input type="text" id="edit_title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_discount_percentage">Discount Percentage</label>
                    <input type="number" id="edit_discount_percentage" name="discount_percentage" min="0" max="100" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="edit_image">Image</label>
                    <input type="file" id="edit_image" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="edit_start_date">Start Date</label>
                    <input type="date" id="edit_start_date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label for="edit_end_date">End Date</label>
                    <input type="date" id="edit_end_date" name="end_date" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel-btn" onclick="closeModal('editPromotionModal')">Cancel</button>
                    <button type="submit" class="modal-btn save-btn">Update Promotion</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addPromotionModal').style.display = 'block';
        }

        function openEditModal(promotion) {
            // Format dates for input fields (YYYY-MM-DD)
            const startDate = new Date(promotion.start_date).toISOString().split('T')[0];
            const endDate = new Date(promotion.end_date).toISOString().split('T')[0];
            
            // Populate form fields
            document.getElementById('edit_promotion_id').value = promotion.id;
            document.getElementById('edit_title').value = promotion.title;
            document.getElementById('edit_description').value = promotion.description;
            document.getElementById('edit_discount_percentage').value = parseFloat(promotion.discount_percentage);
            document.getElementById('edit_start_date').value = startDate;
            document.getElementById('edit_end_date').value = endDate;
            
            // Show the modal
            document.getElementById('editPromotionModal').style.display = 'block';
        }

        function closeModal(modalId) {
            Swal.fire({
                title: 'Close Form',
                text: 'Are you sure you want to close? Any unsaved changes will be lost.',
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

        function updateStatus(promotionId, checkbox) {
            Swal.fire({
                title: 'Update Status',
                text: 'Do you want to update the promotion status?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#a26b98',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`<?php echo URLROOT; ?>/SysAdminP/updatePromotionStatus/${promotionId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            is_active: checkbox.checked
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Promotion status has been updated.',
                                icon: 'success',
                                confirmButtonColor: '#a26b98'
                            });
                        } else {
                            checkbox.checked = !checkbox.checked;
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to update status',
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
                            text: 'Failed to update status',
                            icon: 'error',
                            confirmButtonColor: '#a26b98'
                        });
                    });
                } else {
                    checkbox.checked = !checkbox.checked;
                }
            });
        }

        // Add this validation function
        function validateDates(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            return start <= end;
        }

        // Add form validation
        document.getElementById('editPromotionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const startDate = document.getElementById('edit_start_date').value;
            const endDate = document.getElementById('edit_end_date').value;
            
            if (!validateDates(startDate, endDate)) {
                Swal.fire({
                    title: 'Invalid Dates!',
                    text: 'End date must be after start date',
                    icon: 'warning',
                    confirmButtonColor: '#a26b98'
                });
                return;
            }
            
            Swal.fire({
                title: 'Update Promotion',
                text: 'Are you sure you want to update this promotion?',
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

        // Add form validation with SweetAlert
        document.getElementById('addPromotionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (!validateDates(startDate, endDate)) {
                Swal.fire({
                    title: 'Invalid Dates!',
                    text: 'End date must be after start date',
                    icon: 'warning',
                    confirmButtonColor: '#a26b98'
                });
                return;
            }
            
            Swal.fire({
                title: 'Add Promotion',
                text: 'Are you sure you want to add this promotion?',
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

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        // Search functionality
        document.getElementById('searchPromotion').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let rows = document.querySelectorAll('.promotion-table tbody tr');
            
            rows.forEach(row => {
                let title = row.cells[0].textContent.toLowerCase();
                let description = row.cells[1].textContent.toLowerCase();
                
                if (title.includes(searchText) || description.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>