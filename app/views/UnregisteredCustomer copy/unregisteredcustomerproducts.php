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
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .product-card {
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
            font-size: 16px;
            color: var(--secondary-color);
            font-weight: bold;
            margin-bottom: 10px;
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
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="#" class="logo">FROSTINE</a>
        <ul>
            <li><a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerhomepage">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerproducts" class="active">Products</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#reviews">Reviews</a></li>
            <li><a href="#order">Pre Order</a></li>
        </ul>
        <div class="icons">
            <i class="fas fa-shopping-cart" onclick="navigateTo('<?php echo URLROOT; ?>/UnregisteredCustomer/unregisteredcustomercart')"></i>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <select name="category" id="category">
            <option value="">All Categories</option>
            <option value="cakes">Cakes</option>
            <option value="breads">Breads</option>
            <option value="pancakes">Pancakes</option>
            <option value="waffles">Waffles</option>
        </select>

        <input type="number" name="min-price" id="min-price" placeholder="Min Price" min="0">
        <input type="number" name="max-price" id="max-price" placeholder="Max Price" min="0">

        <button onclick="filterProducts()">Filter</button>
    </div>

    <!-- Products Section -->
    <div class="products-container">
        <!-- Example Product -->
        <div class="product-card">
            <img src="../public/img/Customer/product-1.jpg" alt="Product 1">
            <div class="product-info">
                <h3>Strawberry Pancake</h3>
                <p class="price">LKR 1,250.00</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>
        <!-- Product 2 -->
        <div class="product-card">
            <img src="../public/img/Customer/product-2.jpg" alt="Product 2">
            <div class="product-info">
                <h3>Blueberry Pancake</h3>
                <p class="price">LKR 1,450.00</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="product-card">
            <img src="../public/img/Customer/product-3.jpg" alt="Product 3">
            <div class="product-info">
                <h3>Butter & Honey Bread</h3>
                <p class="price">LKR 1,950.00</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <i class="far fa-star"></i>
                </div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>
    </div>

    
    
    <div class="products-container">
        <!-- Product 4 -->
        <div class="product-card">
            <img src="../public/img/Customer/product-4.jpg" alt="Rose Pink Cake">
            <div class="product-info">
                <h3>Rose Pink Cake</h3>
                <p class="price">LKR 9,550.00</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>

        <!-- Product 5-->
        <div class="product-card">
            <img src="../public/img/Customer/product-5.jpg" alt="Honey Waffles">
            <div class="product-info">
                <h3>Honey Waffles</h3>
                <p class="price">LKR 1,200.00</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>

        <!-- Product 6 -->
        <div class="product-card">
            <img src="../public/img/Customer/product-6.jpg" alt="Honey Pancake">
            <div class="product-info">
                <h3>Honey Pancake</h3>
                <p class="price">LKR 1,050.00</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <button class="add-to-cart-btn">Add to Cart</button>
            </div>
        </div>
    </div>
    

    <script>
        function filterProducts() {
            alert('Filter functionality will be implemented here.');
        }
        function navigateTo(url) {
            window.location.href = url;
        }
    </script>
</body>
</html>
