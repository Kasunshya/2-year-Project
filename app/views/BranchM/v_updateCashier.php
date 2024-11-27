<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/updateCashier.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-container">
        <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
        </div>
        <nav>
        <ul>
                <li><a href="<?php echo URLROOT;?>/BranchM/addCashier"><i class="fas fa-home"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/editTable"><i class="fas fa-boxes"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/DailyOrder"><i class="fas fa-edit"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/salesReport"><i class="fas fa-chart-bar"></i></a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </aside>
    <main style="margin-left: 100px; padding: 20px; flex: 1; overflow-y: auto; background-image: url(' <?php echo URLROOT;?>/public/img/BranchManger/background.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
    <div class="form-container">
    <h1>Update Cashier</h1>
    <form action="<?php echo URLROOT; ?>/BranchM/updateCashierSubmit/<?php echo $data['ID']; ?>" method="POST">
    <label for="name">Name</label>
    <input type="text" name="name" value="<?php echo $data['Name']; ?>">
    
    <label for="contact">Contact</label>
    <input type="text" name="contact" value="<?php echo $data['Contact']; ?>">
    
    <label for="address">Address</label>
    <input type="text" name="address" value="<?php echo $data['Address']; ?>" required>
    
    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo $data['Email']; ?>" required>
    
    <label for="join_date">Join Date</label>
    <input type="date" name="join_date" value="<?php echo $data['Join_Date']; ?>" required>
    
    <label for="password">Password</label>
    <input type="password" name="password" value="<?php echo $data['Password']; ?>" required>
    
    <button type="submit" class="submit-btn">Update Cashier</button>
</form>
</main>


</div>
