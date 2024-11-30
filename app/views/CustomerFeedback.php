<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
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
        

        /* Order Summary Section */
        .container {
            max-width: 800px;
            margin: 80px auto 50px;
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
        }

        .container h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 10px;
            color: var(--secondary-color);
        }

        .thank-you-message {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--black);
        }

        .order-summary {
            margin-bottom: 20px;
        }

        .order-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-summary th, .order-summary td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .order-summary th {
            background: var(--primary-color);
            color: var(--white);
        }

        .order-summary td {
            color: var(--black);
        }

        .order-info {
            margin-top: 20px;
            text-align: left;
        }

        .order-info p {
            font-size: 16px;
            margin: 8px 0;
            color: var(--black);
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            background: var(--primary-color);
            color: var(--white);
            font-size: 16px;
            text-align: center;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background: var(--secondary-color);
        }

        /* Feedback Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: var(--white);
            padding: 20px;
            width: 400px;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            text-align: center;
        }

        .modal-content h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--secondary-color);
        }

        .modal-content textarea {
            width: 100%;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .modal-content .modal-buttons {
            display: flex;
            justify-content: space-between;
        }

        .close-btn {
            background: var(--secondary-color);
        }

        .close-btn:hover {
            background: var(--primary-color);
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
            <li><a href="<?php echo URLROOT ?>/customer/customercustomisation">Customization</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerprofile">Profile</a></li>
        </ul>
    </div>

    <!-- Order Summary -->
     <header>Thank you for your order!</header>
    <div class="container">
        
        <p class="thank-you-message" style="color: #783b31;">Your order has been successfully placed. Below is your order summary.</p>

        <!-- Order Summary Table -->
        <div class="order-summary">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Chocolate Cake</td>
                        <td>1</td>
                        <td>LKR 4,500</td>
                        <td>LKR 4,500</td>
                    </tr>
                    <tr>
                        <td>Blueberry Muffin</td>
                        <td>2</td>
                        <td>LKR 800</td>
                        <td>LKR 1,600</td>
                    </tr>
                    <tr>
                        <td>Vanilla Cupcake</td>
                        <td>3</td>
                        <td>LKR 350</td>
                        <td>LKR 1,050</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right;">Grand Total</th>
                        <th>LKR 7,150</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Order Information -->
        <div class="order-info">
            <p><strong>Order Number:</strong> #12345</p>
            <p><strong>Order Date:</strong> 2024-11-26</p>
            <p><strong>Payment Status:</strong> Paid</p>
        </div>

        <!-- Buttons -->
        <div class="buttons">
            <a href="index.html" class="btn">Back to Home</a>
            <button class="btn" id="add-feedback-btn">Add Feedback</button>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal" id="feedback-modal">
        <div class="modal-content">
            <h2 style="color: #783b31;">We Value Your Feedback</h2>
            <textarea placeholder="Write your feedback here..."></textarea>
            <div class="modal-buttons">
                <button class="btn close-btn" id="close-modal-btn">Close</button>
                <button class="btn">Submit</button>
            </div>
        </div>
    </div>

    <script>
        const feedbackBtn = document.getElementById('add-feedback-btn');
        const feedbackModal = document.getElementById('feedback-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');

        feedbackBtn.addEventListener('click', () => {
            feedbackModal.style.display = 'flex';
        });

        closeModalBtn.addEventListener('click', () => {
            feedbackModal.style.display = 'none';
        });
    </script>
</body>
</html>
