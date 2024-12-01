<?php require APPROOT.'/views/inc/header.php'?>
<!--TOP NAVIGATION BAR-->
  <!--?php require APPROOT.'/views/inc/components/topnavbar.php'?-->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/registerform.css">
  

  <div class="signup-container">
        <div class="image-section">
            <img src="<?php echo URLROOT;?>/img/login-signup/about.png" alt="Cookies" class="cookies-image">
        </div>
        <div class="signup-section">
            <div class="logo">
                <!-- Add your logo image here-->
                <img src="<?php echo URLROOT;?>/img/login-signup/frostineLogo.png" alt="Logo" class="logo-image">
                <h1>FROSTINE</h1>
                <p>From Oven to Doorstep, Effortlessly YC</p>
            </div>
            <h2>Create an Account</h2>
            <form action="<?php echo URLROOT?>/Register/signup" method="POST">
                <div class="input-group">
                <input type="text" name="customer_name" id="customer_name" placeholder="Username" value="<?= htmlspecialchars($data['customer_name'] ?? '') ?>">
                <span><?= $data['errors']['customer_name'] ?? '' ?></span>
                </div>
                <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                <span><?= $data['errors']['email'] ?? '' ?></span>
                </div>
                <div class="input-group">
                <input type="password" name="password" placeholder="Password" id="password">
                <span><?= $data['errors']['password'] ?? '' ?></span>
                </div>
                <div class="input-group">
                <input type="password" name="confirm_password" placeholder="Confirmed Password"id="confirm_password">
                <span><?= $data['errors']['confirm_password'] ?? '' ?></span>
                </div>

                <button type="submit" name="submit" class="signup-btn">Sign Up</button></a>
                <span><?= $data['errors']['general'] ?? '' ?></span>
            </form>
            <a href="<?php echo URLROOT; ?>/Login/indexx" class="login-link">Already have an account? Log in</a>
        </div>
    </div>
  <?php require APPROOT.'/views/inc/footer.php'?>

