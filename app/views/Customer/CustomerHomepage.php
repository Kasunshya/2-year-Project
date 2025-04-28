<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? 'Frostine Bakery'; ?></title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/Customer/CustomerHomepage.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

 <!-- Header -->
 <header class="header">
 <div class="logo">
 <img src="<?php echo URLROOT; ?>/public/img/HeadM/frostinelogo2.png" alt="FROSTINE" style="height: 60px; width: auto; align-items:left;">
</div>
    <a href="#" class="logo">FROSTINE</a>
    
    <nav class="navbar">

        <a href="<?php echo URLROOT;?>/customer/customerhomepage">Home</a>
        <a href="#about">About</a>
        <a href="<?php echo URLROOT ?>/customer/customerproducts">Products</a>
        <a href="#gallery">Gallery</a>
        <a href="#review">Review</a>
        <a href="#order">Enquiry</a>
        <a href="<?php echo URLROOT ?>/customer/customercustomisation">Customization</a>
        <a href="<?php echo URLROOT ?>/customer/customerprofile">Profile</a>
        <a href="<?php echo URLROOT ?>/Login/indexx">Log Out</a>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
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


    <!-- About Us Section -->
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

    <!-- Product Section -->
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

    <!-- Gallery Section -->
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

    <!-- Promotion Section -->
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

    <!-- Parallax Section -->
    <section class="parallax">
        <h1 class="heading">range of <span>categories</span></h1>

        <div class="swiper category-slider">
            <div class="swiper-wrapper">
                <?php if (!empty($data['categories'])): ?>
                    <?php foreach ($data['categories'] as $category): ?>
                        <div class="swiper-slide box">
                            <div class="image">
                                <?php if (!empty($category->image_path)): ?>
                                    <img src="<?php echo URLROOT; ?>/public/img/categories/<?php echo htmlspecialchars($category->image_path); ?>" 
                                         alt="<?php echo htmlspecialchars($category->name); ?>"
                                         onerror="this.src='<?php echo URLROOT; ?>/public/img/default-category.jpg'">
                                <?php else: ?>
                                    <img src="<?php echo URLROOT; ?>/public/img/default-category.jpg" 
                                         alt="Default category image">
                                <?php endif; ?>
                            </div>
                            <div class="content">
                                <h3><?php echo htmlspecialchars($category->name); ?></h3>
                                <p><?php echo htmlspecialchars($category->description); ?></p>
                                <a href="<?php echo URLROOT; ?>/customer/customerproducts?category=<?php echo urlencode($category->name); ?>" 
                                   class="btn">view products</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <!-- Review Section -->
    <section class="review" id="review">
        <h1 class="heading"> customer's <span>review</span> </h1>

        <div class="box-container">
            <?php 
            if (isset($data['postedFeedbacks']) && !empty($data['postedFeedbacks'])):
                // Get only the latest three feedbacks
                $latestFeedbacks = array_slice($data['postedFeedbacks'], 0, 3);
                foreach ($latestFeedbacks as $feedback):
            ?>
                <div class="box">
                    <h3><?php echo htmlspecialchars($feedback->customer_name ?? 'Happy Customer'); ?></h3>
                    <p><?php echo htmlspecialchars($feedback->feedback_text); ?></p>
                </div>
            <?php 
                endforeach; 
            else:
            ?>
                <!-- Default testimonials if no posted feedback -->
                <div class="box">
                    <h3>Pasindu Takeshi</h3>
                    <p>Absolutely delightful experience at Frostine! The pastries are always fresh and the variety is incredible. Highly recommend their croissants and coffee for a perfect start to your day.</p>
                </div>
                <div class="box">
                    <h3>Elena Rodriguez</h3>
                    <p>The cakes here are works of art! I ordered my daughter's birthday cake and it was not only beautiful but delicious too. Everyone at the party asked where it was from.</p>
                </div>
                <div class="box">
                    <h3>Michael Chang</h3>
                    <p>I've been coming to Frostine for years and they never disappoint. Their sourdough bread is perfect and their seasonal pastries are always something to look forward to.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Enquiry Section -->
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

    <!-- Footer Section -->
    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>address</h3>
                <p>No.789,Oak Street,Colombo</p>
                <p>No.76/B,Horana Road,Horana</p>
                <p>No.456,Gampaha Road,Gampaha</p>
            
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

    <!-- Notification container -->
    <div id="notification" class="notification"></div>

    <!-- Scripts -->
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

    <script>
        let navbar = document.querySelector('.navbar');
        let menuBtn = document.querySelector('#menu-btn');

        menuBtn.onclick = () => {
            navbar.classList.toggle('active');
            menuBtn.classList.toggle('fa-times');
        }

        window.onscroll = () => {
            navbar.classList.remove('active');
            menuBtn.classList.remove('fa-times');
        }
    </script>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var categorySwiper = new Swiper(".category-slider", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                991: {
                    slidesPerView: 3,
                },
            },
        });
    </script>
    <script>
        var homeSwiper = new Swiper(".home-slider", {
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

    <!-- Chat Widget -->
    <?php require_once APPROOT . '/views/chat/index.php'; ?>
</body>
</html>
