<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Product Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
        <div class="container">
            <!-- Sidebar -->
            <?php require_once APPROOT.'/views/HeadM/inc/sidebar.php'; ?>
            <!-- Main Content -->
            <main>
                <header class="header">
                    <h1><i class="fas fa-warehouse icon-inventory"></i>&nbsp PRODUCTS</h1>
                    <div class="user-info">
                        <span><b>HEAD MANAGER</span></b></span>
                    </div>
                </header>
                <div class="content">
                <button class="btn add-employee">+ Add New Product</button>
            
                <!-- Add Product Modal -->
                <div id="employeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">×</span>
                        <h2>Add New Product</h2>
                        <form action="<?php echo URLROOT; ?>/HeadM/addProduct" method="post">
                            <label for="product_name">Product Name:</label>
                            <input type="text" id="product_name" name="product_name" required>

                            <label for="price">Price (Rs.):</label>
                            <input type="number" id="price" name="price" required min="0" step="0.01">

                            <label for="description">Description:</label>
                            <textarea id="description" name="description" required></textarea>

                            <label for="category_id">Category:</label>
                            <select id="category_id" name="category_id" required>
                                <?php foreach ($data['categories'] as $category): ?>
                                    <option value="<?php echo $category->category_id; ?>"><?php echo $category->name; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="available_quantity">Available Quantity:</label>
                            <input type="number" id="available_quantity" name="available_quantity" required min="0" step="1">

                            <div class="buttons">
                                <button type="reset" class="btn reset">Reset</button>
                                <button type="submit" name="add_product" class="btn submit">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Product Modal -->
                <div id="editemployeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('editemployeeModal')">×</span>
                        <h2>Update Product</h2>
                        <form action="<?php echo URLROOT; ?>/HeadM/editProduct" method="post">
                            <input type="hidden" id="edit_product_id" name="product_id">

                            <label for="edit_product_name">Product Name:</label>
                            <input type="text" id="edit_product_name" name="product_name" required>

                            <label for="edit_price">Price (Rs.):</label>
                            <input type="number" id="edit_price" name="price" required min="0" step="0.01">

                            <label for="edit_description">Description:</label>
                            <textarea id="edit_description" name="description" required></textarea>

                            <label for="edit_category_id">Category:</label>
                            <select id="edit_category_id" name="category_id" required>
                                <?php foreach ($data['categories'] as $category): ?>
                                    <option value="<?php echo $category->category_id; ?>"><?php echo $category->name; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="edit_available_quantity">Available Quantity:</label>
                            <input type="number" id="edit_available_quantity" name="available_quantity" required min="0" step="1">

                            <div class="buttons">
                                <button type="submit" class="btn submit">Save Changes</button>
                                <button type="button" class="btn reset" onclick="closeModal('editemployeeModal')">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="deleteemployeeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Delete Product</h2>
                        <p>Are you sure you want to delete this product?</p>
                        <div class="buttons">
                            <button type="submit" id="confirmDelete" class="btn reset">Yes</button>
                            <button type="reset" class="btn submit">No</button>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="deleteProductModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('deleteProductModal')">&times;</span>
                        <h2>Delete Product</h2>
                        <p>Are you sure you want to delete this product?</p>
                        <div class="buttons">
                            <button class="btn submit" id="confirmDeleteButton">Yes, Delete</button>
                            <button class="btn reset" onclick="closeModal('deleteProductModal')">Cancel</button>
                        </div>
                    </div>
                </div>

                <div class="employee-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by User Name">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Price (Rs.)</th>
                                    <th>Available Quantity</th>
                                    <th>Star Rating</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['products'] as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product->product_name); ?></td>
                                        <td><?php echo htmlspecialchars($product->description); ?></td>
                                        <td>Rs. <?php echo number_format($product->price, 2); ?></td>
                                        <td><?php echo htmlspecialchars($product->available_quantity); ?></td>
                                        <td><?php echo htmlspecialchars($product->star_rating); ?> / 5</td>
                                        <td><?php echo htmlspecialchars($product->category_name); ?></td>
                                        <td>
                                            <button class="btn edit" onclick="openEditModal(<?php echo $product->product_id; ?>)">Update</button>
                                            <button class="btn delete" onclick="openDeleteModal(<?php echo $product->product_id; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/BranchManagers.js"></script>
    <script>
        function openEditModal(productId) {
            console.log('Opening edit modal for product ID:', productId); // Debugging log

            // Fetch the product details using AJAX
            fetch(`<?php echo URLROOT; ?>/HeadM/getProductById/${productId}`)
                .then(response => response.json())
                .then(product => {
                    console.log('Product details fetched:', product); // Debugging log

                    // Populate the form fields with the product details
                    document.getElementById('edit_product_id').value = product.product_id;
                    document.getElementById('edit_product_name').value = product.product_name;
                    document.getElementById('edit_price').value = product.price;
                    document.getElementById('edit_description').value = product.description;
                    document.getElementById('edit_category_id').value = product.category_id;
                    document.getElementById('edit_available_quantity').value = product.available_quantity;

                    // Open the modal
                    document.getElementById('editemployeeModal').style.display = 'block';
                })
                .catch(error => console.error('Error fetching product details:', error));
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function confirmDelete(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                window.location.href = `<?php echo URLROOT; ?>/HeadM/deleteProduct/${productId}`;
            }
        }

        let productIdToDelete = null;

        function openDeleteModal(productId) {
            productIdToDelete = productId; // Store the product ID to delete
            document.getElementById('deleteProductModal').style.display = 'block';
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            if (productIdToDelete) {
                // Redirect to the delete endpoint
                window.location.href = `<?php echo URLROOT; ?>/HeadM/deleteProduct/${productIdToDelete}`;
            }
        });
    </script>
</body>
</html>


