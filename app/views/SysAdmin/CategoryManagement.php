<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <?php require APPROOT.'/views/SysAdmin/SideNavBar.php'?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <style>
        /* Typography */
        :root {
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        * {
            font-family: var(--font-family);
        }
        
        .category-container {
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
        }

        .category-table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            border-radius: 4px;
            overflow: hidden;
        }

        .category-table th {
            background-color: #a26b98;
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .category-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .category-table tbody tr:hover {
            background-color: #f9f5f0;
        }

        .add-category-btn {
            background-color: #a26b98;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin: 20px 0;
            font-size: 14px;
        }

        .add-category-btn:hover {
            background-color: #5d2e46;
        }

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

        .category-image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }

        #imagePreview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h7><i class="fas fa-th-list"></i>Category Management</h7>
    </header>

    <div class="category-container">
        <?php flash('category_message'); ?>

        <div class="search-container">
            <input type="text" class="search-input" id="searchCategory" placeholder="Search category...">
            <button class="add-category-btn" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>

        <table class="category-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['categories'] as $category) : ?>
                    <tr>
                        <td class="category-image">
                            <?php if($category->image_path): ?>
                                <img src="<?php echo URLROOT; ?>/public/img/categories/<?php echo $category->image_path; ?>" 
                                     alt="<?php echo $category->name; ?>">
                            <?php endif; ?>
                        </td>
                        <td><?php echo $category->name; ?></td>
                        <td><?php echo $category->description; ?></td>
                        <td>
                            <button class="action-btn" 
                                    data-id="<?php echo $category->category_id; ?>" 
                                    onclick='openEditModal(<?php echo json_encode($category, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'>
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('addCategoryModal')">&times;</span>
            <div class="modal-header">
                <h2>Add New Category</h2>
            </div>
            <form id="addCategoryForm" method="POST" action="<?php echo URLROOT; ?>/SysAdminP/addCategory" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="category_image">Image</label>
                    <input type="file" id="category_image" name="category_image" accept="image/*" onchange="previewImage(this)">
                    <img id="imagePreview">
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel-btn" onclick="closeModal('addCategoryModal')">Cancel</button>
                    <button type="submit" class="modal-btn save-btn">Save Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('editCategoryModal')">&times;</span>
            <div class="modal-header">
                <h2>Edit Category</h2>
            </div>
            <form id="editCategoryForm" method="POST" action="<?php echo URLROOT; ?>/SysAdminP/updateCategory" enctype="multipart/form-data">
                <input type="hidden" id="edit_category_id" name="category_id">
                <div class="form-group">
                    <label for="edit_name">Category Name</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_category_image">Image</label>
                    <input type="file" id="edit_category_image" name="category_image" accept="image/*" onchange="previewImage(this, 'edit_imagePreview')">
                    <img id="edit_imagePreview" class="image-preview">
                    <div id="current_image"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel-btn" onclick="closeModal('editCategoryModal')">Cancel</button>
                    <button type="submit" class="modal-btn save-btn">Update Category</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Add this at the top of your script section
        const URLROOT = '<?php echo URLROOT; ?>';
        
        function openAddModal() {
            document.getElementById('addCategoryModal').style.display = 'block';
            document.getElementById('imagePreview').style.display = 'none';
        }

        function openEditModal(category) {
            try {
                console.log('Category data:', category); // Debug log
                
                // Populate form fields with correct property names
                document.getElementById('edit_category_id').value = category.category_id;
                document.getElementById('edit_name').value = category.name;
                document.getElementById('edit_description').value = category.description;
                
                // Handle image preview
                const imagePreview = document.getElementById('edit_imagePreview');
                const currentImageDiv = document.getElementById('current_image');
                
                if (category.image_path) {
                    currentImageDiv.innerHTML = `
                        <img src="${URLROOT}/public/img/categories/${category.image_path}" 
                             style="max-width: 100px; margin: 10px 0;" />
                        <p>Current image</p>`;
                    imagePreview.style.display = 'none';
                } else {
                    currentImageDiv.innerHTML = '<p>No current image</p>';
                    imagePreview.style.display = 'none';
                }
                
                // Show the modal
                document.getElementById('editCategoryModal').style.display = 'block';
            } catch (error) {
                console.error('Error in openEditModal:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to open edit modal: ' + error.message,
                    icon: 'error',
                    confirmButtonColor: '#a26b98'
                });
            }
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

        function previewImage(input, previewId = 'imagePreview') {
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

        // Form submissions with SweetAlert
        document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Add Category',
                text: 'Are you sure you want to add this category?',
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

        document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Update Category',
                text: 'Are you sure you want to update this category?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#a26b98',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(this);
                    
                    fetch(`${URLROOT}/SysAdminP/updateCategory`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            document.getElementById('editCategoryModal').style.display = 'none';
                            updateTableRow(data.category);
                            
                            Swal.fire({
                                title: 'Success!',
                                text: 'Category updated successfully',
                                icon: 'success',
                                confirmButtonColor: '#a26b98'
                            }).then(() => {
                                // Optional: Refresh the page after success
                                // window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Failed to update category');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: error.message || 'Failed to update category',
                            icon: 'error',
                            confirmButtonColor: '#a26b98'
                        });
                    });
                }
            });
        });

        // Add this function to update the table row
        function updateTableRow(category) {
            const rows = document.querySelectorAll('.category-table tbody tr');
            rows.forEach(row => {
                const categoryId = row.querySelector('button').getAttribute('data-id');
                if (categoryId === category.category_id.toString()) {
                    row.cells[0].innerHTML = category.image_path ? 
                        `<div class="category-image">
                            <img src="${URLROOT}/public/img/categories/${category.image_path}" 
                                 alt="${category.name}">
                        </div>` : 
                        '';
                    row.cells[1].textContent = category.name;
                    row.cells[2].textContent = category.description;
                }
            });
        }

        // Search functionality
        document.getElementById('searchCategory').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let rows = document.querySelectorAll('.category-table tbody tr');
            
            rows.forEach(row => {
                let name = row.cells[1].textContent.toLowerCase();
                let description = row.cells[2].textContent.toLowerCase();
                
                if (name.includes(searchText) || description.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
