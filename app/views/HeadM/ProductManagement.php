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
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">
                <div class="employee-list">
                    <div class="search-bar">
                        <form method="GET" action="<?php echo URLROOT; ?>/HeadM/productManagement" class="search-form">
                            <div class="search-field">
                                <input type="text" name="product_name" placeholder="Search by Product Name" value="<?php echo isset($_GET['product_name']) ? htmlspecialchars($_GET['product_name']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <select name="category_id">
                                    <option value="">All Categories</option>
                                    <?php foreach ($data['categories'] as $category): ?>
                                        <option value="<?php echo $category->category_id; ?>" <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $category->category_id) ? 'selected' : ''; ?>>
                                            <?php echo $category->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="search-field">
                                <input type="number" name="min_price" placeholder="Min Price (Rs.)" min="0" step="0.01" value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <input type="number" name="max_price" placeholder="Max Price (Rs.)" min="0" step="0.01" value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <button class="btn search-btn" type="submit"><i class="fas fa-search"></i> Search</button>
                            </div>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['products'] as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product->product_name); ?></td>
                                        <td><?php echo htmlspecialchars($product->description); ?></td>
                                        <td>Rs. <?php echo number_format($product->price, 2); ?></td>
                                        <td><?php echo htmlspecialchars($product->available_quantity); ?></td>
                                        <td>
                                            <span class="stars">
                                                <?php
                                                $filledStars = intval($product->star_rating); // Number of filled stars
                                                $emptyStars = 5 - $filledStars; // Number of empty stars
                                                echo str_repeat('★', $filledStars); // Display filled stars
                                                echo str_repeat('☆', $emptyStars); // Display empty stars
                                                ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($product->category_name); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>