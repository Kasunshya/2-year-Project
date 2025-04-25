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

    <style>
    
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
<nav class="navbar">
            <a href="<?php echo URLROOT; ?>/customer/customerhomepage" class="logo">
                <img src="<?php echo URLROOT; ?>/public/img/Customer/frostinelogo.png" alt="FROSTINE" class="logo-img">
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
    
    <!-- Debug output -->
    <div style="display: none;">
        <?php 
        echo "<pre>";
        echo "Data array contents:\n";
        print_r($data);
        echo "\nPosted Feedbacks:\n";
        if (isset($data['postedFeedbacks'])) {
            print_r($data['postedFeedbacks']);
            echo "Count: " . count($data['postedFeedbacks']);
        } else {
            echo "postedFeedbacks key does not exist in data array";
        }
        echo "</pre>";
        ?>
    </div>
    
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
</body>
</html>
