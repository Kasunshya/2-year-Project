<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <?php require APPROOT.'/views/SysAdmin/SideNavBar.php'?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Typography */
        :root {
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .product-container {
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
            font-family: var(--font-family);
        }

        header i {
            margin-right: 10px;
            text-align: left;
            display: inline-block;
            vertical-align: middle;
        }

        body {
            background-color: #e8d7e5;
            font-family: var(--font-family);
        }

        .product-table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            border-radius: 4px;
            overflow: hidden;
            font-family: var(--font-family);
        }

        .product-table th {
            background-color: #a26b98;
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            font-family: var(--font-family);
        }

        .product-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e0e0e0;
            font-family: var(--font-family);
        }

        .product-table tbody tr:hover {
            background-color: #f9f5f0;
        }

        .add-product-btn {
            background-color: #a26b98;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin: 20px 0;
            font-size: 14px;
        }

        .add-product-btn:hover {
            background-color: #5d2e46;
        }

        .search-container {
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 10px; /* Adds space between search bar and button */
        }

        .search-input {
            padding: 8px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            width: 300px;
            margin-right: 0; /* Remove right margin if any */
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
            max-height: 80vh;
            overflow-y: auto;
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
            font-family: var(--font-family);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #5d2e46;
            font-family: var(--font-family);
        }

        .form-group input, 
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-family: var(--font-family);
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
            font-family: var(--font-family);
        }

        .save-btn {
            background-color: #a26b98;
            color: white;
        }

        .cancel-btn {
            background-color: #6c757d;
            color: white;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }

        #imagePreview,
        #editImagePreview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h7><i class="fas fa-box"></i>Product Management</h7>
    </header>

    <div class="product-container">
        <div class="search-container">
            <input type="text" class="search-input" id="searchProduct" placeholder="Search products...">
            <button class="add-product-btn" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Product
            </button>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Expiry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['products'] as $product) : ?>
                    <tr>
                        <td>
                            <?php if($product->image_path): ?>
                                <img src="<?php echo URLROOT; ?>/public/img/products/<?php echo $product->image_path; ?>" 
                                     alt="<?php echo $product->product_name; ?>" class="product-image">
                            <?php endif; ?>
                        </td>
                        <td><?php echo $product->product_name; ?></td>
                        <td>LKR <?php echo number_format($product->price, 2); ?></td>
                        <td><?php echo $product->available_quantity; ?></td>
                        <td><?php echo $product->category_name; ?></td>
                        <td><?php echo $product->expiry_date; ?></td>
                        <td>
                            <button class="action-btn" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($product)); ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" onclick="confirmDelete(<?php echo $product->product_id; ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('addProductModal')">&times;</span>
            <div class="modal-header">
                <h2>Add New Product</h2>
            </div>
            <form id="addProductForm" method="POST" action="<?php echo URLROOT; ?>/SysAdminP/addProduct" enctype="multipart/form-data">
               
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" 
                           id="product_name" 
                           name="product_name" 
                           required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price (LKR)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="available_quantity">Available Quantity</label>
                    <input type="number" id="available_quantity" name="available_quantity" min="0" required>
                </div>
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php if(isset($data['categories'])): ?>
                            <?php foreach($data['categories'] as $category): ?>
                                <option value="<?php echo $category->category_id; ?>"><?php echo $category->name; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="date" id="expiry_date" name="expiry_date" required>
                </div>
                <div class="form-group">
                    <label for="product_image">Image</label>
                    <input type="file" id="product_image" name="product_image" accept="image/*" onchange="previewImage(this)">
                    <img id="imagePreview" style="max-width: 200px; display: none;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel-btn" onclick="closeModal('addProductModal')">Cancel</button>
                    <button type="submit" class="modal-btn save-btn">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('editProductModal')">&times;</span>
            <div class="modal-header">
                <h2>Edit Product</h2>
            </div>
            <form id="editProductForm" method="POST" action="<?php echo URLROOT; ?>/SysAdminP/updateProduct" enctype="multipart/form-data">
                <input type="hidden" id="edit_product_id" name="product_id">

                <div class="form-group">
                    <label for="edit_product_name">Product Name</label>
                    <input type="text" id="edit_product_name" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_price">Price (LKR)</label>
                    <input type="number" id="edit_price" name="price" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit_available_quantity">Available Quantity</label>
                    <input type="number" id="edit_available_quantity" name="available_quantity" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit_category_id">Category</label>
                    <select id="edit_category_id" name="category_id" required>
                        <?php if(isset($data['categories'])): ?>
                            <?php foreach($data['categories'] as $category): ?>
                                <option value="<?php echo $category->category_id; ?>"><?php echo $category->name; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_expiry_date">Expiry Date</label>
                    <input type="date" id="edit_expiry_date" name="expiry_date" required>
                </div>
                <div class="form-group">
                    <label for="edit_product_image">Image</label>
                    <input type="file" id="edit_product_image" name="product_image" accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                    <img id="editImagePreview" style="max-width: 200px; display: none;">
                    <div id="current_image"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel-btn" onclick="closeModal('editProductModal')">Cancel</button>
                    <button type="submit" class="modal-btn save-btn">Update Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const URLROOT = '<?php echo URLROOT; ?>';

        // Update the openAddModal function
        function openAddModal() {
            try {
                const modal = document.getElementById('addProductModal');
                if (!modal) throw new Error('Add modal not found');
                
                modal.style.display = 'block';
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('addProductForm').reset();
            } catch (error) {
                console.error('Error opening add modal:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to open add modal: ' + error.message,
                    icon: 'error',
                    confirmButtonColor: '#a26b98'
                });
            }
        }

        // Update the openEditModal function
        function openEditModal(product) {
            try {
                console.log('Product data:', product);
                
                const modal = document.getElementById('editProductModal');
                if (!modal) throw new Error('Edit modal not found');

                // Populate form fields
                document.getElementById('edit_product_id').value = product.product_id;
                document.getElementById('edit_product_name').value = product.product_name;
                document.getElementById('edit_description').value = product.description;
                document.getElementById('edit_price').value = product.price;
                document.getElementById('edit_available_quantity').value = product.available_quantity;
                document.getElementById('edit_category_id').value = product.category_id;
                document.getElementById('edit_expiry_date').value = product.expiry_date.split(' ')[0];
                
                // Handle image preview
                const imagePreview = document.getElementById('editImagePreview');
                const currentImageDiv = document.getElementById('current_image');
                
                if (product.image_path) {
                    currentImageDiv.innerHTML = `
                        <img src="${URLROOT}/public/img/products/${product.image_path}" 
                             style="max-width: 100px; margin: 10px 0;" />
                        <p>Current image</p>`;
                } else {
                    currentImageDiv.innerHTML = '<p>No current image</p>';
                }
                
                // Show the modal
                modal.style.display = 'block';
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

        // Add form submission with SweetAlert
        document.getElementById('addProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nameInput = document.getElementById('product_name');
            const productName = nameInput.value.trim();
            
            if (!productName) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Product name is required',
                    icon: 'error',
                    confirmButtonColor: '#a26b98'
                });
                nameInput.focus();
                return;
            }
            
            Swal.fire({
                title: 'Add Product',
                text: 'Are you sure you want to add this product?',
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

        // Edit form submission with SweetAlert
        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Update Product',
                text: 'Are you sure you want to update this product?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#a26b98',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Add search functionality
        document.getElementById('searchProduct').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('.product-table tbody tr');
            
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const category = row.cells[4].textContent.toLowerCase();
                
                if (name.includes(searchText) || category.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

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

        function confirmDelete(productId) {
            Swal.fire({
                title: 'Delete Product',
                text: 'Are you sure you want to delete this product?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `${URLROOT}/SysAdminP/deleteProduct/${productId}`;
                }
            });
        }
    </script>
</body>
</html>