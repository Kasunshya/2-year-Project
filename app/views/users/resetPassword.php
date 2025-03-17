<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/forgot_rest.css">
<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <!-- Left Image Section -->
    <div class="image-section">
        <img src="<?php echo URLROOT; ?>/img/login-signup/about.png" alt="Cookies" class="cookies-image">
    </div>
<!-- Right Form Section -->
<div class="form-section">
        <div class="logo">
            <img src="<?php echo URLROOT; ?>/img/login-signup/frostineLogo.png" alt="Logo" class="logo-image">
</div><br><br><br><br>
    
    <form action="<?php echo URLROOT . "/Users/resetPassword/" . $data['token']; ?>" method="POST">
        <input type="password" name="password" placeholder="Enter new password" required>
        <input type="password" name="confirm_password" placeholder="Confirm new password" required>
        <button type="submit">Reset Password</button>
    </form>
    <?php if (!empty($data['password_err'])): ?>
        <div class="alert alert-danger">
            <?php echo $data['password_err']; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($data['confirm_password_err'])): ?>
        <div class="alert alert-danger">
            <?php echo $data['confirm_password_err']; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($data['token_err'])): ?>
        <div class="alert alert-danger">
            <?php echo $data['token_err']; ?>
        </div>
    <?php endif; ?>
</div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
