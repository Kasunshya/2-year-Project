<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/forgot_rest.css">
<div class="container">
    <!-- Left Image Section -->
    <div class="image-section">
        <img src="<?php echo URLROOT; ?>/img/login-signup/about.png" alt="Cookies" class="cookies-image"></div>
    <!-- Right Form Section -->
    <div class="form-section">
        <div class="logo">
            <img src="<?php echo URLROOT; ?>/img/login-signup/frostineLogo.png" alt="Logo" class="logo-image">
        </div>
<?php if (!empty($data['email_err'])): ?>
    <div class="alert alert-danger">
        <?php echo $data['email_err']; ?>
    </div>
<?php elseif (!empty($data['success_msg'])): ?>
    <div class="alert alert-success">
        <?php echo $data['success_msg']; ?>
    </div>
<?php endif; ?>

<form action="<?php echo URLROOT; ?>/Users/forgotPassword" method="POST">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send Reset Link</button>
</form>
<div>
</div>