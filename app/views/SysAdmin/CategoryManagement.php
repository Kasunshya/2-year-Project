<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
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
            padding: 25px;
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

        /* Add these to your existing styles */
        .category-image img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 1rem;
            font-family: Arial, sans-serif;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .alert-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .alert-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .alert-buttons button {
            padding: 8px 20px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .confirm-delete {
            background-color: #dc3545;
            color: white;
        }

        .cancel-delete {
            background-color: #6c757d;
            color: white;
        }

        /* Add this to your existing <style> section */
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            margin-bottom: 10px;
            display: none;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .is-invalid + .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

    <header class="header">
        <div class="header-left">
            <i class="fas fa-tags"></i>
            <span>Category Management</span>
        </div>
        <div class="header-role">
            <span>System Administrator</span>
        </div>
    </header>

    <div class="content">
        <div class="search-bar">
            <input type="text" id="searchCategoryInput" placeholder="Search Category by Name">
            <button onclick="searchCategory()">Search</button>
        </div>
        <button class="btn" onclick="openAddCategoryModal()">+ Add Category</button>
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
        <?php foreach ($data['categories'] as $category) : ?>
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
                <td><?php echo htmlspecialchars($category->name); ?></td>
                <td><?php echo htmlspecialchars($category->description); ?></td>
                <td class="actions">
                    <button class="btn" onclick="openEditCategoryModal(<?php echo $category->category_id; ?>)">Edit</button>
                    <button class="btn delete-btn" onclick="deleteCategory(<?php echo $category->category_id; ?>)">Delete</button>
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

    <!-- Modal -->
    <div class="modal" id="categoryModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('categoryModal')">&times;</span>
            <h2 id="categoryModalTitle">Add Category</h2>
            <form id="categoryForm" action="<?php echo URLROOT; ?>/sysadminp/addCategory" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Category Name: <sup>*</sup></label>
                    <input type="text" 
                           id="category_name"
                           name="name" 
                           class="form-control <?php echo (isset($data['name_err']) && !empty($data['name_err'])) ? 'is-invalid' : ''; ?>" 
                           value="<?php echo isset($data['name']) ? htmlspecialchars($data['name']) : ''; ?>">
                    <span class="invalid-feedback"><?php echo isset($data['name_err']) ? htmlspecialchars($data['name_err']) : ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" 
                           id="category_description"
                           name="description" 
                           class="form-control <?php echo (isset($data['description_err']) && !empty($data['description_err'])) ? 'is-invalid' : ''; ?>"
                           value="<?php echo isset($data['description']) ? htmlspecialchars($data['description']) : ''; ?>">
                    <span class="invalid-feedback"><?php echo isset($data['description_err']) ? htmlspecialchars($data['description_err']) : ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="category_image">Category Image:</label>
                    <input type="file" 
                           name="category_image" 
                           class="form-control" 
                           accept="image/*">
                    <span class="invalid-feedback"><?php echo isset($data['image_err']) ? htmlspecialchars($data['image_err']) : ''; ?></span>
                </div>

                <input type="submit" class="btn btn-success" value="Add Category" id="submitButton">
            </form>
        </div>
    </div>
</div>
</div>

<div class="alert-overlay" id="deleteAlert">
    <div class="alert-box">
        <h3>Delete Category</h3>
        <p>Are you sure you want to delete this category?</p>
        <div class="alert-buttons">
            <button class="cancel-delete" onclick="closeDeleteAlert()">Cancel</button>
            <button class="confirm-delete" id="confirmDelete">Delete</button>
        </div>
    </div>
</div>

<script>
    let editingCategoryId = null;

    function openAddCategoryModal() {
        document.getElementById('categoryModalTitle').textContent = "Add Category";
        document.getElementById('submitButton').value = "Add Category";  // Add this line
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryForm').action = "<?php echo URLROOT; ?>/SysAdminP/addCategory";
        const hiddenInput = document.getElementById('category_id_input');
        if (hiddenInput) {
            hiddenInput.remove();
        }
        document.getElementById('categoryModal').style.display = 'flex';
    }

    function openEditCategoryModal(categoryId) {
        let row = document.getElementById(`category-${categoryId}`);
        let cells = row.getElementsByTagName("td");

        document.getElementById('categoryModalTitle').textContent = "Update Category";
        document.getElementById('submitButton').value = "Update Category";  // Add this line
        document.getElementById('categoryForm').action = "<?php echo URLROOT; ?>/SysAdminP/updateCategory";
        
        // Add hidden input for category_id
        if (!document.getElementById('category_id_input')) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.id = 'category_id_input';
            hiddenInput.name = 'category_id';
            hiddenInput.value = categoryId;
            document.getElementById('categoryForm').appendChild(hiddenInput);
        } else {
            document.getElementById('category_id_input').value = categoryId;
        }

        // Populate modal fields with existing values
        // Note: cells[0] is image, cells[1] is name, cells[2] is description
        document.getElementById("category_name").value = cells[1].textContent.trim();
        document.getElementById("category_description").value = cells[2].textContent.trim();

        document.getElementById('categoryModal').style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function searchCategory() {
        const input = document.getElementById('searchCategoryInput').value.toLowerCase();
        const table = document.getElementById('categoryTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length > 0) {
                const categoryName = cells[1].textContent.toLowerCase(); // Changed index to 1 for name column
                const categoryDesc = cells[2].textContent.toLowerCase(); // Also search in description
                const shouldShow = categoryName.includes(input) || categoryDesc.includes(input);
                rows[i].style.display = shouldShow ? '' : 'none';
            }
        }
    }

    function deleteCategory(categoryId) {
        const deleteAlert = document.getElementById('deleteAlert');
        const confirmBtn = document.getElementById('confirmDelete');
        
        deleteAlert.style.display = 'flex';
        
        confirmBtn.onclick = function() {
            window.location.href = `<?php echo URLROOT; ?>/SysAdminP/deleteCategory/${categoryId}`;
        }
    }

    function closeDeleteAlert() {
        document.getElementById('deleteAlert').style.display = 'none';
    }

    // Add this function to your existing <script> section
    function showError(message) {
        const nameInput = document.getElementById('category_name');
        const errorSpan = nameInput.nextElementSibling;
        
        nameInput.classList.add('is-invalid');
        errorSpan.textContent = message;
        errorSpan.style.display = 'block';
    }

    // Update the form submission to use AJAX
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            if (html.includes('Category name already exists')) {
                showError('Category name already exists');
            } else {
                window.location.href = '<?php echo URLROOT; ?>/sysadminp/categoryManagement';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>
</html>
