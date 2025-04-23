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

    <!-- Add this CSS in the head section -->
    <style>
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 4px;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        z-index: 1000;
    }

    .notification.success {
        background-color: #c98d83;
    }

    .notification.error {
        background-color: #ff6b6b;
    }

    .notification.show {
        opacity: 1;
    }
    </style>
</head>
<body>
    
    <!-- Header -->
    <header class="header">
        <a href="#" class="logo">FROSTINE</a>
        <nav class="navbar">
            <a href="<?php echo URLROOT;?>/customer/customerhomepage">Home</a>
            <a href="#about">About</a>
            <a href="<?php echo URLROOT ?>/customer/customerproducts">Products</a>
            <a href="#gallery">Gallery</a>
            <a href="#order">Review</a>
            <a href="#order">Enquiry</a>  <!-- Changed from #enquiry to #order -->
            <a href="<?php echo URLROOT ?>/customer/customercustomisation">Customization</a>
            <a href="<?php echo URLROOT ?>/customer/customerprofile">Profile</a>
            <a href="<?php echo URLROOT ?>/Login/logout">Log Out</a>
        </nav>
        <div class="icons">
            <div id="cart-btn" class="fas fa-shopping-cart" onclick="navigateTo('<?php echo URLROOT;?>/Customer/customercart')"></div>
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
                <p>
                    At Frostine Bakery, we believe that every sweet moment deserves the perfect treat. Our easy-to-use online system is built just for you – to make ordering your favorite cakes, pastries, and baked delights faster, easier, and more enjoyable. Whether you're planning a celebration or simply craving something fresh from the oven, Frostine brings the bakery to your doorstep with just a few clicks. Quality, freshness, and customer happiness are at the heart of everything we bake.              
                </p>
            </div>

        </div>

    </section>


    <!-- about us end-->

    <!-- product section -->
    <section class="product" id="product">
        <h1 class="heading">our <span>products</span></h1>
        
        <div class="box-container">
            <?php if (!empty($data['products'])): ?>
                <?php foreach ($data['products'] as $product): ?>
                    <div class="box">
                        <div class="image">
                            <?php if (!empty($product->image_path)) : ?>
                                <img src="<?php echo URLROOT; ?>/public/img/products/<?php echo htmlspecialchars($product->image_path); ?>" 
                                     alt="<?php echo htmlspecialchars($product->product_name); ?>"
                                     onerror="this.src='<?php echo URLROOT; ?>/public/img/default-product.jpg'">
                            <?php else : ?>
                                <img src="<?php echo URLROOT; ?>/public/img/default-product.jpg" 
                                     alt="Default product image">
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <h3><?php echo htmlspecialchars($product->product_name); ?></h3>
                            <div class="price">LKR <?php echo number_format($product->price, 2); ?></div>
                            <a href="<?php echo URLROOT; ?>/customer/customerproducts" class="btn">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <p>No products available at the moment.</p>
                </div>
            <?php endif; ?>
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

    <section class="promotion" id="promotion">
        <h1 class="heading">weekly <span>promotions</span></h1>

        <div class="box-container">
            <?php if(!empty($data['promotions'])): ?>
                <?php foreach($data['promotions'] as $promotion): ?>
                    <div class="box">
                        <div class="image">
                            <?php if(!empty($promotion->image_path)): ?>
                                <img src="<?php echo URLROOT; ?>/public/img/promotions/<?php echo htmlspecialchars($promotion->image_path); ?>" 
                                     alt="<?php echo htmlspecialchars($promotion->title); ?>">
                            <?php else: ?>
                                <img src="<?php echo URLROOT; ?>/public/img/default-promotion.jpg" alt="Default promotion image">
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <h3><?php echo htmlspecialchars($promotion->title); ?></h3>
                            <p><?php echo htmlspecialchars($promotion->description); ?></p>
                            <div class="promotion-date">Valid until: <?php echo date('d M Y', strtotime($promotion->end_date)); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="box">
                    <div class="content">
                        <h3>No Active Promotions</h3>
                        <p>Check back later for exciting offers!</p>
                    </div>
                </div>
            <?php endif; ?>
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

    <!-- enquiry -->

    <section class="order" id="order">
        <h1 class="heading"><span>Enquiry</span> Form</h1>

        <div class="row">
            <div class="image">
                <img src="../public/img/Customer/order.gif" alt="">
            </div>

            <form id="enquiryForm" action="<?php echo URLROOT; ?>/customer/submitEnquiry" method="POST" onsubmit="return submitForm(event)">
                <div class="inputBox">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                </div>

                <div class="inputBox">
                    <input type="email" name="email_address" placeholder="Email Address" style="text-transform: none;" required>
                    <input type="tel" name="phone_number" placeholder="Phone Number">
                </div>

                <textarea placeholder="Your Enquiry Message" name="message" cols="30" rows="10" required></textarea>
                <input type="submit" value="Submit Enquiry" class="btn">
            </form>
        </div>
    </section>

    <!-- enquiry end -->
    
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
                <a href="#" style="color: #c98d83"class="link">frostinebakery@gmail.com</a>
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

    <!-- Add this div after your footer section -->
    <div id="notification" class="notification"></div>

    <!-- Replace your existing script with this updated version -->
    <script>
    function showNotification(message, type) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = `notification ${type}`;
        
        // Show notification
        setTimeout(() => notification.classList.add('show'), 100);
        
        // Hide notification after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }

    function submitForm(e) {
        e.preventDefault();
        
        var form = document.getElementById('enquiryForm');
        var formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showNotification('Thank you for your enquiry!', 'success');
                form.reset();
            } else {
                showNotification('Please try again later.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Something went wrong. Please try again.', 'error');
        });
        
        return false;
    }
    </script>
</body>
</html>
