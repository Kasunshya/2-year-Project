<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/DailyOrder.css">
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
            <h1>Daily Requirements</h1>
                <form action="<?php echo URLROOT ;?>/BranchM/DailyOrder" method="POST">
                    <label for="branchid">Branch ID:</label>
                    <input type="text" id="branchid" name="branchid" value="<?php echo $data['branchid'];?>">
                    <span class="form-invalid"><?php echo $data['branchid_err'];?></span>

                    <label for="branchname">Branch Name:</label>
                    <input type="text" id="branchname" name="branchname" value="<?php echo $data['branchname'];?>">
                    <span class="form-invalid"><?php echo $data['branchname_err'];?></span>

                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="<?php echo $data['date'];?>">
                    <span class="form-invalid"><?php echo $data['date_err'];?></span>

                    <label for="orderdescription">Order Description:</label>
                    <textarea id="orderdescription" name="orderdescription" value="<?php echo $data['orderdescription'];?>"></textarea>
                    <span class="form-invalid"><?php echo $data['orderdescription_err'];?></span>

                    <button type="submit" class="submit-btn">Submit</button>
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
