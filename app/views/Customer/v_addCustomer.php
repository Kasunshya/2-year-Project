<?php require APPROOT . '/views/inc/sysAdminHeader.php'; ?>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="<?php echo URLROOT; ?>/Dashboard"><i class="fas fa-th"></i>Dashboard</a></li>
            <li><a href="<?php echo URLROOT; ?>/User"><i class="fas fa-user"></i>User Management</a></li>
            <li><a href="<?php echo URLROOT; ?>/Product"><i class="fas fa-truck"></i>Product Management</a></li>
            <li><a href="<?php echo URLROOT; ?>/Customer" class="active"><i class="fas fa-users"></i>Customer Management</a></li>
            <li><a href="<?php echo URLROOT; ?>/Order"><i class="fas fa-eye"></i>View Orders</a></li>
        </ul>
        <div class="logo">
            <img src="<?php echo URLROOT; ?>/public/img/customer/logo.jpg" alt="Logo">
        </div>
        <div class="logout">
            <button onclick="location.href='<?php echo URLROOT; ?>/User/logout'">Logout</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="sub-container-2">
        <div class="header">
            <div class="user-info">
                <div>
                    <span><?php echo $_SESSION['user_name']; ?></span>
                    <span><?php echo $_SESSION['user_role']; ?></span>
                </div>
                <div>
                    <img src="<?php echo URLROOT; ?>/public/img/customer/admin-profile.png" alt="User Avatar">
                </div>
            </div>
        </div>

        <div class="dashboard">
            <p><i class="fas fa-users"></i>&nbsp; Add Customer</p>
        </div>

        <!-- Add Customer Form -->
        <div class="form-container">
            <form action="<?php echo URLROOT; ?>/Customer/add" method="POST">
                <label for="full_name">Full Name:</label>
                <input 
                    type="text" 
                    id="full_name" 
                    name="full_name" 
                    value="<?php echo $data['full_name']; ?>">
                <span class="form-invalid"><?php echo $data['errors']['full_name'] ?? ''; ?></span>

                <label for="address">Address:</label>
                <input 
                    type="text" 
                    id="address" 
                    name="address" 
                    value="<?php echo $data['address']; ?>">
                <span class="form-invalid"><?php echo $data['errors']['address'] ?? ''; ?></span>

                <label for="contact_no">Contact Number:</label>
                <input 
                    type="text" 
                    id="contact_no" 
                    name="contact_no" 
                    value="<?php echo $data['contact_no']; ?>">
                <span class="form-invalid"><?php echo $data['errors']['contact_no'] ?? ''; ?></span>

                <div class="buttons">
                    <button type="submit" class="add-btn">Add Customer</button>
                    <button type="button" class="cancel-btn" onclick="location.href='<?php echo URLROOT; ?>/Customer'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
