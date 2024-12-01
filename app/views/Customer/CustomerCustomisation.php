<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Customization</title>
    <link href="https://fonts.googleapis.com/css2?family=Vidaloka&display=swap" rel="stylesheet">
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
        body {
            background-color: var(--bg);
            color: var(--secondary);
        }
        header {
            background-color: var(--primary-color);
            padding: 2rem;
            text-align: center;
            color: var(--white);
            font-size: 2.5rem;
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
        
        section {
            padding: 3rem 7%;
        }
        .customization-form {
            background: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
        }
        .customization-form h2 {
            color: var(--primary-color);
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group textarea {
            resize: none;
            height: 100px;
        }
        .btn {
            background: var(--primary-color);
            color: var(--white);
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .btn:hover {
            background: var(--secondary);
        }
        .summary-section {
            margin-top: 3rem;
        }
        .summary-section h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }
        .summary {
            background: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
        }
        .summary p {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body >


<!-- Navigation Bar -->
<div class="navbar">
        <a href="#" class="logo">FROSTINE</a>
        <ul>
            <li><a href="<?php echo URLROOT ?>/customer/customerhomepage">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerproducts">Products</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#review">Reviews</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customercustomisation">Customization</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerprofile">Profile</a></li>
        </ul>
    </div>

<header>Customization</header>

<section>
    <div class="customization-form">
        <h2>Customize Your Order</h2>
        <form id="customizationForm">
            <div class="form-group">
                <label for="flavor">Flavor</label>
                <select id="flavor" required>
                    <option value="Vanilla">Vanilla</option>
                    <option value="Chocolate">Chocolate</option>
                    <option value="Red Velvet">Red Velvet</option>
                    <option value="Strawberry">Strawberry</option>
                    <option value="Lemon">Lemon</option>
                </select>
            </div>
            <div class="form-group">
                <label for="size">Size</label>
                <select id="size" required>
                    <option value="Small">Small (serving 5-7)</option>
                    <option value="Medium">Medium (serving 7-9)</option>
                    <option value="Large">Large (serving 9-12)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="toppings">Toppings</label>
                <input type="text" id="toppings" placeholder="e.g., Chocolate Chips, Nuts">
            </div>
            <div class="form-group">
                <label for="message">Custom Message</label>
                <textarea id="message" placeholder="Write your custom message here"></textarea>
            </div>
            <div class="form-group">
                <label for="deliveryDate">Delivery Date</label>
                <input type="date" id="deliveryDate" required>
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>

    <div class="summary-section">
        <h2>Your Customization</h2>
        <div class="summary" id="orderSummary">
            <p><strong>Flavor:</strong> Not selected</p>
            <p><strong>Size:</strong> Not selected</p>
            <p><strong>Toppings:</strong> None</p>
            <p><strong>Message:</strong> None</p>
            <p><strong>Delivery Date:</strong> Not selected</p>
        </div>
    </div>
</section>

<script>
    document.getElementById('customizationForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Fetch values from form inputs
        const flavor = document.getElementById('flavor').value;
        const size = document.getElementById('size').value;
        const toppings = document.getElementById('toppings').value || 'None';
        const message = document.getElementById('message').value || 'None';
        const deliveryDate = document.getElementById('deliveryDate').value;

        // Update the summary section
        document.getElementById('orderSummary').innerHTML = `
            <p><strong>Flavor:</strong> ${flavor}</p>
            <p><strong>Size:</strong> ${size}</p>
            <p><strong>Toppings:</strong> ${toppings}</p>
            <p><strong>Message:</strong> ${message}</p>
            <p><strong>Delivery Date:</strong> ${deliveryDate}</p>
        `;
    });
</script>

</body>
</html>
