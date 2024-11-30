<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SystemAdmin/main.css">
    <title>Product Management</title>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="<?php echo URLROOT; ?>/Dashboard"><i class="fas fa-th"></i>Dashboard</a></li>
                <li><a href="<?php echo URLROOT; ?>/UserManagement"><i class="fas fa-user"></i>User Management</a></li>
                <li><a href="#"><i class="fas fa-truck"></i>Product Management</a></li>
                <li><a href="<?php echo URLROOT; ?>/CustomerManagement"><i class="fas fa-users"></i>Customer Management</a></li>
                <li><a href="<?php echo URLROOT; ?>/ViewOrders"><i class="fas fa-eye"></i>View Orders</a></li>
            </ul>
            <div class="logo">
            <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/logo.jpg" alt="Logo">
            </div>
            <div class="logout">
                <button onclick="window.location.href='<?php echo URLROOT; ?>/logout'">Logout</button>
            </div>
        </div>
        <div class="sub-container-2">
            <div class="header">
                <div class="user-info">
                    <div>
                        <span>Danuka Kalhara</span>
                        <span>System Administrator</span>
                    </div>
                    <div>
                        <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/admin-profile.png" alt="User Avatar">
                    </div>
                </div>
            </div>
            <div class="dashboard">
                <p><i class="fas fa-truck"></i>&nbsp; Product Management</p>
            </div>
            <div class="table-elements">
                <div class="role-details">
                    <button class="btn add-new">+ Add New Product</button>

                    <!-- Add Product Modal -->
                    <div id="customerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">×</span>
                            <h2>Add New Product</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <label for="product_name">Product Name:</label>
                                <input type="text" id="product_name" name="product_name" required>

                                <label for="category">Category:</label>
                                <input type="text" id="category" name="category" required>

                                <label for="quantity">Quantity:</label>
                                <input type="number" id="quantity" name="quantity" required>

                                <label for="price">Price:</label>
                                <input type="number" id="price" name="price" required>

                                <div class="buttons">
                                    <button type="reset" class="btn reset">Reset</button>
                                    <button type="submit" name="add_product" class="btn submit">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Edit Product Modal -->
                    <div id="editCustomerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">×</span>
                            <h2>Edit Product</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" id="edit_product_id" name="product_id">
                                
                                <label for="edit_product_name">Product Name:</label>
                                <input type="text" id="edit_product_name" name="product_name" required>

                                <label for="edit_category">Category:</label>
                                <input type="text" id="edit_category" name="category" required>

                                <label for="edit_quantity">Quantity:</label>
                                <input type="number" id="edit_quantity" name="quantity" required>

                                <label for="edit_price">Price:</label>
                                <input type="number" id="edit_price" name="price" required>

                                <div class="buttons">
                                    <button type="submit" name="edit_product" class="btn submit">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div id="deleteCustomerModal" class="modal">
                        <div class="modal-content">
                            <span class="close">×</span>
                            <h2>Delete Product</h2>
                            <p>Are you sure you want to delete this product?</p>
                            <div class="buttons">
                                <button type="submit" id="confirmDelete" class="btn reset">Yes</button>
                                <button type="reset" class="btn submit">No</button>
                            </div>
                        </div>
                    </div>

                    <div class="view-new-list">
                        <div class="search-bar">
                            <form method="GET" action="">
                                <input type="text" placeholder="Search by Name">
                                <button class="search-btn">🔍</button>
                            </form>
                        </div>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product Id</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Price (Rs.)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['product_id']) ?></td>
                                                <td><?= htmlspecialchars($row['product_name']) ?></td>
                                                <td><?= htmlspecialchars($row['category']) ?></td>
                                                <td><?= htmlspecialchars($row['quantity']) ?></td>
                                                <td><?= htmlspecialchars($row['price']) ?></td>
                                                <td class="action-icons">
                                                    <a href="<?php echo URLROOT; ?>/editProduct/<?= $row['product_id'] ?>" class="edit" title="Edit">&#9998;</a>
                                                    <a href="<?php echo URLROOT; ?>/deleteProduct/<?= $row['product_id'] ?>" class="delete" title="Delete" onclick="return confirm('Are you sure you want to delete this product?');">&#128465;</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">No products available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/SystemAdmin/ProductManagement.js"></script>
</body>
</html>
