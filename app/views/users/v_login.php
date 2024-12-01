<!--php require APPROOT.'/views/inc/header.php'?>
< TOP NAVIGATION BAR-->
  <!--?php require APPROOT.'/views/inc/components/topnavbar.php'?-->
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
            <form action="<?php echo URLROOT; ?>/Login/indexx" method="POST">
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
            <a href="forgotPassword.php" class="forgot-password">Forgot Password?</a>
            <a href="<?php echo URLROOT; ?>/Users/register" class="forgot-password">New Account</a>
        </div>
    </div>
    <?php require APPROOT.'/views/inc/footer.php'?>

