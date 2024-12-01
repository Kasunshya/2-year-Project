<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
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
            text-transform: capitalize;
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

        /* Payment Form */
        .container {
            max-width: 500px;
            margin: 80px auto 50px;
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
        }

        .container h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: var(--secondary-color);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
            color: var(--secondary-color);
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .form-row {
            display: flex;
            gap: 10px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: var(--primary-color);
            color: var(--white);
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .checkout-btn:hover {
            background:#783b31;
        }

        .secure-info {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--black);
        }

        .secure-info i {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="#" class="logo">FROSTINE</a>
        <ul>
            <li><a href="<?php echo URLROOT ?>/customer/customerhomepage">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerproducts">Products</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#review">Reviews</a></li>
            <a href="<?php echo URLROOT ?>/customer/customercustomisation">Customization</a></li>
            <a href="<?php echo URLROOT ?>/customer/customerprofile">Profile</a></li>
        </ul>
    </div>

    <!-- Payment Form -->
     <header>Payment Details</header>
    <div class="container">
      
        <form action="#" method="POST">
            <div class="form-group" style="color: #783b31;">
                <label for="cardholder-name">Cardholder Name</label>
                <input type="text" id="cardholder-name" name="cardholder_name" placeholder="Enter Cardholder Name" required>
            </div>
            <div class="form-group" style="color: #783b31;">
                <label for="card-number">Card Number</label>
                <input type="text" id="card-number" name="card_number" placeholder="Enter Card Number" required>
            </div>
            <div class="form-row">
                <div class="form-group" style="color: #783b31;">
                    <label for="expiry-date">Expiration Date</label>
                    <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/YY" required>
                </div>
                <div class="form-group" style="color: #783b31;">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123" required>
                </div>
            </div>
            
            <a href="<?php echo URLROOT ?>/Customer/customerfeedback" class="checkout-btn" style="text-align: center;">
    Checkout
</a>

        </form>
        <div class="secure-info">
            <p><i class="fas fa-lock"></i> Your payment is secure and encrypted.</p>
        </div>
    </div>
</body>
</html>
