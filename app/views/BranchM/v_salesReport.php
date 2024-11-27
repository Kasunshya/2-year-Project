<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/salesReport.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

<main>
<header>  Reports</header>
<div class="report-container">
                <div class="report-card">
                    <img src="<?php echo URLROOT;?>/img/BranchManger/blue.png" alt="Sales Icon" class="report-image">
                    <h3>SALES REPORT</h3>
                    <div class="date-selection">
                <label for="start-date">Starting Date:</label>
                <input type="date" id="start-date">
                
                <label for="end-date">End Date:</label>
                <input type="date" id="end-date">
                
                <button>GO</button>
            </div>
                </div>
                <div class="report-card">
                    <img src="<?php echo URLROOT;?>/img/BranchManger/daily reports.png" alt="Daily Icon" class="report-image">
                    <h3>DAILY REPORT</h3>
                    <div class="date-selection">
                <label for="start-date">Starting Date:</label>
                <input type="date" id="start-date">
                
                <label for="end-date">End Date:</label>
                <input type="date" id="end-date">
                
                <button>GO</button>
            </div>
                </div>
            </div>    
        </div>
    </div>
</div>
</main>
</html>