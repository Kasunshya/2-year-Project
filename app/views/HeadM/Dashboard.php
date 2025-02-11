<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT . '/views/HeadM/inc/sidebar.php'; ?>
        

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-tachometer-alt"></i>&nbsp DASHBOARD</h1>
                <div>
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <section class="dashboard-content">
                <div class="overview">
                    <div class="card">
                        <h2><?php echo $data['totalCashiers']; ?></h2>
                        <p>Total Cashiers</p>
                    </div>
                    <div class="card">
                        <h2>120</h2>
                        <p>Total Orders</p>
                    </div>
                    <div class="card">
                        <h2>35</h2>
                        <p>Inventory Items</p>
                    </div>
                </div>
                <div class="overview">
                    <div class="card">
                        <h2><?php echo $data['totalCustomers']; ?></h2>
                        <p>Total Customers</p>
                    </div>
                    <div class="card">
                        <h2>25</h2>
                        <p>Total Products</p>
                    </div>
                    <div class="card">
                        <h2><?php echo $data['totalBranchManagers']; ?></h2>
                        <p>Total Branch Managers</p>
                    </div>
                </div>

                <div class="overview">
                    <div class="charts">
                        <div class="chart">
                            <h2>Sales Overview</h2>
                            <canvas id="salesChart"></canvas>
                        </div>
                        <div class="chart calendar-container">
                            <h2>Calendar</h2>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/Dashboard.js"></script>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</html>