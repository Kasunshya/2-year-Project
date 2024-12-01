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
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <label for="product_name">Product Name:</label>
                            <input type="text" id="product_name" name="product_name" required>

                            <label for="price">Price (Rs.):</label>
                            <input type="number" id="price" name="price" required min="0" step="0.01">

                            <label for="product_image">Product Image:</label>
                            <input type="file" id="product_image" name="product_image" accept="image/*" required>

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
                        <span class="close">×</span>
                        <h2>Update Product</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="edit_product_id" name="product_id">
            
                            <label for="edit_product_name">Product Name:</label>
                            <input type="text" id="edit_product_name" name="product_name" required>

                            <label for="edit_price">Price (Rs.):</label>
                            <input type="number" id="edit_price" name="price" required min="0" step="0.01">

                            <label for="edit_product_image">Product Image:</label>
                            <input type="file" id="edit_product_image" name="product_image" accept="image/*">

                            <div class="buttons">
                                <button type="submit" name="edit_product" class="btn submit">Save Changes</button>
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
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Update/Delete</th>
                                </tr>
                            </thead>
                            <tbody>  
                                <tr>
                                    <td>P001</td>
                                    <td>Chocolate Cake</td>
                                    <td>Rs. 1500.00</td>
                                    <td><img src="<?php echo URLROOT; ?>/public/img/HeadM/chocolatecake.png" alt="Chocolate Cake"></td>
                                    <td>
                                        <button class="btn edit"onclick="editEmployee()">Update</button>
                                        <button class="btn delete"onclick="deleteEmployee()">Delete</button>
                                    
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>P002</td>
                                    <td>Strawberry Cake</td>
                                    <td>Rs. 1800.00</td>
                                    <td><img src="<?php echo URLROOT; ?>/public/img/HeadM/strawberrycake.png" alt="Strawberry Cake"></td>
                                    <td>
                                    <button class="btn edit"onclick="editEmployee()">Update</button>
                                    <button class="btn delete"onclick="deleteEmployee()">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>P003</td>
                                    <td>Vanilla Cake</td>
                                    <td>Rs. 1200.00</td>
                                    <td><img src="<?php echo URLROOT; ?>/public/img/HeadM/vanillacake.png" alt="Vanilla Cake"></td>
                                    <td>
                                    <button class="btn edit"onclick="editEmployee()">Update</button>
                                    <button class="btn delete"onclick="deleteEmployee()">Delete</button>
                                    </td>   
                                </tr>
                                <tr>
                                    <td>P004</td>
                                    <td>Red Velvet Cake</td>
                                    <td>Rs. 1600.00</td>
                                    <td><img src="<?php echo URLROOT; ?>/public/img/HeadM/redvelvetcake.png" alt="Red Velvet Cake"></td>
                                    <td>
                                    <button class="btn edit"onclick="editEmployee()">Update</button>
                                    <button class="btn delete"onclick="deleteEmployee()">Delete</button>
                                    </td>  
                                </tr>
                                <tr>
                                    <td>P005</td>
                                    <td>Chicken Submarine</td>
                                    <td>Rs. 1400.00</td>
                                    <td><img src="<?php echo URLROOT; ?>/public/img/HeadM/pchickensubmarine.png" alt="Lemon Cake"></td>
                                    <td>
                                    <button class="btn edit"onclick="editEmployee()">Update</button>
                                    <button class="btn delete"onclick="deleteEmployee()">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/BranchManagers.js"></script>

</body>
</html>


