<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FROSTINE Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #c98d83;
            --secondary-color: #783b31;
            --background-color: #f2f1ec;
            --white: #ffffff;
            --black: #000000;
            --box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        * {
            font-family: 'Vidaloka', serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--background-color);
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background-color: var(--background-color);
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a.logo {
            font-size: 2rem;
            font-weight: bold;
            color: var(--black);
            text-decoration: none;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }

        .navbar ul li a {
            text-decoration: none;
            color: var(--black);
            font-size: 1.5rem;
            transition: color 0.3s;
        }

        .navbar ul li a:hover {
            color: var(--primary-color);
        }

        .navbar .icons {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .navbar .icons .fas {
            font-size: 1.8rem;
            color: var(--black);
            cursor: pointer;
            transition: color 0.3s;
        }

        .navbar .icons .fas:hover {
            color: var(--primary-color);
        }

        /* Filter Bar */
        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px 20px;
            background: var(--white);
            box-shadow: var(--box-shadow);
            border-radius: 8px;
        }

        .filter-bar select, .filter-bar input {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-bar select:focus, .filter-bar input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .filter-bar button {
            padding: 10px 20px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .filter-bar button:hover {
            background: var(--secondary-color);
        }

        /* Products Section */
        .products-container {
            max-width: 1200px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Changed from auto-fit to 4 columns */
            gap: 20px;
            padding: 0 20px;
        }

        .product-card {
            min-width: 250px; /* Added minimum width */
            background: var(--white);
            border-radius: 8px;
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-card .product-info {
            padding: 15px;
            text-align: center;
        }

        .product-card .product-info h3 {
            font-size: 18px;
            color: var(--black);
            margin-bottom: 10px;
        }

        .product-card .product-info .price {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.2rem;
            margin: 10px 0;
        }

        .product-card .product-info .stars {
            margin-bottom: 15px;
        }

        .product-card .product-info .stars i {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .product-card .product-info .add-to-cart-btn {
            padding: 10px 20px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .product-card .product-info .add-to-cart-btn:hover {
            background: var(--secondary-color);
        }

        .no-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: 2rem;
            font-size: 1.2rem;
            color: #666;
        }

        .product-card .description {
            font-size: 0.9rem;
            color: #666;
            margin: 10px 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .out-of-stock-btn {
            padding: 10px 20px;
            background: #ccc;
            color: var(--white);
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: not-allowed;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: var(--white);
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            position: relative;
            text-align: center;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            cursor: pointer;
            color: #666;
        }

        .close-modal:hover {
            color: var(--primary-color);
        }

        .modal h2 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .modal p {
            margin-bottom: 20px;
            color: #666;
        }

        .modal .btn {
            display: inline-block;
            padding: 10px 30px;
        }

        .btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 8px 20px;  /* Reduced padding */
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 80%;        /* Reduced width from 100% */
            font-size: 0.9rem; /* Slightly smaller font */
            margin: 0 auto;    /* Center the button */
            display: block;    /* Ensure margin auto works */
            text-decoration: none; /* Remove underline from links */
        }

        .btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        /* Update modal button styles to override width for login/signup buttons */
        .modal-buttons .btn {
            width: auto;  /* Override width for modal buttons */
            display: inline-block;
            margin: 0 10px;
        }

        .product-info {
            padding: 15px;
            text-align: center;
        }

        .product-info h3 {
            font-size: 18px;
            color: var(--black);
            margin-bottom: 10px;
        }

        .product-info .price {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.2rem;
            margin: 10px 0;
        }

        /* Add media queries for responsiveness */
        @media (max-width: 1200px) {
            .products-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .products-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .products-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="#" class="logo">FROSTINE</a>
        <ul>
            <li><a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerhomepage">Home</a></li>
            <li><a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerhomepage#about">About</a></li>
            <li><a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerproducts" class="active">Products</a></li>
            <li><a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerhomepage#gallery">Gallery</a></li>
            <li><a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerhomepage#review">Reviews</a></li>
            <li><a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerhomepage#order">Enquiry</a></li>
        </ul>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <select name="category" id="category">
            <option value="">All Categories</option>
            <?php foreach ($data['categories'] as $category): ?>
                <option value="<?php echo htmlspecialchars($category->name); ?>"
                        <?php echo (isset($_GET['category']) && $_GET['category'] === $category->name) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category->name); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="min-price" id="min-price" 
               placeholder="Min Price" min="0" 
               value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
               
        <input type="number" name="max-price" id="max-price" 
               placeholder="Max Price" min="0"
               value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">

        <button onclick="filterProducts()">Filter</button>
    </div>

    <!-- Products Section -->
    <div class="products-container">
        <?php if (!empty($data['products'])): ?>
            <?php foreach ($data['products'] as $product): ?>
                <div class="product-card">
                    <div class="image">
                        <?php if (!empty($product->image_path)): ?>
                            <img src="<?php echo URLROOT; ?>/public/img/products/<?php echo htmlspecialchars($product->image_path); ?>" 
                                 alt="<?php echo htmlspecialchars($product->product_name); ?>"
                                 onerror="this.src='<?php echo URLROOT; ?>/public/img/default-product.jpg'">
                        <?php else: ?>
                            <img src="<?php echo URLROOT; ?>/public/img/default-product.jpg" 
                                 alt="Default product image">
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product->product_name); ?></h3>
                        <p class="price">LKR <?php echo number_format($product->price, 2); ?></p>
                        <button class="btn" onclick="showLoginPrompt()">Add to Cart</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-products">
                <p>No products available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Add this right after your notification div -->
    <div id="loginPromptModal" class="modal">
        <div class="modal-content">
            <h2>Register to Add Products</h2>
            <p>Please register or login to add products to your cart.</p>
            <div class="modal-buttons">
                <a href="<?php echo URLROOT ?>/Register/signup" class="btn">Sign Up</a>
                <a href="<?php echo URLROOT ?>/Login/indexx" class="btn">Login</a>
            </div>
            <span class="close-modal">&times;</span>
        </div>
    </div>

    <!-- Add this before </body> tag -->
    <div id="loginPromptModal" class="modal">
        <div class="modal-content">
            <h2>Register to Add Products</h2>
            <p>Please register or login to add products to your cart.</p>
            <div class="modal-buttons">
                <a href="<?php echo URLROOT ?>/Register/signup" class="btn">Sign Up</a>
                <a href="<?php echo URLROOT ?>/Login/indexx" class="btn">Login</a>
            </div>
            <span class="close-modal" onclick="closeModal()">&times;</span>
        </div>
    </div>

    <script>
        function filterProducts() {
            const categorySelect = document.getElementById('category');
            const category = categorySelect.value;
            const minPrice = document.getElementById('min-price').value;
            const maxPrice = document.getElementById('max-price').value;
            
            let url = new URL(window.location.href);
            
            // Clear existing parameters
            url.searchParams.delete('category');
            url.searchParams.delete('min_price');
            url.searchParams.delete('max_price');
            
            // Add new parameters only if they have values
            if (category) {
                url.searchParams.append('category', category);
            }
            if (minPrice) {
                url.searchParams.append('min_price', minPrice);
            }
            if (maxPrice) {
                url.searchParams.append('max_price', maxPrice);
            }
            
            window.location.href = url.toString();
        }

        // Add event listeners for enter key on price inputs
        document.getElementById('min-price').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') filterProducts();
        });

        document.getElementById('max-price').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') filterProducts();
        });

        function addToCart(productId) {
            // Implement cart functionality here
            alert('Product will be added to cart. Product ID: ' + productId);
        }

        function navigateTo(url) {
            window.location.href = url;
        }

        function showLoginPrompt() {
            const modal = document.getElementById('loginPromptModal');
            modal.style.display = "block";

            // Close modal when clicking the X
            document.querySelector('.close-modal').onclick = function() {
                modal.style.display = "none";
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }

        // Add this to your existing script section
        function closeModal() {
            document.getElementById('loginPromptModal').style.display = "none";
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('loginPromptModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <!-- Chat Widget -->
    <?php require_once APPROOT . '/views/chat/index.php'; ?>
</body>
</html>
