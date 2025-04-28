<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Bakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    

    <!-- Navigation Bar Styles -->
    <style>
    /* Common Navigation Bar Styles */
    :root {
        --primary-color: #c98d83;
        --secondary: #783b31;
        --bg: #f2f1ec;
        --white: #ffffff;
        --black: #333333;
        --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

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
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo-img {
        height: 40px;
        width: auto;
    }

    .navbar ul {
        display: flex;
        list-style: none;
        gap: 2rem;
        margin: 0;
        padding: 0;
        align-items: center;
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

    .cart-link {
        position: relative;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--primary-color);
        color: var(--white);
        border-radius: 50%;
        padding: 2px 4px;
        font-size: 10px;
        min-width: 20px;
        text-align: center;
    }

    /* Responsive Navbar */
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
    </style>
</head>
<body>
    <header class="header">
      
        <!-- Navigation Bar HTML -->
        
        
        <nav class="navbar">
            <a href="<?php echo URLROOT; ?>/customer/customerhomepage" class="logo">
                <img src="<?php echo URLROOT; ?>/public/img/HeadM/frostinelogo2.png" alt="FROSTINE" style="height: 60px; width: auto;">
                FROSTINE
            </a>
            <ul>
                <li><a href="<?php echo URLROOT; ?>/customer/customerhomepage">Home</a></li>
                <li><a href="<?php echo URLROOT; ?>/customer/customerhomepage#about">About</a></li>
                <li><a href="<?php echo URLROOT; ?>/customer/customerproducts">Products</a></li>
                <li><a href="<?php echo URLROOT; ?>/customer/customerhomepage#review">Reviews</a></li>
                <li><a href="<?php echo URLROOT; ?>/customer/customercustomisation">Customization</a></li>
                <li><a href="<?php echo URLROOT; ?>/customer/customerprofile">Profile</a></li>
                <li><a href="<?php echo URLROOT; ?>/customer/customercart" class="cart-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">
                        <?php 
                        $cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
                        echo $cartCount;
                        ?>
                    </span>
                </a></li>
            </ul>
        </nav>
    </header>
</body>
</html>