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
    <style>
        /* Add to your existing <style> section or CSS file */
        .categories .box-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        .categories .box-container .box {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .categories .box-container .box:hover {
            transform: translateY(-5px);
        }

        .categories .box-container .box .image {
            height: 200px;
            width: 100%;
            overflow: hidden;
        }

        .categories .box-container .box .image img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .categories .box-container .box:hover .image img {
            transform: scale(1.1);
        }

        .categories .box-container .box .content {
            padding: 2rem;
            text-align: center;
        }

        .categories .box-container .box .content h3 {
            font-size: 2rem;
            color: var(--black);
            margin-bottom: 1rem;
        }

        .categories .box-container .box .content p {
            font-size: 1.4rem;
            color: var(--light-color);
            line-height: 2;
            margin-bottom: 1rem;
        }

        /* Parallax effect */
        .categories {
            background: url('../img/parallax-bg.jpg') no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            padding: 5rem 0;
        }

        .categories .heading {
            text-align: center;
            padding-bottom: 3rem;
        }

        .categories .heading span {
            color: var(--primary-color);
            padding: .5rem 3rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: .5rem;
        }

        
    </style>
</head>
<body>
    
    <!-- Header -->
    
       
            <header class="header">
                <div class="logo" style="display: flex; align-items: center; gap: 10px;">
                    <img src="<?php echo URLROOT; ?>/public/img/HeadM/frostinelogo2.png" alt="FROSTINE" style="height: 60px; width: auto; margin-right: 0;">
                    <a href="#" style="text-decoration: none; color: #783b31; margin-left: -10px; font-weight: 600;">FROSTINE</a>
                </div>
                    
        <nav class="navbar">
            <a href="<?php echo URLROOT;?>/UnregisteredCustomer/unregisteredcustomerhomepage">Home</a>
            <a href="#about">about</a>
            <a href="<?php echo URLROOT ?>/UnregisteredCustomer/unregisteredcustomerproducts">product</a>
            <a href="#gallery">gallery</a>
            <a href="#review">review</a>
            <a href="#order">enquiry</a>
        </nav>
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
                        <a href="<?php echo URLROOT; ?>/UnregisteredCustomer/unregisteredcustomerproducts" class="btn">
                            View Details
                        </a>
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
    <h1 class="heading">range of <span>categories</span></h1>

    <div class="swiper category-slider">
        <div class="swiper-wrapper">
            <?php if (!empty($data['categories'])): ?>
                <?php foreach ($data['categories'] as $category): ?>
                    <div class="swiper-slide box">
                        <div class="image">
                            <?php if (!empty($category->image_path)): ?>
                                <img src="<?php echo URLROOT; ?>/public/img/categories/<?php echo htmlspecialchars($category->image_path); ?>" 
                                     alt="<?php echo htmlspecialchars($category->name); ?>">
                            <?php else: ?>
                                <img src="<?php echo URLROOT; ?>/public/img/default-category.jpg" 
                                     alt="Default category image">
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <h3><?php echo htmlspecialchars($category->name); ?></h3>
                            <p><?php echo htmlspecialchars($category->description); ?></p>
                            <a href="<?php echo URLROOT; ?>/UnregisteredCustomer/unregisteredcustomerproducts?category=<?php echo urlencode($category->category_id); ?>" 
                               class="btn">view products</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="swiper-slide box">
                    <div class="content">
                        <h3>No Categories Available</h3>
                        <p>Please check back later for our product categories.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>
    <!-- parallax -->



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

    <!-- enquiry -->

    <section class="order" id="order">
        <h1 class="heading"><span>Enquiry</span> Form</h1>

        <div class="row">
            <div class="image">
                <img src="../public/img/Customer/order.gif" alt="">
            </div>

            <form id="enquiryForm" action="<?php echo URLROOT; ?>/unregisteredcustomer/submitEnquiry" method="POST" onsubmit="return submitForm(event)">
                <div class="inputBox">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                </div>

                <div class="inputBox">
                    <input type="tel" name="phone_number" placeholder="Phone Number">
                    <input type="email" 
                           name="email_address" 
                           placeholder="Email Address" 
                           pattern="[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                           style="text-transform: none;"
                           required>
                </div>

                <textarea placeholder="Your Message" name="message" required></textarea>
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

    <!-- Add this before </body> tag -->
    <div id="notification" class="notification"></div>

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

        function navigateTo(url) { window.location.href = url; }

        // Email validation
        document.querySelector('input[name="email_address"]').addEventListener('input', function(e) {
            const email = e.target.value;
            const emailPattern = /^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            if (!emailPattern.test(email)) {
                e.target.setCustomValidity('Email must start with a letter (uppercase or lowercase)');
            } else {
                e.target.setCustomValidity('');
            }
        });

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

        function showLoginPrompt() {
            alert('Please log in to add items to your cart.');
        }
    </script>
    <!-- Chat Widget -->
    <?php require_once APPROOT . '/views/chat/index.php'; ?>
</body>
</html>
