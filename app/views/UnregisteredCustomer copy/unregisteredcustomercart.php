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
            --text-color: #333;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg);
            color: var(--text-color);
        }

        header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 20px;
            text-align: center;
            font-size: 2rem;
            text-transform: uppercase;
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
            color: var(--text-color);
            text-decoration: none;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 1.5rem;
        }

        .navbar ul li a {
            text-decoration: none;
            color: var(--text-color);
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        .navbar ul li a:hover {
            color: var(--primary-color);
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cart-table th, .cart-table td {
            text-align: center;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .cart-table th {
            background-color: var(--primary-color);
            color: var(--white);
            font-size: 1rem;
        }

        .cart-table td {
            font-size: 0.9rem;
        }

        .cart-table td .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .cart-table td .actions i {
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .cart-table td .actions i:hover {
            color: var(--secondary);
        }

        .cart-summary {
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--secondary);
            margin-bottom: 20px;
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
            margin: 0 auto;
        }

        .proceed-btn:hover {
            background: var(--secondary);
        }

        .popup-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background: var(--white);
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            width: 300px;
            box-shadow: var(--box-shadow);
        }

        .popup-content p {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .popup-actions {
            display: flex;
            justify-content: space-around;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .popup-actions button {
            padding: 0.8rem 1.5rem;
            border: none;
            background: var(--primary-color);
            color: var(--white);
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .popup-actions button:hover {
            background: var(--secondary);
        }

        .close-popup {
            background: none;
            border: none;
            font-size: 1rem;
            color: var(--secondary);
            cursor: pointer;
        }

        .close-popup:hover {
            text-decoration: underline;
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
            <li><a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerproducts">Products</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#review">Reviews</a></li>
            <li><a href="#order">Pre Order</a></li>
        </ul>
    </div>

    <!-- Header -->
    <header>Shopping Cart</header>

    <!-- Cart Content -->
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

        <div class="cart-summary">
            Grand Total: <span>LKR 4,200</span>
        </div>

        <button class="proceed-btn" onclick="showPopup()">Proceed to Payment</button>
    </div>

    <!-- Popup Modal -->
    <div id="popup" class="popup-container">
        <div class="popup-content">
            <p>You need to <strong>Sign Up</strong> or <strong>Log In</strong> to proceed with the checkout.</p>
            <div class="popup-actions">
                <button onclick="window.location.href='/signup'">Sign Up</button>
                <button onclick="window.location.href='/login'">Log In</button>
            </div>
            <button class="close-popup" onclick="closePopup()">Close</button>
        </div>
    </div>

    <script>
        function showPopup() {
            document.getElementById('popup').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }
    </script>
</body>
</html>
