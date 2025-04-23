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
            --transition: all 0.3s ease;
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
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            color: var(--secondary-color);
            font-size: 1.8rem;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 2px;
        }

        .navbar ul {
            display: flex;
            list-style: none;
            gap: 2rem;
            margin: 0;
            padding: 0;
        }

        .navbar ul li {
            position: relative;
        }

        .navbar ul li a {
            color: var(--black);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: var(--transition);
            padding: 0.5rem 0;
        }

        .navbar ul li a:hover {
            color: var(--primary-color);
        }

        .navbar ul li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: var(--transition);
        }

        .navbar ul li a:hover::after {
            width: 100%;
        }

        @media (max-width: 992px) {
            .navbar {
                padding: 1rem 2%;
            }

            .navbar .logo {
                font-size: 1.5rem;
            }

            .navbar ul {
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
            }

            .navbar .logo {
                margin-bottom: 1rem;
            }

            .navbar ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }

            .navbar ul li a {
                font-size: 0.9rem;
            }
        }

        .cart-icon {
            position: relative;
            margin-left: 20px;
        }

        .cart-link {
            color: #333;
            font-size: 24px;
            text-decoration: none;
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background: var(--primary-color);
            color: var(--white);
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            min-width: 20px;
            text-align: center;
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
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: var(--white);
            border-radius: 8px;
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-width: 200px;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 180px;
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
            <li><a href="<?php echo URLROOT ?>/Customer/customerhomepage">Home</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerhomepage#about">About</a></li>
            <li><a href="<?php echo URLROOT ?>Customer/customerproducts" class="active">Products</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customercustomisation">Customization</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerprofile">Profile</a></li>

        </ul>
        <div class="icons">
            <div class="cart-icon">
                <a href="<?php echo URLROOT; ?>/Customer/customercart" class="cart-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">
                        <?php 
                        $cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
                        echo $cartCount;
                        ?>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <form method="GET" action="<?php echo URLROOT; ?>/Customer/customerproducts">
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php if (isset($data['categories']) && !empty($data['categories'])) : ?>
                    <?php foreach ($data['categories'] as $category) : ?>
                        <option value="<?php echo $category->category_id; ?>" 
                                <?php echo (isset($data['selectedCategory']) && $data['selectedCategory'] == $category->category_id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <input type="number" name="min_price" id="min-price" placeholder="Min Price" min="0"
                   value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
            <input type="number" name="max_price" id="max-price" placeholder="Max Price" min="0"
                   value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">

            <button type="submit">Filter</button>
        </form>
    </div>

    <!-- Products Section -->
    <div class="products-container">
        <?php if (isset($data['products']) && !empty($data['products'])) : ?>
            <?php foreach ($data['products'] as $product) : ?>
                <div class="product-card">
                    <!-- Product image -->
                    <?php if (!empty($product->image_path)) : ?>
                        <img src="<?php echo URLROOT; ?>/public/img/products/<?php echo htmlspecialchars($product->image_path); ?>" 
                             alt="<?php echo htmlspecialchars($product->product_name); ?>"
                             onerror="this.src='<?php echo URLROOT; ?>/public/img/default-product.jpg';">
                    <?php else : ?>
                        <img src="<?php echo URLROOT; ?>/public/img/default-product.jpg" 
                             alt="No image available">
                    <?php endif; ?>
                    
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product->product_name); ?></h3>
                        <p class="price">LKR <?php echo number_format($product->price, 2); ?></p>
                        
                        <form action="<?php echo URLROOT; ?>/Customer/addToCart" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($product->product_name); ?>">
                            <input type="hidden" name="price" value="<?php echo $product->price; ?>">
                            <input type="hidden" name="image" value="<?php echo $product->image_path ? $product->image_path : 'default-product.jpg'; ?>">
                            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="no-products">No products available</div>
        <?php endif; ?>
    </div>

    <script>
        // Function to update cart count
        function updateCartCount(count) {
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = count;
                // Show/hide the count based on value
                cartCountElement.style.display = count > 0 ? 'block' : 'none';
            }
        }

        // Add event listener to all add to cart forms
        document.querySelectorAll('form[action*="addToCart"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart count immediately
                        updateCartCount(data.cartCount);
                        // Show success message
                        const button = this.querySelector('.add-to-cart-btn');
                        const originalText = button.textContent;
                        button.textContent = 'Added!';
                        button.style.backgroundColor = 'var(--secondary-color)';
                        setTimeout(() => {
                            button.textContent = originalText;
                            button.style.backgroundColor = 'var(--primary-color)';
                        }, 1000);
                    } else {
                        alert('Failed to add product to cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding product to cart');
                });
            });
        });

        // Initialize cart count on page load
        document.addEventListener('DOMContentLoaded', () => {
            const initialCount = <?php echo $cartCount; ?>;
            updateCartCount(initialCount);
        });
    </script>
</body>
</html>
