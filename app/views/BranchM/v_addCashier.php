<!--?php require APPROOT.'/views/inc/header.php'?-->
  <!--php require APPROOT.'/views/inc/components/verticalnavbar.php'?-->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/addcashier.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-container">
        <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
        </div>
        <nav>
            <ul>
                <li><a href="<?php echo URLROOT;?>/BranchM/branchmdashboard"><i class="fas fa-home"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/viewCashiers"><i class="fas fa-boxes"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/addCashier"><i class="fas fa-edit"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/DailyOrder"><i class="fas fa-tasks"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/salesReport"><i class="fas fa-chart-bar"></i></a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </aside>
    <header>
      <div class="header-container">
        <h7>ADD CASHIER</h7>
        
        </div>
      </div>
    </header>
    <div class="form-container">
            <?php if (!empty($data['error_message'])): ?>
        <div class="error-message"><?php echo $data['error_message']; ?></div>
    <?php endif; ?>
            <form action="<?php echo URLROOT ;?>/BranchM/addCashier" method="POST">

            <label for="cashier_name">Cashier Name</label>
            <input type="text" name="cashier_name" id="cashier_name" value="<?php echo htmlspecialchars($data['cashier_name']); ?>" required>
            <span><?php echo $data['cashier_name_err'] ?? ''; ?></span>
        
            <label for="contacts">Contacts</label>
            <input type="text" name="contacts" id="contacts" value="<?php echo htmlspecialchars($data['contacts']); ?>" required>
            <span><?php echo $data['contacts_err'] ?? ''; ?></span>

            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($data['address']); ?>" required>
            <span><?php echo $data['address_err'] ?? ''; ?></span>

            <label for="join_date">Join Date</label>
            <input type="date" name="join_date" id="join_date" value="<?php echo htmlspecialchars($data['join_date']); ?>" required>
            <span><?php echo $data['join_date_err'] ?? ''; ?></span>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
            <span><?php echo $data['email_err'] ?? ''; ?></span>

            <label for="branch_name">Branch Name</label>
            <input type="text" name="branch_name" id="branch_name" value="<?php echo htmlspecialchars($data['branch_name']); ?>" required>
            <span><?php echo $data['branch_name_err'] ?? ''; ?></span>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <span><?php echo $data['password_err'] ?? ''; ?></span>

            

                    <div class="buttons">
                        <button type="submit" class="submit-btn" name="ADD">ADD</button>
                    </div>
                </form>
              </main>
            </div>
            <!--div id="successToast" class="toast hidden">
                <p>Successfully Submitted!</p>
            </div>
        </div>
    </div>
    <script>
    function showSuccessToast() {
        const toast = document.getElementById('successToast');
        toast.classList.remove('hidden');
        toast.classList.add('show');

        // Automatically hide the toast after 3 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            toast.classList.add('hidden');
        }, 3000);
    }

    // Show the toast on successful submission
    if (window.location.search.includes('success=true')) {
        showSuccessToast();
    }
</script>