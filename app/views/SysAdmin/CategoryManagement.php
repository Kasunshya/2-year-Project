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
        <!-- Add this near the top of your content div to display flash messages -->
        <?php flash('category_message'); ?>
        <div class="search-bar">
        <input type="text" id="searchCategoryInput" placeholder="Search Category by Name">
        <button onclick="searchCategory()">Search</button>
        </div>
        <button class="btn" onclick="openModal()">+ Add Category</button>
        <table>
            <thead>
                <tr>
                    <!-- Removed the Category ID column -->
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="categoryTable">
                <?php if (!empty($data['categories'])): ?>
                    <?php foreach ($data['categories'] as $category): ?>
                        <tr id="category-<?php echo $category->category_id; ?>">
                            <td><?php echo $category->name; ?></td>
                            <td><?php echo $category->description; ?></td>
                            <td class="actions">
                                <button class="btn" onclick="openEditModal(
                                    '<?php echo $category->category_id; ?>',
                                    '<?php echo htmlspecialchars($category->name, ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars($category->description, ENT_QUOTES); ?>'
                                )">Edit</button>
                                <form action="<?php echo URLROOT; ?>/categories/delete/<?php echo $category->category_id; ?>" 
                                      method="POST" 
                                      style="display:inline;"
                                      onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                                    <button type="submit" class="btn delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No categories found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" id="addCategoryModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Add Category</h2>
        <form action="<?php echo URLROOT; ?>/categories/add" method="post">
            <label for="category_name">Name:</label>
            <input type="text" id="category_name" name="category_name" required>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required>
            <button type="submit" class="btn">Add Category</button>
        </form>
    </div>
</div>

<div class="modal" id="editCategoryModal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Category</h2>
        <form id="editCategoryForm" action="" method="post">
            <label for="edit_category_name">Name:</label>
            <input type="text" id="edit_category_name" name="category_name" required>
            <label for="edit_description">Description:</label>
            <input type="text" id="edit_description" name="description" required>
            <button type="submit" class="btn">Update Category</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('addCategoryModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('addCategoryModal').style.display = 'none';
    }

    function searchCategory() {
        const input = document.getElementById('searchCategoryInput').value.toLowerCase(); // Get the search input value
        const table = document.getElementById('categoryTable'); // Get the table body
        const rows = table.getElementsByTagName('tr'); // Get all rows in the table

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td'); // Get all cells in the row
            if (cells.length > 0) {
                const categoryName = cells[0].textContent.toLowerCase(); // Get the category name from the first cell
                // Show or hide the row based on whether the category name includes the search input
                if (categoryName.includes(input)) {
                    rows[i].style.display = ''; // Show the row
                } else {
                    rows[i].style.display = 'none'; // Hide the row
                }
            }
        }
    }

    // Open the Edit Modal and populate it with the selected category's data
    function openEditModal(categoryId, categoryName, categoryDescription) {
        document.getElementById('editCategoryModal').style.display = 'flex';
        document.getElementById('edit_category_name').value = categoryName;
        document.getElementById('edit_description').value = categoryDescription;

        // Update the form action dynamically to include the category ID
        document.getElementById('editCategoryForm').action = `<?php echo URLROOT; ?>/categories/edit/${categoryId}`;
    }

    // Close the Edit Modal
    function closeEditModal() {
        document.getElementById('editCategoryModal').style.display = 'none';
    }
</script>

</body>
</html>
