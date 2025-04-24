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

        /* Keep only the product-specific styles here */
        
        .heading {
    text-align: center;
    color: var(--primary-color);
    text-transform: uppercase;
    margin-bottom: 3rem;
    padding: 1.2rem 0;
    font-size: 4rem;
}

.heading span {
    color: var(--secondary);
}
        /* Cart Icon Styles */
        .cart-icon {
            position: fixed;
            top: 20px;
            right: 30px;
            z-index: 1001;
        }

        /* Filter Bar Styles */
        .filter-bar {
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
            margin: 20px auto;
            max-width: 1200px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .filter-bar select, 
        .filter-bar input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            min-width: 150px;
        }

        .filter-bar button {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-bar button:hover {
            background: var(--secondary-color);
        }

        /* Products Container */
        .products-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        /* Product Card */
        .product-card {
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .product-info {
            padding: 20px;
            text-align: center;
        }

        .product-info h3 {
            color: var(--black);
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .price {
            color: var(--secondary-color);
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .add-to-cart-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            font-size: 1rem;
        }

        .add-to-cart-btn:hover {
            background: var(--secondary-color);
        }

        /* Cart Count Badge */
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-color);
            color: var(--white);
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
            min-width: 20px;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                margin: 20px;
            }

            .products-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <?php require_once APPROOT . '/views/Customer/RegisteredCustomerNav.php'; ?>

   

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
