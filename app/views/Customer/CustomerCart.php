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
            --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1);
        }

        * {
            font-family: 'Vidaloka', serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
        }
        header {
            background-color: var(--primary-color);
            padding: 2rem;
            text-align: center;
            color: var(--white);
            font-size: 2.5rem;
            text-transform: uppercase;
        }
        body {
            background: var(--background-color) url('/images/banner-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--black);
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background-color: var(--bg);
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar a.logo {
            font-size: 2rem;
            font-weight: bold;
            color: #000 ;
            text-decoration: none;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }
        .navbar ul li a {
            text-decoration: none;
            color: #000 ;
            font-size: 1.5rem;
            transition: color 0.3s;
        }
        .navbar ul li a:hover {
            color: var(--primary-color);
        }
        
        /* Cart Page */
        .container {
            max-width: 1000px;
            margin: 70px auto 50px;
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
        }

        .cart-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .cart-header h1 {
            font-size: 28px;
            color: var(--secondary-color);
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cart-table th, .cart-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .cart-table th {
            background: var(--primary-color);
            color: var(--white);
        }

        .cart-table td .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .cart-table td .actions i {
            cursor: pointer;
            color: var(--primary-color);
            font-size: 18px;
        }

        .cart-table td .actions i:hover {
            color: var(--secondary-color);
        }

        .cart-summary {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            font-size: 18px;
            margin-top: 20px;
        }

        .cart-summary span {
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        
        .proceed-btn {
            display: block;
            background: var(--primary-color);
            color: var(--white);
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
            width: fit-content;
        }
        .proceed-btn:hover {
            background: var(--secondary);
        
        }
        
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="#" class="logo">FROSTINE</a>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerproducts">Products</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#review">Reviews</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customercustomisation">Customization</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerprofile">Profile</a></li>
        </ul>
    </div>

    <!-- Cart Page -->
    <header>Shopping Cart</header>
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
                <tr>
                    <td>Vanilla Cake</td>
                    <td>1</td>
                    <td>LKR 2,000</td>
                    <td>LKR 2,000</td>
                    <td class="actions">
                        <i class="fas fa-plus-circle"></i>
                        <i class="fas fa-minus-circle"></i>
                        <i class="fas fa-trash"></i>
                    </td>
                </tr>
                <tr>
                    <td>Chocolate Muffins</td>
                    <td>2</td>
                    <td>LKR 500</td>
                    <td>LKR 1,000</td>
                    <td class="actions">
                        <i class="fas fa-plus-circle"></i>
                        <i class="fas fa-minus-circle"></i>
                        <i class="fas fa-trash"></i>
                    </td>
                </tr>
                <tr>
                    <td>Strawberry Cupcakes</td>
                    <td>3</td>
                    <td>LKR 400</td>
                    <td>LKR 1,200</td>
                    <td class="actions">
                        <i class="fas fa-plus-circle"></i>
                        <i class="fas fa-minus-circle"></i>
                        <i class="fas fa-trash"></i>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="cart-summary" style="color: #783b31;">
            Grand Total: <span> LKR 4,200</span>
        </div>

        <button class="proceed-btn" style="text-align: center";>Proceed to Payment</button>
    </div>
</body>
</html>
