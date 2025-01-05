<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Bakery Website</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../public/css/Customer/CustomerHomepage.css">
</head>
<body>
    
    <!-- Header -->
    <header class="header">
        <a href="#" class="logo">FROSTINE</a>
        <nav class="navbar">
            <a href="<?php echo URLROOT;?>/UnregisteredCustomer/unregisteredcustomerhomepage">Home</a></li>
            <a href="#about">about</a>
            <a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerproducts">product</a>
            <a href="#gallery">gallery</a>
            <a href="#review">review</a>
            <a href="#pre-order">pre order</a>
            </nav>
        <div class="icons">
            <div id="cart-btn" class="fas fa-shopping-cart" onclick = "navigateTo('<?php echo URLROOT;?>/UnregisteredCustomer/unregisteredcustomercart')">
        </div>
    </header>

    <!-- Home Section -->
    <section class="home" id="home">
    <div class="swiper home-slider">
        <div class="swiper-wrapper">
            <!-- First Slider -->
            <div class="swiper-slide slide" style="background: url(../public/img/Customer/slider1.jpg) no-repeat;">
                <div class="content">
                    <h3>we bake the world a better place</h3>
                    <h2 class="welcome-text" style="color: #fff; font-family: 'Vidaloka', sans-serif; font-size:20px;">
                            Welcome to FROSTINE Bakery! Your One-Stop Destination for Freshly Baked Delights!
                        </h2>
                    <!-- Welcome Section -->
                    <div class="welcome-section">
                        <div class="home-buttons" style="gap: 7rem; margin-top: 2rem; display: flex; justify-content: center;">
                            <a href="<?php echo URLROOT ?>/Register/signup" class="btn new-user">I'm a New User</a>
                            <a href="<?php echo URLROOT ?>/Login/indexx" class="btn existing-user">I'm Already a User</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Slider -->
            <div class="swiper-slide slide" style="background: url(../public/img/Customer/slider2.jpg) no-repeat;">
                <div class="content">
                    <h3>we bake the world a better place</h3>
                </div>
            </div>
        </div>

        <!-- Slider Buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>



    <!-- about us -->

    <section class="about" id="about">

        <h1 class="heading"> <span>about</span> us </h1>

        <div class="row">

            <div class="image">
                <img src="../public/img/Customer/about.png" alt="">
            </div>

            <div class="content">
                <h3>good things come to those <span>who bake </span> for others</h3>
                <p>Welcome to FROSTINE, where we blend tradition with innovation to bring you the finest bakery delights.
                Our commitment to quality and customer satisfaction ensures a delightful experience with every order. Join us in celebrating the art of baking!
                </p>
                <a href="#" class="btn">read more</a>
            </div>

        </div>

    </section>


    <!-- about us end-->

    <!-- product -->

    <section class="product" id="product">

        <h1 class="heading">our <span> products</span></h1>

        <div class="box-container">

            <div class="box">
                <div class="image">
                    <img src="../public/img/Customer/product-1.jpg" alt="">
                </div>
                <div class="content">
                    <h3>Strawberry Pancake</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="price">LKR 1250.00</span>
                    <a href="#" class="btn">add to cart</a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="../public/img/Customer/product-2.jpg" alt="">
                </div>
                <div class="content">
                    <h3>Blueberry Pancake</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="price">LKR 1450.00</span>
                    <a href="#" class="btn">add to cart</a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="../public/img/Customer/product-3.jpg" alt="">
                </div>
                <div class="content">
                    <h3>Butter & Honey Bread</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="price">LKR 1950.00</span>
                    <a href="#" class="btn">add to cart</a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="../public/img/Customer/product-4.jpg" alt="">
                </div>
                <div class="content">
                    <h3>Rose Pink Cake</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="price">LKR 9550.00</span>
                    <a href="#" class="btn">add to cart</a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="../public/img/Customer/product-5.jpg" alt="">
                </div>
                <div class="content">
                    <h3>Honey Waffles</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="price">LKR 1200.00</span>
                    <a href="#" class="btn">add to cart</a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="../public/img/Customer/product-6.jpg" alt="">
                </div>
                <div class="content">
                    <h3>Honey Pancake</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="price">LKR 1050.00</span>
                    <a href="#" class="btn">add to cart</a>
                </div>
            </div>

        </div>

    </section>


    <!-- product end-->


    <!-- gallery -->

    <section class="gallery" id="gallery">

        <h1 class="heading">our <span> gallery</span></h1>

        <div class="gallery-container">

            <a href="../public/img/Customer/gallery1.jpg" class="box">
                <img src="../public/img/Customer/gallery1.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="../public/img/Customer/gallery2.jpg" class="box">
                <img src="../public/img/Customer/gallery2.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="../public/img/Customer/gallery3.jpg" class="box">
                <img src="../public/img/Customer/gallery3.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="../public/img/Customer/gallery4.jpg" class="box">
                <img src="../public/img/Customer/gallery4.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="../public/img/Customer/gallery5.jpg" class="box">
                <img src="../public/img/Customer/gallery5.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

            <a href="../public/img/Customer/gallery6.jpg" class="box">
                <img src="../public/img/Customer/gallery6.jpg" alt="">
                <div class="icons"><i class="fas fa-plus"></i></div>
            </a>

        </div>

    </section>

    <!-- gallery end -->

    <!-- weekly promotions -->

    <section class="promotion">

        <h1 class="heading">weekly <span>promotions</span></h1>

        <div class="box-container">

            <div class="box">
                <div class="content">
                    <h3>chocolat cake</h3>
                    <p>Experience pure bliss with our rich, velvety chocolate cake, crafted for every chocolate lover's delight. Perfect for any occasion, indulge in a slice of luxury today.
                    </p>
                </div>

                <img src="../public/img/Customer/promotion1.png" alt="">
            </div>

            <div class="box">
                <img src="../public/img/Customer/promotion2.png" alt="">
                <div class="content">
                    <h3>nut cake</h3>
                    <p>Savor the rich flavors of our nut cake, packed with crunchy nuts and a hint of sweetness. Perfectly balanced and utterly irresistible, it's a treat you won't want to miss!</p>
                </div>
                
            </div>

        </div>

    </section>

    <!-- weekly promotions ends -->


    <!-- parallax -->

    <section class="parallax">

        <h1 class="heading">range of <span>products</span></h1>

        <div class="box-container">

            <div class="box">
                <div class="image">
                    <img src="../public/img/Customer/parallax-1.png" alt="">
                </div>
                <div class="content">
                    <h3>bread</h3>
                    <p>Explore our selection of freshly baked breads, crafted daily with the finest ingredients. From classic sourdough to soft brioche, each loaf promises exceptional taste and quality.</p>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="../public/img/Customer/parallax-2.png" alt="">
                </div>
                <div class="content">
                    <h3>cakes</h3>
                    <p>Indulge in our exquisite cakes, crafted with the finest ingredients and decorated to perfection. From classic favorites to unique creations, each slice is a celebration of flavor and artistry.
                   </p>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="../public/img/Customer/parallax-3.png" alt="">
                </div>
                <div class="content">
                    <h3>donuts</h3>
                    <p>Delight in our delectable donuts, freshly made and bursting with flavor. From classic glazed to creative flavors, each bite is pure indulgence.</p>
                </div>
            </div>

        </div>

    </section>

    <!-- parallax -->

    <!-- review -->

    <section class="review" id="review">

        <h1 class="heading"> customer's <span>review</span> </h1>

        <div class="box-container">

            <div class="box">
                <img src="../public/img/Customer/review-1.png" class="user" alt="">
                <h3>Pasindu Takeshi</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p>Absolutely delightful experience at Frostine! The pastries are always fresh and the variety is incredible. Highly recommend their croissants and coffee for a perfect start to your day.</p>
            </div>

            <div class="box">
                <img src="../public/img/Customer/review-2.png" class="user" alt="">
                <h3>Kasunshya Pabodi</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p>Amazing bakery with a warm, inviting atmosphere. The staff is friendly, and their cakes are to die for. You can't go wrong with their chocolate fudge cake!</p>
            </div>

            <div class="box">
                <img src="../public/img/Customer/review-3.png" class="user" alt="">
                <h3>Kavindu Sheshan</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p>Fantastic bakery that never disappoints! Their bread is always baked to perfection, and the sandwiches are delicious. A must-visit spot for any bakery lover.</p>
            </div>

        </div>

    </section>

    <!-- review -->

    <!-- order -->

    <section class="order" id="order">

        <h1 class="heading"><span>Pre Order</span> now </h1>

        <div class="row">

            <div class="image">
                <img src="../public/img/Customer/order.gif" alt="">
            </div>

            <form action="">

                <div class="inputBox">
                    <input type="text" placeholder="first name">
                    <input type="text" placeholder="last name">
                </div>

                <div class="inputBox">
                    <input type="email" placeholder="email address">
                    <input type="number" placeholder="phone number">
                </div>

                <div class="inputBox">
                    <input type="text" placeholder="food name">
                    <input type="number" placeholder="how much">
                </div>

                <textarea placeholder="your address" name="" id="" cols="30" rows="10"></textarea>
                <input type="submit" value="pre order now" class="btn">
            </form>

        </div>

    </section>

    <!-- order end -->
    
    <!-- Footer -->
    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>address</h3>
                <p>No.UCSC Building Complex, 35 Reid Ave, Colombo 00700</p>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>
            <div class="box">
                <h3>E-mail</h3>
                <a href="#" style="color: #c98d83"  class="link">frostinebakery@gmail.com</a>
            </div>
            <div class="box">
                <h3>call us</h3>
                <p>+9477100223</p>
                <p>+94741223188</p>
            </div>
            <div class="box">
                <h3> opening hours</h3>
                <p>Monday - Friday: 9:00 - 23:00 <br> Saturday: 8:00 - 24:00 </p>
            </div>
        </div>
        <div class="credit">created by <span></span> all rights reserved!</div>
    </section>

    <!-- JavaScript -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.home-slider', {
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        function navigateTo(url) { window.location.href = url; }
    </script>
</body>
</html>
