<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f1ec;
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

        .btn:hover {
            background-color: #b27b71;
        }

        .delete-btn {
            background-color: #c98d83;
        }

        .delete-btn:hover {
            background-color: #b27b71;
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

        .modal-content input,
        .modal-content textarea,
        .modal-content select {
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

        /* Checkbox styling */
        input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 1200px) {
            .content {
                margin-left: 100px;
                width: calc(100% - 150px);
            }

            .header {
                margin-left: 100px;
            }
        }

        @media screen and (max-width: 768px) {
            .content {
                margin-left: 0;
                width: 100%;
                padding: 10px;
            }

            .header {
                margin-left: 0;
                margin-right: 0;
                border-radius: 0;
            }

            .modal-content {
                width: 90%;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

    <header class="header">
        <div class="header-left">
            <i class="fas fa-utensils"></i>
            <span>Product Management</span>
        </div>
        <div class="header-role">
            <span>System Administrator</span>
        </div>
    </header>
 
           
    <div class="content">
    <div class="search-bar">
                <input type="text" id="searchProductInput" placeholder="Search Product by ID">
                <button onclick="searchProduct()">Search</button>
                </div>
        <button class="btn" onclick="openAddFoodModal()">+ Add Food Item</button>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTable">
                <?php if (!empty($data['products'])): ?>
                    <?php foreach ($data['products'] as $product): ?>
                        <tr id="product-<?php echo $product->product_id; ?>">
                            <td><?php echo $product->product_name; ?></td>
                            <td><?php echo $product->category_name; ?></td>
                            <td><?php echo $product->description; ?></td>
                            <td><?php echo $product->price; ?></td>
                            <td><?php echo $product->available_quantity; ?></td>
                            <td><?php echo $product->status ? 'Active' : 'Inactive'; ?></td>
                            <td>
                                <button class="btn" onclick="openEditModal(<?php echo $product->product_id; ?>)">Edit</button>
                                <form action="<?php echo URLROOT; ?>/products/delete/<?php echo $product->product_id; ?>" method="POST" style="display:inline;">
                                    <button type="submit" class="btn delete-btn" onclick="return confirm('Are you sure?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Add Product Modal -->
        <div id="addProductModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addProductModal')">&times;</span>
                <h2>Add Product</h2>
                <form action="<?php echo URLROOT; ?>/products/add" method="POST">
                    <label for="product_name">Product Name:</label>
                    <input type="text" name="product_name" required>

                    <label for="description">Description:</label>
                    <textarea name="description" required></textarea>

                    <label for="price">Price:</label>
                    <input type="number" name="price" step="0.01" required>

                    <label for="available_quantity">Quantity:</label>
                    <input type="number" name="available_quantity" required>

                    <label for="category_id">Category:</label>
                    <select name="category_id" required>
                        <option value="">Select Category</option>
                        <?php foreach ($data['categories'] as $category): ?>
                            <option value="<?php echo $category->category_id; ?>">
                                <?php echo $category->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="status">Status:</label>
                    <input type="checkbox" name="status" value="1" checked>

                    <button type="submit" class="btn">Add Product</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="foodModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('foodModal')">&times;</span>
            <h2 id="foodModalTitle">Add Food Item</h2>
            <form id="foodForm" action="<?php echo URLROOT; ?>/products/add" method="post" enctype="multipart/form-data">
                <input type="hidden" id="product_id" name="product_id">
                <label for="food_name">Name:</label>
                <input type="text" id="food_name" name="product_name" required> 
              
                <label for="food_description">Description:</label>
                <textarea id="food_description" name="description" required></textarea>
                <label for="food_price">Price:</label>
                <input type="number" id="food_price" name="price" required>
                <label for="food_quantity">Quantity:</label>
                <input type="number" id="food_quantity" name="available_quantity" required>
                <label for="food_category">Category:</label>
                <select id="food_category" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($data['categories'] as $category): ?>
                        <option value="<?php echo $category->category_id; ?>"><?php echo $category->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="food_status">Status:</label>
                <input type="checkbox" id="food_status" name="status">
                <label for="product_image">Image:</label>
                <input type="file" id="product_image" name="product_image" accept="image/*">
                <button type="submit" class="btn">Save</button>
                <button type="button" class="btn" onclick="closeModal('foodModal')">Close</button>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editProductModal')">&times;</span>
        <h2>Edit Product</h2>
        <form action="<?php echo URLROOT; ?>/products/update" method="POST">
            <input type="hidden" name="product_id" id="edit_product_id">
            
            <label for="edit_product_name">Product Name:</label>
            <input type="text" name="product_name" id="edit_product_name" required>

            <label for="edit_description">Description:</label>
            <textarea name="description" id="edit_description" required></textarea>

            <label for="edit_price">Price:</label>
            <input type="number" name="price" id="edit_price" step="0.01" required>

            <label for="edit_available_quantity">Quantity:</label>
            <input type="number" name="available_quantity" id="edit_available_quantity" required>

            <label for="edit_category_id">Category:</label>
            <select name="category_id" id="edit_category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($data['categories'] as $category): ?>
                    <option value="<?php echo $category->category_id; ?>">
                        <?php echo $category->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="edit_status">Status:</label>
            <input type="checkbox" name="status" id="edit_status" value="1">

            <button type="submit" class="btn">Update Product</button>
        </form>
    </div>
</div>

<script>
    function openAddFoodModal() {
        document.getElementById('foodModalTitle').textContent = "Add Food Item";
        document.getElementById('foodForm').reset();
        document.getElementById('foodModal').style.display = 'flex';
    }

    function openEditFoodModal(productId) {
        document.getElementById('foodModalTitle').textContent = "Update Food Item";

        let row = document.getElementById(`food-${productId}`);
        let cells = row.getElementsByTagName("td");

        document.getElementById("food_name").value = cells[2].textContent.trim();
        document.getElementById("food_category").value = cells[3].textContent.trim();
        document.getElementById("food_description").value = cells[4].textContent.trim();
        document.getElementById("food_price").value = parseFloat(cells[5].textContent.replace('LKR', '').trim());
        document.getElementById("food_quantity").value = cells[6].textContent.trim();

        document.getElementById('foodModal').style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Update the form submission handler in ProductManagement.php
    document.getElementById('foodForm').addEventListener('submit', function(e) {
        // Remove the preventDefault() to allow form submission
        // e.preventDefault();
        return true;
    });
</script>

<script>
function deleteFood(fproductId) {
    if (confirm("Are you sure you want to delete this food item?")) {
        let row = document.getElementById(`food-${productId}`);
        if (row) {
            row.remove();
            alert(`Food item ${productId} deleted successfully!`);
        } else {
            alert("Food item not found!");
        }
    }
}

// Add this to your existing JavaScript in ProductManagement.php
function searchProduct() {
    const searchInput = document.getElementById('searchProductInput').value;
    const tableRows = document.querySelectorAll('#productTable tr');
    
    tableRows.forEach(row => {
        const productId = row.querySelector('td:first-child').textContent;
        const productName = row.querySelector('td:nth-child(3)').textContent;
        
        if (productId.includes(searchInput) || 
            productName.toLowerCase().includes(searchInput.toLowerCase())) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Add event listener for real-time search
document.getElementById('searchProductInput').addEventListener('keyup', searchProduct);

function openEditModal(productId) {
    const modal = document.getElementById('editProductModal');
    const row = document.getElementById('product-' + productId);
    
    // Get the cells from the row
    const cells = row.getElementsByTagName('td');
    
    // Set the values in the edit form
    document.getElementById('edit_product_id').value = productId;
    document.getElementById('edit_product_name').value = cells[0].innerText;
    document.getElementById('edit_description').value = cells[2].innerText;
    document.getElementById('edit_price').value = cells[3].innerText;
    document.getElementById('edit_available_quantity').value = cells[4].innerText;
    
    // Set the category
    const categorySelect = document.getElementById('edit_category_id');
    const categoryOptions = categorySelect.options;
    for (let i = 0; i < categoryOptions.length; i++) {
        if (categoryOptions[i].text === cells[1].innerText) {
            categorySelect.selectedIndex = i;
            break;
        }
    }
    
    // Set the status checkbox
    document.getElementById('edit_status').checked = cells[5].innerText === 'Active';
    
    modal.style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}
</script>


</body>
</html>