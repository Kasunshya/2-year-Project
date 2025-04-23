<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SysAdmin/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f1ec;
        }

        .content {
            margin-left: 150px;
            padding: 20px;
            width: calc(100% - 180px);
            overflow-x: auto;
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
            min-width: 1200px;
            border-spacing: 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            height: 100px;
            box-sizing: border-box;
        }

        table th {
            background-color: #c98d83;
            color: white;
        }

        table td {
            background-color: #ffff;
            vertical-align: middle;
        }

        .promotion-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .status.active {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status.inactive {
            background-color: #fdecea;
            color: #c62828;
        }

        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .edit-btn, .delete-btn {
            padding: 8px 15px;
            font-size: 0.9rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            min-width: 70px;
        }

        .edit-btn {
            background-color: #c98d83;
            color: white;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            width: 700px;
            max-height: 85vh;
            position: relative;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-content form div {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .modal-content label {
            font-weight: bold;
            color: #333;
        }

        .modal-content input,
        .modal-content textarea {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .modal-content textarea {
            height: 100px;
            resize: vertical;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 4px;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .close:hover {
            color: #333;
        }

        #currentImageText {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideIn 0.5s ease-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            color: #2e7d32;
        }

        .alert-error {
            background-color: #fdecea;
            border-left: 4px solid #f44336;
            color: #c62828;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(-100%);
                opacity: 0;
            }
        }

        .alert.fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }
    </style>
</head>
<body>
    <?php require APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>
    
    <div class="content">
        <header class="header">
            <div class="header-left">
                <i class="fas fa-tag"></i>
                <span>Promotion Management</span>
            </div>
            <div class="header-role">
                <span>System Administrator</span>
            </div>
        </header>

        <?php flash('promotion_message'); ?>

        <button class="btn" onclick="openAddModal()">+ Add Promotion</button>

        <table>
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
                            <td><?php echo htmlspecialchars($promotion->description); ?></td>
                            <td><?php echo $promotion->discount_percentage; ?>%</td>
                            <td>
                                <?php echo date('Y-m-d', strtotime($promotion->start_date)); ?> to 
                                <?php echo date('Y-m-d', strtotime($promotion->end_date)); ?>
                            </td>
                            <td>
                                <span class="status <?php echo $promotion->is_active ? 'active' : 'inactive'; ?>">
                                    <?php echo $promotion->is_active ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td class="actions">
                                <button class="btn edit-btn" onclick='openEditModal(<?php echo json_encode($promotion); ?>)'>
                                    Edit
                                </button>
                                <button class="btn delete-btn" onclick="confirmDelete(<?php echo $promotion->id; ?>)">
                                    Delete
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

    <!-- Add Promotion Modal -->
    <div id="addPromotionModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addPromotionModal')">&times;</span>
            <h2>Add New Promotion</h2>
            <form action="<?php echo URLROOT; ?>/SysAdminP/addPromotion" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div>
                    <label for="discount_percentage">Discount Percentage:</label>
                    <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" required>
                </div>
                <div>
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" required>
                </div>
                <div>
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" required>
                </div>
                <div class="file-input-container">
                    <label for="promotion_image">Promotion Image:</label>
                    <input type="file" id="promotion_image" name="promotion_image" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                    <img id="imagePreview" class="image-preview" style="display: none;">
                </div>
                <div>
                    <label for="is_active">Active Status:</label>
                    <input type="checkbox" id="is_active" name="is_active" checked>
                </div>
                <button type="submit" class="btn">Add Promotion</button>
            </form>
        </div>
    </div>

    <!-- Edit Promotion Modal -->
    <div id="editPromotionModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editPromotionModal')">&times;</span>
            <h2>Edit Promotion</h2>
            <form action="<?php echo URLROOT; ?>/SysAdminP/updatePromotion" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit_promotion_id" name="promotion_id">
                <div>
                    <label for="edit_title">Title:</label>
                    <input type="text" id="edit_title" name="title" required>
                </div>
                <div>
                    <label for="edit_description">Description:</label>
                    <textarea id="edit_description" name="description" required></textarea>
                </div>
                <div>
                    <label for="edit_discount_percentage">Discount Percentage:</label>
                    <input type="number" id="edit_discount_percentage" name="discount_percentage" min="0" max="100" required>
                </div>
                <div>
                    <label for="edit_start_date">Start Date:</label>
                    <input type="date" id="edit_start_date" name="start_date" required>
                </div>
                <div>
                    <label for="edit_end_date">End Date:</label>
                    <input type="date" id="edit_end_date" name="end_date" required>
                </div>
                <div class="file-input-container">
                    <label for="edit_promotion_image">Promotion Image:</label>
                    <input type="file" id="edit_promotion_image" name="promotion_image" accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                    <img id="editImagePreview" class="image-preview" style="display: none;">
                    <p id="currentImageText"></p>
                </div>
                <div>
                    <label for="edit_is_active">Active Status:</label>
                    <input type="checkbox" id="edit_is_active" name="is_active">
                </div>
                <button type="submit" class="btn">Update Promotion</button>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addPromotionModal').style.display = 'flex';
        }

        function openEditModal(promotion) {
            const modal = document.getElementById('editPromotionModal');
            document.getElementById('edit_promotion_id').value = promotion.id;
            document.getElementById('edit_title').value = promotion.title;
            document.getElementById('edit_description').value = promotion.description;
            document.getElementById('edit_discount_percentage').value = promotion.discount_percentage;
            document.getElementById('edit_start_date').value = promotion.start_date;
            document.getElementById('edit_end_date').value = promotion.end_date;
            document.getElementById('edit_is_active').checked = promotion.is_active == 1;
            
            if (promotion.image_path) {
                document.getElementById('currentImageText').textContent = 'Current image: ' + promotion.image_path;
                document.getElementById('editImagePreview').src = '<?php echo URLROOT; ?>/public/img/promotions/' + promotion.image_path;
                document.getElementById('editImagePreview').style.display = 'block';
            }
            
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
</body>
</html>