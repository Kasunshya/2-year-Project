<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    
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
        
        .category-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .category-image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease;
        }
        
        .category-image img:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-md);
        }
        
        /* File upload container */
        .file-input-container {
            background-color: var(--neutral-light);
            padding: var(--space-md);
            border-radius: var(--radius-md);
            margin-bottom: var(--space-md);
            border: 1px solid var(--neutral-gray);
        }
        
        .image-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: var(--radius-md);
            display: none;
            margin-top: var(--space-md);
            box-shadow: var(--shadow-md);
        }
        
        /* Enhanced alert overlay */
        .alert-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .alert-box {
            background-color: var(--neutral-white);
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            max-width: 450px;
            width: 90%;
            text-align: center;
            box-shadow: var(--shadow-lg);
            animation: alertFadeIn 0.3s ease;
        }
        
        .alert-box h3 {
            color: var(--primary-dark);
            margin-bottom: var(--space-md);
        }
        
        .alert-actions {
            display: flex;
            justify-content: center;
            gap: var(--space-md);
            margin-top: var(--space-lg);
        }
        
        .error-message {
            color: var(--error-dark);
            background-color: var(--error-light);
            padding: var(--space-sm) var(--space-md);
            border-radius: var(--radius-md);
            margin-top: var(--space-sm);
            display: none;
        }
        
        #currentImageText {
            font-size: var(--font-size-sm);
            color: var(--neutral-dark);
            margin-top: var(--space-xs);
        }
        
        @keyframes alertFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="sysadmin-page-container">
    <div class="container">
        <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

        <header class="header">
            <div class="header-left">
                <i class="fas fa-th-list"></i>
                <span>Category Management</span>
            </div>
            
        </header>

        <div class="content">
            <?php flash('category_message'); ?>
            
            <div class="search-bar">
                <form onsubmit="searchCategory(); return false;">
                    <input type="text" 
                           class="form-control"
                           id="searchCategoryInput" 
                           placeholder="Search by category name..." 
                           value="">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>
            
            <button class="btn" onclick="openAddCategoryModal()">
                <i class="fas fa-plus"></i> Add Category
            </button>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTable">
                        <?php if (isset($data['categories']) && !empty($data['categories'])) : ?>
                            <?php foreach($data['categories'] as $category) : ?>
                                <tr id="category-<?php echo $category->category_id; ?>">
                                    <td class="category-image">
                                        <?php if (!empty($category->image_path)): ?>
                                            <img src="<?php echo URLROOT; ?>/public/img/categories/<?php echo htmlspecialchars($category->image_path); ?>" 
                                                 alt="<?php echo htmlspecialchars($category->name); ?>"
                                                 onerror="this.src='<?php echo URLROOT; ?>/public/img/default-category.jpg'">
                                        <?php else: ?>
                                            <img src="<?php echo URLROOT; ?>/public/img/default-category.jpg" 
                                                 alt="Default category image">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="category-badge">
                                            <?php echo htmlspecialchars($category->name); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($category->description); ?></td>
                                    <td class="actions">
                                        <button class="btn edit-btn" onclick="openEditCategoryModal(
                                            <?php echo $category->category_id; ?>, 
                                            '<?php echo htmlspecialchars(addslashes($category->name)); ?>', 
                                            '<?php echo htmlspecialchars(addslashes($category->description)); ?>',
                                            '<?php echo htmlspecialchars($category->image_path ?? ''); ?>'
                                        )">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                        <button class="btn delete-btn" onclick="deleteCategory(<?php echo $category->category_id; ?>)">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">No categories found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Category Modal (used for both Add and Edit) -->
        <div class="modal" id="categoryModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="modalTitle" class="modal-title">Add New Category</h3>
                    <button type="button" class="close" onclick="closeModal('categoryModal')">&times;</button>
                </div>
                
                <form id="categoryForm" action="<?php echo URLROOT; ?>/SysAdminP/addCategory" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="category_id" name="category_id" value="0">
                    
                    <div class="form-group">
                        <label class="form-label" for="name">Category Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div id="nameError" class="error-message"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="file-input-container">
                        <label class="form-label" for="category_image">Category Image:</label>
                        <input type="file" class="form-control" id="category_image" name="category_image" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                        <p class="form-text">Recommended size: 400x400px, Max: 2MB</p>
                        <img id="imagePreview" class="image-preview">
                        <p id="currentImageText"></p>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('categoryModal')">Cancel</button>
                        <button type="submit" id="submitBtn" class="btn">
                            <i class="fas fa-save"></i> <span id="submitBtnText">Add Category</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Alert -->
        <div class="alert-overlay" id="deleteAlert">
            <div class="alert-box">
                <h3>Confirm Delete</h3>
                <p>Are you sure you want to delete this category? This action cannot be undone.</p>
                <div class="alert-actions">
                    <button class="btn btn-outline" onclick="closeDeleteAlert()">Cancel</button>
                    <button class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <script>
            let editingCategoryId = null;
            let currentImagePath = '';

            function openAddCategoryModal() {
                document.getElementById('modalTitle').textContent = 'Add New Category';
                document.getElementById('submitBtnText').textContent = 'Add Category';
                document.getElementById('submitBtn').innerHTML = '<i class="fas fa-plus"></i> Add Category';
                
                document.getElementById('categoryForm').action = '<?php echo URLROOT; ?>/SysAdminP/addCategory';
                document.getElementById('category_id').value = '0';
                document.getElementById('name').value = '';
                document.getElementById('description').value = '';
                document.getElementById('nameError').style.display = 'none';
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('currentImageText').textContent = '';
                document.getElementById('category_image').value = '';
                
                currentImagePath = '';
                document.getElementById('categoryModal').style.display = 'flex';
            }

            function openEditCategoryModal(categoryId, name, description, imagePath) {
                document.getElementById('modalTitle').textContent = 'Edit Category';
                document.getElementById('submitBtnText').textContent = 'Update Category';
                document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Update Category';
                
                document.getElementById('categoryForm').action = '<?php echo URLROOT; ?>/SysAdminP/updateCategory';
                document.getElementById('category_id').value = categoryId;
                document.getElementById('name').value = name;
                document.getElementById('description').value = description;
                document.getElementById('nameError').style.display = 'none';
                document.getElementById('category_image').value = '';
                
                // Handle image preview
                const imagePreview = document.getElementById('imagePreview');
                if (imagePath) {
                    imagePreview.src = '<?php echo URLROOT; ?>/public/img/categories/' + imagePath;
                    imagePreview.style.display = 'block';
                    document.getElementById('currentImageText').textContent = 'Current image: ' + imagePath;
                } else {
                    imagePreview.style.display = 'none';
                    document.getElementById('currentImageText').textContent = 'No image currently uploaded';
                }
                
                currentImagePath = imagePath;
                editingCategoryId = categoryId;
                document.getElementById('categoryModal').style.display = 'flex';
            }

            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
                editingCategoryId = null;
            }

            function searchCategory() {
                const input = document.getElementById('searchCategoryInput').value.toLowerCase();
                const table = document.getElementById('categoryTable');
                const rows = table.getElementsByTagName('tr');

                for (let i = 0; i < rows.length; i++) {
                    const nameCell = rows[i].getElementsByTagName('td')[1]; // Name is in second column
                    if (nameCell) {
                        const name = nameCell.textContent.toLowerCase();
                        rows[i].style.display = name.includes(input) ? '' : 'none';
                    }
                }
            }

            function deleteCategory(categoryId) {
                document.getElementById('deleteAlert').style.display = 'flex';
                document.getElementById('confirmDeleteBtn').onclick = function() {
                    window.location.href = '<?php echo URLROOT; ?>/SysAdminP/deleteCategory/' + categoryId;
                }
            }

            function closeDeleteAlert() {
                document.getElementById('deleteAlert').style.display = 'none';
            }

            function previewImage(input, previewId) {
                const preview = document.getElementById(previewId);
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        document.getElementById('currentImageText').textContent = 'New image selected';
                    }
                    
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Add this function to display error messages
            function showError(message) {
                const errorElement = document.getElementById('nameError');
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }

            // Update the form submission to use AJAX for validation
            document.getElementById('categoryForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const nameInput = document.getElementById('name');
                const name = nameInput.value.trim();
                
                if (!name) {
                    showError('Category name is required');
                    return;
                }
                
                // Clear any previous errors
                document.getElementById('nameError').style.display = 'none';
                
                // Check if name already exists (except for editing category)
                const existingCategories = <?php echo json_encode(array_column($data['categories'] ?? [], 'name')); ?>;
                const isDuplicate = existingCategories.some(category => 
                    category.toLowerCase() === name.toLowerCase() && 
                    (!editingCategoryId || !document.querySelector(`tr#category-${editingCategoryId} .category-badge`)?.textContent?.trim().toLowerCase() === name.toLowerCase())
                );
                
                if (isDuplicate) {
                    showError('Category name already exists');
                    return;
                }
                
                // Submit the form if validation passes
                this.submit();
            });

            // Close modals when clicking outside
            window.onclick = function(event) {
                const modal = document.getElementById('categoryModal');
                const deleteAlert = document.getElementById('deleteAlert');
                
                if (event.target == modal) {
                    closeModal('categoryModal');
                }
                
                if (event.target == deleteAlert) {
                    closeDeleteAlert();
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
