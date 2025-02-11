<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SystemAdmin/SideNavBar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SystemAdmin/systemadmindashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

        <header class="header">
            <div class="header-left">
                <i class="fas fa-th"></i>
                <span>Dashboard</span>
            </div>
            <div class="header-role">
                <span>System Administrator</span>
            </div>
        </header>

        <main>
            <section class="dashboard-content">
                <div class="overview">
                    <div class="card">
                        <h2>50</h2>
                        <p>Total Users</p>
                    </div>
                    <div class="card">
                        <h2>120</h2>
                        <p>Total Orders</p>
                    </div>
                    <div class="card">
                        <h2>15</h2>
                        <p>Pending Tasks</p>
                    </div>
                    <div class="card">
                        <h2>35</h2>
                        <p>Inventory Items</p>
                    </div>
                    <div class="card">
                        <h2>10</h2>
                        <p>Feedback Pending</p>
                    </div>
                    <div class="card">
                        <h2>5</h2>
                        <p>Customization Requests</p>
                    </div>
                </div>

                <div class="charts">
                    <div class="chart">
                        <h2>Activity Overview</h2>
                        <canvas id="activityChart"></canvas>
                    </div>
                    <div class="chart calendar-container">
                        <h2>Calendar</h2>
                        <div id="calendar"></div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/SystemAdmin/Dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
