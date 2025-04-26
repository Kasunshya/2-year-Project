<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    
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
        table {
            min-width: 1200px;
        }
        
        /* Adjust specific column widths */
        table th:nth-child(1),
        table td:nth-child(1) {
            width: 120px;
        }

        table th:nth-child(2),
        table td:nth-child(2) {
            width: 20%;
        }

        table th:nth-child(3),
        table td:nth-child(3) {
            width: 12%;
        }

        table th:nth-child(4),
        table td:nth-child(4) {
            width: 10%;
        }

        table th:nth-child(5),
        table td:nth-child(5) {
            width: 12%;
        }

        table th:nth-child(6),
        table td:nth-child(6) {
            width: 15%;
        }

        table th:nth-child(7),
        table td:nth-child(7) {
            width: 15%;
        }

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
        }

        .product-image-preview {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: var(--radius-md);
            margin: 10px 0;
            border: 1px solid var(--neutral-gray);
            box-shadow: var(--shadow-md);
            transition: transform var(--transition-fast);
        }
        
        .product-image-preview:hover {
            transform: scale(1.02);
        }

        .file-input-container {
            background-color: var(--neutral-light);
            padding: var(--space-lg);
            border-radius: var(--radius-md);
            margin-bottom: var(--space-md);
            border: 1px solid var(--neutral-gray);
        }

        #currentImageText {
            font-size: var(--font-size-sm);
            color: var(--neutral-dark);
            margin-top: var(--space-xs);
        }
        
        /* Enhanced modal - adds to base design system */
        .modal-content {
            max-height: 85vh;
            overflow-y: auto;
        }
        
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: var(--neutral-light);
            border-radius: var(--radius-md);
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: var(--primary-main);
            border-radius: var(--radius-md);
            border: 2px solid var(--neutral-light);
        }

        .modal-content::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>
<div class="sysadmin-page-container">
    <div class="container">
        <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

        <header class="header">
            <div class="header-left">
                <i class="fas fa-box"></i>
                <span>Product Management</span>
            </div>
            
        </header>

        <div class="content">
            <?php if(isset($_SESSION['flash_messages'])) : ?>
                <?php foreach($_SESSION['flash_messages'] as $type => $message) : ?>
                    <div class="alert alert-<?php echo $type; ?>" id="alert-message">
                        <?php if($type === 'success') : ?>
                            <i class="fas fa-check-circle"></i>
                        <?php elseif($type === 'error') : ?>
                            <i class="fas fa-exclamation-circle"></i>
                        <?php else : ?>
                            <i class="fas fa-info-circle"></i>
                        <?php endif; ?>
                        <span><?php echo $message; ?></span>
                        <button class="close-btn" onclick="closeAlert(this.parentElement)">&times;</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <div class="search-bar">
                <form action="<?php echo URLROOT; ?>/SysAdminP/searchProduct" method="GET">
                    <input type="text" 
                        class="form-control"
                        name="search" 
                        placeholder="Search by product name..." 
                        value="<?php echo isset($data['search']) ? htmlspecialchars($data['search']) : ''; ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>
            
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add Product
            </button>
            
            <div class="table-container">
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
                                        <button class="btn edit-btn" onclick="openEditModal(<?php echo $product->product_id; ?>, 
                                            '<?php echo htmlspecialchars(addslashes($product->product_name)); ?>', 
                                            '<?php echo htmlspecialchars(addslashes($product->description)); ?>', 
                                            <?php echo $product->price; ?>, 
                                            <?php echo $product->available_quantity; ?>, 
                                            <?php echo $product->category_id; ?>,
                                            '<?php echo $product->image_path; ?>',
                                            '<?php echo $product->expiry_date; ?>')">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                        <button class="btn delete-btn" onclick="confirmDelete(<?php echo $product->product_id; ?>)">
                                            <i class="fas fa-trash"></i> 
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
        </div>

        <!-- Add Product Modal -->
        <div class="modal" id="addProductModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Product</h3>
                    <button type="button" class="close" onclick="closeModal('addProductModal')">&times;</button>
                </div>
                
                <form id="addProductForm" action="<?php echo URLROOT; ?>/SysAdminP/addProduct" method="POST" enctype="multipart/form-data" onsubmit="return validateAddProductForm()">
                    <div class="file-input-container">
                        <label class="form-label" for="product_image">Product Image:</label>
                        <input type="file" class="form-control" id="add_product_image" name="product_image" accept="image/*" onchange="previewImage(this, 'addImagePreview')">
                        <img id="addImagePreview" class="product-image-preview" src="" alt="Preview">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="product_name">Product Name:</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="price">Price (LKR):</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="available_quantity">Available Quantity:</label>
                        <input type="number" class="form-control" id="available_quantity" name="available_quantity" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="category_id">Category:</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php if(isset($data['categories']) && is_array($data['categories'])) : ?>
                                <?php foreach($data['categories'] as $category) : ?>
                                    <option value="<?php echo $category->category_id; ?>"><?php echo htmlspecialchars($category->name); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="expiry_date">Expiry Date:</label>
                        <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('addProductModal')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div class="modal" id="editProductModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit Product</h3>
                    <button type="button" class="close" onclick="closeModal('editProductModal')">&times;</button>
                </div>
                
                <form id="editProductForm" action="<?php echo URLROOT; ?>/SysAdminP/updateProduct" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit_product_id" name="product_id">
                    
                    <div class="file-input-container">
                        <label class="form-label" for="edit_product_image">Product Image:</label>
                        <input type="file" class="form-control" id="edit_product_image" name="product_image" accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                        <img id="editImagePreview" class="product-image-preview" src="" alt="Preview">
                        <p id="currentImageText">Current image: <span id="currentImageName"></span></p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_product_name">Product Name:</label>
                        <input type="text" class="form-control" id="edit_product_name" name="product_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_description">Description:</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_price">Price (LKR):</label>
                        <input type="number" class="form-control" id="edit_price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_available_quantity">Available Quantity:</label>
                        <input type="number" class="form-control" id="edit_available_quantity" name="available_quantity" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_category_id">Category:</label>
                        <select class="form-select" id="edit_category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php if(isset($data['categories']) && is_array($data['categories'])) : ?>
                                <?php foreach($data['categories'] as $category) : ?>
                                    <option value="<?php echo $category->category_id; ?>"><?php echo htmlspecialchars($category->name); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="edit_expiry_date">Expiry Date:</label>
                        <input type="date" class="form-control" id="edit_expiry_date" name="expiry_date">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal('editProductModal')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>
            </div>
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

    function closeAlert(alertElement) {
        alertElement.classList.add('fade-out');
        setTimeout(() => alertElement.remove(), 500);
    }

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if(alert) {
                    closeAlert(alert);
                }
            }, 5000);
        });
    });
</script>
</body>
</html>