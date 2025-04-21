<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
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
            width: calc(100% - 180px); /* Increased from 250px to give more space */
            overflow-x: auto; /* Adds horizontal scroll if needed */
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
            min-width: 1200px;
            border-spacing: 0; /* Remove any spacing between cells */
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            height: 100px; /* Set a fixed height for all cells */
            box-sizing: border-box; /* Include padding in height calculation */
        }

        table th {
            background-color: #c98d83;
            color: white;
        }

        table td {
            background-color: #ffff;
            vertical-align: middle; /* Vertically center content */
            padding: 12px;
            height: 100px; /* Set fixed height */
        }

        /* Adjust specific column widths */
        table th:nth-child(1), /* Image column */
        table td:nth-child(1) {
            width: 120px;
        }

        table th:nth-child(2), /* Name column */
        table td:nth-child(2) {
            width: 20%;
        }

        table th:nth-child(3), /* Price column */
        table td:nth-child(3) {
            width: 12%;
        }

        table th:nth-child(4), /* Quantity column */
        table td:nth-child(4) {
            width: 10%;
        }

        table th:nth-child(5), /* Expiry Date column */
        table td:nth-child(5) {
            width: 12%;
        }

        table th:nth-child(6), /* Category column */
        table td:nth-child(6) {
            width: 15%;
        }

        table th:nth-child(7), /* Actions column */
        table td:nth-child(7) {
            width: 15%;
        }

        .actions {
            display: flex;
            gap: 10px;
            justify-content: center; /* Center the buttons */
            align-items: center; /* Center buttons vertically */
            height: 100%; /* Full height */
        }

        .actions .btn {
            padding: 8px 15px;
            font-size: 0.9rem;
            margin: 0; /* Remove any margins */
            min-width: 70px;
        }

        /* Specific style for the actions column */
        table td:last-child {
            padding: 12px;
            width: auto; /* Let it adjust to content */
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

        .modal-content input, .modal-content select, .modal-content textarea {
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
            width: 100%;
        }

        .search-bar form {
            display: flex;
            width: 100%;
            justify-content: space-between;
        }

        .search-bar input {
            width: 85%;
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
            width: 12%;
        }

        .search-bar button:hover {
            background-color: #783b31;
        }

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .product-image-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
            display: none;
        }

        .file-input-container {
            position: relative;
            margin-bottom: 15px;
        }

        .file-input-container input[type="file"] {
            padding-top: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

    <header class="header">
        <div class="header-left">
            <i class="fas fa-box"></i>
            <span>Product Management</span>
        </div>
        <div class="header-role">
            <span>System Administrator</span>
        </div>
    </header>

    <div class="content">
        <?php flash('product_message'); ?>
        
        <div class="search-bar">
            <form action="<?php echo URLROOT; ?>/SysAdminP/searchProduct" method="GET">
                <input type="text" 
                       name="search" 
                       placeholder="Search by product name..." 
                       value="<?php echo isset($data['search']) ? htmlspecialchars($data['search']) : ''; ?>">
                <button type="submit">
                    Search
                </button>
            </form>
        </div>
        
        <button class="btn" onclick="openAddModal()">+ Add Product</button>
        
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTable">
                <?php if(isset($data['products']) && is_array($data['products'])) : ?>
                    <?php foreach($data['products'] as $product) : ?>
                        <tr id="product-<?php echo $product->product_id; ?>">
                            <td>
                                <?php if(!empty($product->image_path)): ?>
                                    <img src="<?php echo URLROOT; ?>/public/img/products/<?php echo $product->image_path; ?>" 
                                        alt="<?php echo htmlspecialchars($product->product_name); ?>" class="product-image">
                                <?php else: ?>
                                    <img src="<?php echo URLROOT; ?>/public/img/no-image.png" alt="No Image" class="product-image">
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($product->product_name); ?></td>
                            <td>LKR <?php echo number_format($product->price, 2); ?></td>
                            <td><?php echo $product->available_quantity; ?></td>
                            <td><?php echo $product->expiry_date ? date('Y-m-d', strtotime($product->expiry_date)) : 'Not set'; ?></td>
                            <td><?php echo htmlspecialchars($product->category_name); ?></td>
                            <td class="actions">
                                <button class="btn" onclick="openEditModal(<?php echo $product->product_id; ?>, 
                                    '<?php echo htmlspecialchars(addslashes($product->product_name)); ?>', 
                                    '<?php echo htmlspecialchars(addslashes($product->description)); ?>', 
                                    <?php echo $product->price; ?>, 
                                    <?php echo $product->available_quantity; ?>, 
                                    <?php echo $product->category_id; ?>,
                                    '<?php echo $product->image_path; ?>',
                                    '<?php echo $product->expiry_date; ?>')">
                                    Edit
                                </button>
                                <button class="btn delete-btn" onclick="confirmDelete(<?php echo $product->product_id; ?>)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Product Modal -->
    <div class="modal" id="addProductModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addProductModal')">&times;</span>
            <h2>Add Product</h2>
            <form id="addProductForm" action="<?php echo URLROOT; ?>/SysAdminP/addProduct" method="POST" enctype="multipart/form-data" onsubmit="return validateAddProductForm()">
                <div class="file-input-container">
                    <label for="product_image">Product Image:</label>
                    <input type="file" id="add_product_image" name="product_image" accept="image/*" onchange="previewImage(this, 'addImagePreview')">
                    <img id="addImagePreview" class="product-image-preview" src="" alt="Preview">
                </div>
                
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="3"></textarea>
                
                <label for="price">Price (LKR):</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required>
                
                <label for="available_quantity">Available Quantity:</label>
                <input type="number" id="available_quantity" name="available_quantity" min="0" required>
                
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php if(isset($data['categories']) && is_array($data['categories'])) : ?>
                        <?php foreach($data['categories'] as $category) : ?>
                            <option value="<?php echo $category->category_id; ?>"><?php echo htmlspecialchars($category->name); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date">
                
                <button type="submit" class="btn">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal" id="editProductModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editProductModal')">&times;</span>
            <h2>Edit Product</h2>
            <form id="editProductForm" action="<?php echo URLROOT; ?>/SysAdminP/updateProduct" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit_product_id" name="product_id">
                
                <div class="file-input-container">
                    <label for="edit_product_image">Product Image:</label>
                    <input type="file" id="edit_product_image" name="product_image" accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                    <img id="editImagePreview" class="product-image-preview" src="" alt="Preview">
                    <p id="currentImageText">Current image: <span id="currentImageName"></span></p>
                </div>
                
                <label for="edit_product_name">Product Name:</label>
                <input type="text" id="edit_product_name" name="product_name" required>
                
                <label for="edit_description">Description:</label>
                <textarea id="edit_description" name="description" rows="3"></textarea>
                
                <label for="edit_price">Price (LKR):</label>
                <input type="number" id="edit_price" name="price" step="0.01" min="0" required>
                
                <label for="edit_available_quantity">Available Quantity:</label>
                <input type="number" id="edit_available_quantity" name="available_quantity" min="0" required>
                
                <label for="edit_category_id">Category:</label>
                <select id="edit_category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php if(isset($data['categories']) && is_array($data['categories'])) : ?>
                        <?php foreach($data['categories'] as $category) : ?>
                            <option value="<?php echo $category->category_id; ?>"><?php echo htmlspecialchars($category->name); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                
                <label for="edit_expiry_date">Expiry Date:</label>
                <input type="date" id="edit_expiry_date" name="expiry_date">
                
                <button type="submit" class="btn">Update Product</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addProductModal').style.display = 'flex';
        document.getElementById('addImagePreview').style.display = 'none';
    }

    function openEditModal(productId, productName, description, price, quantity, categoryId, imagePath, expiryDate) {
        document.getElementById('edit_product_id').value = productId;
        document.getElementById('edit_product_name').value = productName;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_available_quantity').value = quantity;
        document.getElementById('edit_category_id').value = categoryId;
        
        // Handle image preview
        const imagePreview = document.getElementById('editImagePreview');
        if (imagePath) {
            imagePreview.src = '<?php echo URLROOT; ?>/public/img/products/' + imagePath;
            imagePreview.style.display = 'block';
            document.getElementById('currentImageName').textContent = imagePath;
        } else {
            imagePreview.style.display = 'none';
            document.getElementById('currentImageName').textContent = 'No image';
        }
        
        document.getElementById('edit_expiry_date').value = expiryDate ? expiryDate.split(' ')[0] : '';
        
        document.getElementById('editProductModal').style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function confirmDelete(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            window.location.href = '<?php echo URLROOT; ?>/SysAdminP/deleteProduct/' + productId;
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
        } else {
            preview.style.display = 'none';
        }
    }
    
    // Close modals when clicking outside of them
    window.onclick = function(event) {
        const addModal = document.getElementById('addProductModal');
        const editModal = document.getElementById('editProductModal');
        
        if (event.target == addModal) {
            addModal.style.display = "none";
        }
        
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }

    function validateAddProductForm() {
        const form = document.getElementById('addProductForm');
        const productName = form.product_name.value.trim();
        const price = form.price.value;
        const quantity = form.available_quantity.value;
        const category = form.category_id.value;

        if (!productName) {
            alert('Please enter a product name');
            return false;
        }
        if (!price || price <= 0) {
            alert('Please enter a valid price');
            return false;
        }
        if (!quantity || quantity < 0) {
            alert('Please enter a valid quantity');
            return false;
        }
        if (!category) {
            alert('Please select a category');
            return false;
        }
        return true;
    }
</script>
</body>
</html>