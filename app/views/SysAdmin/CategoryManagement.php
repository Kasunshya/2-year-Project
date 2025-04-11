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
                    <th>Category ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="categoryTable">
                <tr id="category-1">
                    <td>1</td>
                    <td>Waffles</td>
                    <td>Delicious variety of waffles</td>
                    <td class="actions">
                        <button class="btn" onclick="openEditCategoryModal(1)">Edit</button>
                        <button class="btn delete-btn" onclick="deleteCategory(1)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal" id="categoryModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('categoryModal')">&times;</span>
            <h2 id="categoryModalTitle">Add Category</h2>
            <form id="categoryForm">
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" required>
                <label for="category_description">Description:</label>
                <input type="text" id="category_description" required>
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
        editingCategoryId = null;
        document.getElementById('categoryModal').style.display = 'flex';
    }

    function openEditCategoryModal(categoryId) {
        editingCategoryId = categoryId;

        document.getElementById('categoryModalTitle').textContent = "Update Category";

        // Get the correct row
        let row = document.getElementById(`category-${categoryId}`);
        let cells = row.getElementsByTagName("td");

        // Populate modal fields with existing values
        document.getElementById("category_name").value = cells[1].textContent.trim();
        document.getElementById("category_description").value = cells[2].textContent.trim();

        document.getElementById('categoryModal').style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    document.getElementById('categoryForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('category_name').value;
        const description = document.getElementById('category_description').value;

        if (editingCategoryId) {
            let row = document.getElementById(`category-${editingCategoryId}`);
            let cells = row.getElementsByTagName("td");

            cells[1].textContent = name;
            cells[2].textContent = description;

            alert("Category updated successfully!");
        }

        editingCategoryId = null;
        closeModal('categoryModal');
    });

    function deleteCategory(categoryId) {
        if (confirm("Are you sure you want to delete this category?")) {
            let row = document.getElementById(`category-${categoryId}`);
            if (row) {
                row.remove();
                alert(`Category ${categoryId} deleted successfully!`);
            } else {
                alert("Category not found!");
            }
        }
    }

    function searchCategory() {
        const input = document.getElementById('searchCategoryInput').value.toLowerCase();
        const table = document.getElementById('categoryTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length > 0) {
                const categoryName = cells[1].textContent.toLowerCase();
                rows[i].style.display = categoryName.includes(input) ? '' : 'none';
            }
        }
    }
</script>

</body>

</html>

