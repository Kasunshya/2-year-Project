<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
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
            background: var(--background-color) url('/images/banner-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--black);
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
            font-size: 1.7rem;
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
            font-size: 1.3rem;
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
        
        /* Profile Page */
        .container {
            max-width: 900px;
            margin: 70px auto 50px; /* Added top margin for navbar */
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header h1 {
            font-size: 28px;
            color: #783b31;
        }

        .profile-info {
            margin-bottom: 30px;
        }

        .profile-info label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
            margin-left: 500px;
        }

        .profile-info input {
            width: 40%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            margin-left: 500px;
        }

        .tabs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--primary-color);
        }

        .tabs button {
            flex: 1;
            background: transparent;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            color: var(--black);
            border-bottom: 3px solid transparent;
        }

        .tabs button.active {
            border-bottom: 3px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: bold;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .order-history, .current-orders {
            width: 100%;
            border-collapse: collapse;
        }

        .order-history th, .order-history td,
        .current-orders th, .current-orders td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .order-history th, .current-orders th {
            background: var(--primary-color);
            color: var(--white);
        }

        .order-history tr:nth-child(even),
        .current-orders tr:nth-child(even) {
            background: #f9f9f9;
        }

        .reset-password {
            margin-top: 20px;
            text-align: center;
        }

        .reset-password button {
            background: var(--primary-color);
            color: var(--white);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .reset-password button:hover {
            background: #783b31;
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
    

    <!-- Customer Profile Page -->
    <header>Customer Profile</header>

        <div class="profile-info">
            <label for="username" style="color: #783b31;">Username</label>
            <input type="text" id="username" value="JohnDoe123" disabled>

            <label for="email" style="color: #783b31;">Email</label>
            <input type="email" id="email" value="johndoe@example.com" disabled>

            <label for="password" style="color: #783b31;">Password</label>
            <input type="password" id="password" value="********" disabled>
        </div>
        <div class="reset-password">
            <button>Reset Password</button>
        </div>
        </div>

        <div class="tabs">
            <button class="active" data-tab="order-history">Order History</button>
            <button data-tab="current-orders">Current Orders</button>
        </div>

        <div class="tab-content active" id="order-history">
            
            <table class="order-history">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>101</td>
                        <td>2024-11-01</td>
                        <td>LKR 5,000</td>
                        <td>Delivered</td>
                    </tr>
                    <tr>
                        <td>102</td>
                        <td>2024-11-10</td>
                        <td>LKR 2,800</td>
                        <td>Delivered</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-content" id="current-orders">
            <h2>Current Orders</h2>
            <table class="current-orders">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>103</td>
                        <td>2024-11-20</td>
                        <td>LKR 3,000</td>
                        <td>In Progress</td>
                    </tr>
                    <tr>
                        <td>104</td>
                        <td>2024-11-22</td>
                        <td>LKR 1,500</td>
                        <td>Preparing</td>
                    </tr>
                </tbody>
            </table>
        </div>

        

    <script>
        // Tab Switching Logic
        const tabs = document.querySelectorAll('.tabs button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                tab.classList.add('active');
                document.getElementById(tab.dataset.tab).classList.add('active');
            });
        });
    </script>
</body>
</html>
