<!--?php require APPROOT.'/views/inc/header.php'?-->
  <!--php require APPROOT.'/views/inc/components/verticalnavbar.php'?-->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/addcashier.css">
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
            <h1>ADD CASHIER</h1>
                <form action="<?php echo URLROOT ;?>/BranchM/addCashier" method="POST">

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="Name" value="<?php echo $data['Name'];?> ">
                    <span class="form-invalid"><?php echo $data['Name_err'];?></span>

                    <label for="contact">Contact:</label>
                    <input type="text" id="contact" name="Contact" value="<?php echo $data['Contact'];?>">
                    <span class="form-invalid"><?php echo $data['Contact_err'];?></span>

                    <label for="address">Address:</label>
                    <input type="text" id="address" name="Address" value="<?php echo $data['Address'];?>">
                    <span class="form-invalid"><?php echo $data['Address_err'];?></span>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="Email" value="<?php echo $data['Email'];?>">
                    <span class="form-invalid"><?php echo $data['Email_err'];?></span>

                    <label for="join-date">Join Date:</label>
                    <input type="date" id="join_date" name="Join_Date" value="<?php echo $data['Join_Date'];?>">
                    <span class="form-invalid"><?php echo $data['Join_Date_err'];?></span>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="Password" value="<?php echo $data['Password'];?>">
                    <span class="form-invalid"><?php echo $data['Password_err'];?></span>

                    <div class="buttons">
                        <button type="submit" class="submit-btn" name="ADD">ADD</button>
                        <button type="button" class="submit-btn">CANCEL</button>
                    </div>
                </form>
              </main>
            </div>
            <div id="successToast" class="toast hidden">
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