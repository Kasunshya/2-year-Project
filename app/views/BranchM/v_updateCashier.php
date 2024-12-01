<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/updateCashier.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<body>
    <!-- Sidebar ->
    <aside class="sidebar">
        <div class="logo-container">
        <img src="<--?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
        </div>
        <nav>
        <ul>
                <li><a href="<--?php echo URLROOT;?>/BranchM/branchmdashboard"><i class="fas fa-home"></i></a></li>
                <li><a href="<--?php echo URLROOT;?>/BranchM/viewCashiers"><i class="fas fa-boxes"></i></a></li>
                <li><a href="<--?php echo URLROOT;?>/BranchM/addCashier"><i class="fas fa-edit"></i></a></li>
                <li><a href="<--?php echo URLROOT;?>/BranchM/DailyOrder"><i class="fas fa-tasks"></i></a></li>
                <li><a href="<--?php echo URLROOT;?>/BranchM/salesReport"><i class="fas fa-chart-bar"></i></a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </aside-->
    <header>
      <div class="header-container">
        <h7>UPDATE CASHIER</h7>
        
      </div>
    </header>
    <div class="form-container">
            <?php if (!empty($data['error_message'])): ?>
        <div class="error-message"><?php echo $data['error_message']; ?></div>
    <?php endif; ?>
    <form action="<?php echo URLROOT; ?>/BranchM/updateCashierSubmit/<?php echo htmlspecialchars($data['cashier_id']); ?>" method="POST">

    <label for="name">Name</label>
    <input type="text" name="cashier_name" value="<?php echo isset($data['cashier_name']) ? htmlspecialchars($data['cashier_name']) : ''; ?>" required>

    <label for="address">Address</label>
    <input type="text" name="address" value="<?php echo isset($data['address']) ? htmlspecialchars($data['address']) : ''; ?>" required>
    
    <label for="contact">Contact</label>
    <input type="text" name="contact" value="<?php echo isset($data['contacts']) ? htmlspecialchars($data['contacts']) : ''; ?>" required>

    <label for="join_date">Join Date</label>
    <input type="date" name="join_date" value="<?php echo isset($data['join_date']) ? htmlspecialchars($data['join_date']) : ''; ?>" required>
    
    <label for="branch_name">Branch Name</label>
    <input type="text" name="branch_name" value="<?php echo isset($data['branch_name']) ? htmlspecialchars($data['branch_name']) : ''; ?>" required>
    
    <button type="submit" class="submit-btn">Update Cashier</button>
</form>
</main>
</div>
