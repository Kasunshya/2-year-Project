<!-- Add this at the top of your file to see any PHP errors -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/login.css">

  <div class="login-container">
        <div class="image-section">
            <img src="<?php echo URLROOT;?>/img/login-signup/about.png" alt="Cookies" class="cookies-image">
        </div>
        <div class="login-section">
            <div class="logo">
                <img src="<?php echo URLROOT;?>/img/login-signup/frostineLogo.png" alt="Logo" class="logo-image">

            </div>
            <h2>Welcome Back!</h2>
            <?php if (!empty($loginError)) : ?>
                <div class="error-message"><?= htmlspecialchars($loginError); ?></div>
            <?php endif; ?>
            <?php if(isset($data['registration_success']) && $data['registration_success']): ?>
                <div class="success-message">
                    Registration successful! Please login with your new account.
                </div>
            <?php endif; ?>
            <form action="<?php echo URLROOT; ?>/Login/indexx" method="POST">
                <!-- Add this debugging info if needed -->
                <div style="display: none;">
                    <p>URLROOT: <?php echo URLROOT; ?></p>
                    <p>Current URL: <?php echo $_SERVER['REQUEST_URI']; ?></p>
                </div>
                <div class="input-group">
                <input type="email" name="email"placeholder="Email" id="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
                <span><?php echo $data['errors']['email'] ?? ''; ?></span>
                </div>
                <div class="input-group">
                <input type="password" placeholder="Password" name="password" id="password" required>
                <span><?php echo $data['errors']['password'] ?? ''; ?></span>
                </div>
                <button id="submit" type="submit" name="login" class="login-btn">Login</button>
                <span><?php echo $data['errors']['general'] ?? ''; ?></span>
            </form>
            <a href="<?php echo URLROOT; ?>/users/forgotPassword" class="forgot-password">Forgot Password?</a>
            <a href="<?php echo URLROOT; ?>/Users/register" class="forgot-password">New Account</a>
        </div>
    </div>
    <?php require APPROOT.'/views/inc/footer.php'?>

