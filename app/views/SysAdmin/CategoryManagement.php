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
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="categoryTable">
    <?php if (isset($data['categories']) && !empty($data['categories'])) : ?>
        <?php foreach ($data['categories'] as $category) : ?>
            <tr id="category-<?php echo $category->category_id; ?>">
                <td><?php echo htmlspecialchars($category->name); ?></td>
                <td><?php echo htmlspecialchars($category->description); ?></td>
                <td class="actions">
                    <button class="btn" onclick="openEditCategoryModal(<?php echo $category->category_id; ?>)">Edit</button>
                    <form method="POST" action="<?php echo URLROOT; ?>/SysAdminP/deleteCategory/<?php echo $category->category_id; ?>" style="display: inline;">
                        <button type="submit" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="3" style="text-align: center;">No categories found</td>
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
        <form id="categoryForm" method="POST" action="<?php echo URLROOT; ?>/SysAdminP/addCategory">
            <!-- We'll add hidden input for category_id dynamically when editing -->
            <label for="name">Category Name:</label>
            <input type="text" id="category_name" name="name" required>
            <label for="description">Description:</label>
            <input type="text" id="category_description" name="description" required>
            <button type="submit" class="btn">Save</button>
            <button type="button" class="btn" onclick="closeModal('categoryModal')">Close</button>
        </form>
    </div>
</div>
</div>

<script>
    let editingCategoryId = null;

    function openAddCategoryModal() {
        document.getElementById('categoryModalTitle').textContent = "Add Category";
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryForm').action = "<?php echo URLROOT; ?>/SysAdminP/addCategory";
        // Remove any hidden category_id field if it exists
        const hiddenInput = document.getElementById('category_id_input');
        if (hiddenInput) {
            hiddenInput.remove();
        }
        document.getElementById('categoryModal').style.display = 'flex';
    }

    function openEditCategoryModal(categoryId) {
        // Get the correct row
        let row = document.getElementById(`category-${categoryId}`);
        let cells = row.getElementsByTagName("td");

        // Update form for editing
        document.getElementById('categoryModalTitle').textContent = "Update Category";
        document.getElementById('categoryForm').action = "<?php echo URLROOT; ?>/SysAdminP/updateCategory";
        
        // Add hidden input for category_id if it doesn't exist
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

        // Populate modal fields with existing values - adjusted indices because Category ID column is removed
        document.getElementById("category_name").value = cells[0].textContent.trim();
        document.getElementById("category_description").value = cells[1].textContent.trim();

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
                const categoryName = cells[0].textContent.toLowerCase();
                rows[i].style.display = categoryName.includes(input) ? '' : 'none';
            }
        }
    }
</script>

</body>
</html>
