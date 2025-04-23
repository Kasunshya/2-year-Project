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
                <img src="<?php echo URLROOT;?>/img/login-signup/frostineLogo.png" alt="Logo" class="logo-image"><br><br>
            </div>
            <h2>Create an Account</h2>
            <form action="<?php echo URLROOT?>/Register/signup" method="POST">
                <div class="input-group">
                <input type="text" name="full_name" id="full_name" placeholder="Full Name" value="<?= htmlspecialchars($data['full_name'] ?? '') ?>">
                <span><?= $data['errors']['full_name'] ?? '' ?></span>
                </div>
                <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email (This will be your username)" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                <span><?= $data['errors']['email'] ?? '' ?></span>
                </div>
                <div class="input-group">
                <input type="tel" name="contact_number" id="contact_number" placeholder="Contact Number" value="<?= htmlspecialchars($data['contact_number'] ?? '') ?>">
                <span><?= $data['errors']['contact_number'] ?? '' ?></span>
                </div>
                <div class="input-group">
                <input type="text" name="address" id="address" placeholder="Address" value="<?= htmlspecialchars($data['address'] ?? '') ?>">
                <span><?= $data['errors']['address'] ?? '' ?></span>
                </div>
                <div class="input-group">
                <input type="password" name="password" placeholder="Password" id="password">
                <span><?= $data['errors']['password'] ?? '' ?></span>
                </div>
                <div class="input-group">
                <input type="password" name="confirm_password" placeholder="Confirmed Password" id="confirm_password">
                <span><?= $data['errors']['confirm_password'] ?? '' ?></span>
                </div>

                <button type="submit" name="submit" class="signup-btn">Sign Up</button>
                <span><?= $data['errors']['general'] ?? '' ?></span>
            </form>
            <a href="<?php echo URLROOT; ?>/Login/indexx" class="login-link">Already have an account? Log in</a>
        </div>
    </div>
<?php require APPROOT.'/views/inc/footer.php'?>

