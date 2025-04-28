<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #c98d83;
            --secondary: #783b31;
            --bg: #f2f1ec;
            --white: #ffffff;
            --black: #000000;
            --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1);
        }

        /* Global Styles */
        * {
            font-family: 'Vidaloka', serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
        }

        body {
            background: var(--bg);
            color: var(--black);
            min-height: 100vh;
        }

        /* Header Styles */
        .profile-title {
            background-color: #c98d83;
            padding: 1.5rem;
            text-align: center;
            color: #ffffff;
            font-size: 2rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Poppins', sans-serif;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            header {
                font-size: 1.5rem;
                padding: 1.2rem;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
        }
        /* Navigation Bar */
        /* Add these styles in the <style> tag after the existing navbar styles */
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
    color: var(--secondary);
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

/* Add responsive navbar styles */
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

        /* Container Styles */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            background: var(--white);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
        }

        /* Cart Table Styles */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .cart-table th {
            background: var(--primary-color);
            color: var(--white);
            padding: 1rem;
            text-align: left;
        }

        .cart-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        /* Product Image and Details */
        .product-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .cart-product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
        }

        .product-name {
            font-weight: 500;
            color: var(--secondary);
        }

        /* Quantity Controls */
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
            justify-content: center;
        }

        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--primary-color);
            transition: color 0.3s ease;
        }

        .btn-icon:hover {
            color: var(--secondary);
        }

        /* Cart Summary and Buttons */
        .cart-summary {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            font-size: 1.2rem;
            margin: 2rem 0;
            padding: 1rem 0;
            border-top: 2px solid var(--bg);
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .summary-item.total {
            font-size: 1.2em;
            font-weight: bold;
            border-bottom: none;
            color: var(--secondary-color);
        }

        .promotion-applied {
            background: #e8f5e9;
            padding: 10px;
            border-radius: 4px;
            color: #2e7d32;
        }

        .promotion-applied i {
            margin-right: 5px;
        }

        .available-promotions {
            margin-top: 15px;
            padding: 15px;
            background: #fff3e0;
            border-radius: 4px;
        }

        .available-promotions h3 {
            color: var(--secondary-color);
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .available-promotions ul {
            list-style: none;
            padding: 0;
        }

        .available-promotions li {
            color: #f57c00;
            margin: 5px 0;
        }

        .cart-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .continue-btn, .clear-btn, .proceed-btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .continue-btn {
            background: var(--bg);
            color: var(--secondary);
        }

        .clear-btn {
            background: var(--bg);
            color: var(--secondary);
        }

        .proceed-btn {
            background: var(--primary-color);
            color: var(--white);
        }

        .continue-btn:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        .clear-btn:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        .proceed-btn:hover {
            background: var(--secondary);
        }
    </style>
</head>
<body>
    <?php require_once APPROOT . '/views/customer/RegisteredCustomerNav.php'; ?>
    <!-- Cart Page -->
    <div class="profile-title">Shopping Cart</div>
    
    <div id="cart-top"></div>
    <div class="container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grandTotal = 0;
                if (!empty($data['cartItems'])) : 
                    foreach ($data['cartItems'] as $productId => $item) :
                        $total = $item['price'] * $item['quantity'];
                        $grandTotal += $total;
                ?>
                    <tr id="cart-item-<?php echo $productId; ?>">
                        <td>
                            <div class="product-cell">
                                <?php if (isset($item['image'])): ?>
                                    <img src="<?php echo URLROOT; ?>/public/img/products/<?php echo htmlspecialchars($item['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['name']); ?>"
                                         class="cart-product-image">
                                <?php endif; ?>
                                <span class="product-name"><?php echo htmlspecialchars($item['name']); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="quantity-controls">
                                <form action="<?php echo URLROOT; ?>/customer/updateCartQuantity#cart-item-<?php echo $productId; ?>" 
                                      method="POST" 
                                      class="quantity-form">
                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                    <button type="submit" name="action" value="decrease" class="btn-icon">-</button>
                                    <span class="quantity"><?php echo $item['quantity']; ?></span>
                                    <button type="submit" name="action" value="increase" class="btn-icon">+</button>
                                </form>
                            </div>
                        </td>
                        <td>LKR <?php echo number_format($item['price'], 2); ?></td>
                        <td>LKR <?php echo number_format($total, 2); ?></td>
                        <td>
                            <form action="<?php echo URLROOT; ?>/customer/updateCartQuantity#cart-<?php echo $productId; ?>" 
                                  method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                <button type="submit" name="action" value="remove" class="btn-icon remove-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php 
                    endforeach;
                else : 
                ?>
                    <tr>
                        <td colspan="5" class="text-center">Your cart is empty</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="cart-summary">
            <div class="summary-item">
                <span>Subtotal:</span>
                <span>LKR <?php echo number_format($data['subtotal'], 2); ?></span>
            </div>

            <?php if (isset($data['appliedPromotion'])): ?>
                <div class="summary-item promotion-applied">
                    <span>
                        <i class="fas fa-tag"></i>
                        Promotion Applied: <?php echo htmlspecialchars($data['appliedPromotion']->title); ?>
                        (<?php echo $data['appliedPromotion']->discount_percentage; ?>% OFF)
                    </span>
                    <span>-LKR <?php echo number_format($data['discount'], 2); ?></span>
                </div>
            <?php endif; ?>

            <div class="summary-item total">
                <span>Grand Total:</span>
                <span>LKR <?php echo number_format($data['total'], 2); ?></span>
            </div>

            <?php if (!isset($data['appliedPromotion']) && $data['subtotal'] > 0): ?>
                <div class="available-promotions">
                    <h3>Available Promotions:</h3>
                    <ul>
                        <?php if ($data['subtotal'] >= 5000): ?>
                            <li>Spend LKR 5,000 or more to get 20% off!</li>
                        <?php elseif ($data['subtotal'] >= 2500): ?>
                            <li>Spend LKR 2,500 or more to get 5% off!</li>
                        <?php else: ?>
                            <li>Spend LKR <?php echo number_format(2500 - $data['subtotal'], 2); ?> more to get 5% off!</li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="cart-buttons">
            <a href="<?php echo URLROOT ?>/customer/customerproducts" class="continue-btn">
                Continue Shopping
            </a>
            <?php if (!empty($data['cartItems'])) : ?>
                <form action="<?php echo URLROOT; ?>/customer/clearCart" method="POST" style="display: inline;">
                    <button type="submit" class="clear-btn">
                        Clear Cart
                    </button>
                </form>
                <form action="<?php echo URLROOT ?>/customer/customercheckout" method="POST" style="display: inline;">
                    <input type="hidden" name="subtotal" value="<?php echo $data['subtotal']; ?>">
                    <input type="hidden" name="discount" value="<?php echo $data['discount']; ?>">
                    <input type="hidden" name="total" value="<?php echo $data['total']; ?>">
                    <input type="hidden" name="cart_items" value="<?php echo htmlspecialchars(json_encode($data['cartItems'])); ?>">
                    <?php if (isset($data['appliedPromotion'])): ?>
                        <input type="hidden" name="promotion_title" value="<?php echo htmlspecialchars($data['appliedPromotion']->title); ?>">
                        <input type="hidden" name="promotion_discount" value="<?php echo $data['appliedPromotion']->discount_percentage; ?>">
                    <?php endif; ?>
                    <button type="submit" class="proceed-btn">Proceed to Payment</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <script>
        // Store scroll position before form submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                sessionStorage.setItem('scrollPosition', window.scrollY);
            });
        });

        // Restore scroll position after page load
        window.onload = function() {
            let scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, scrollPosition);
                sessionStorage.removeItem('scrollPosition');
            }
        };
    </script>
    <!-- Chat Widget -->
    <?php require_once APPROOT . '/views/chat/index.php'; ?>
</body>
</html>
