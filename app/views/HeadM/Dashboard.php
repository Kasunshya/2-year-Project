<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Dshboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-container">
                <img src="<?php echo URLROOT; ?>/public/img/HeadM/FrostineLogo2.png" alt="Logo" class="logo">
            </div>
            <nav>
            <ul>
                <li><a href="<?php echo URLROOT; ?>/HeadM/dashboard"><i class="fas fa-tachometer-alt"></i></a></li>
                <li><a href="<?php echo URLROOT; ?>/HeadM/cashierManagement"><i class="fas fa-cash-register icon-cashier"></i></a></li>
                <li><a href="<?php echo URLROOT; ?>/HeadM/supplierManagement"><i class="fas fa-truck"></i></a></li>
                <li><a href="#"><i class="fas fa-birthday-cake"></i></a></li>
                <li><a href="<?php echo URLROOT; ?>/HeadM/inventoryManagement"><i class="fas fa-warehouse icon-inventory"></i></a></li>
                <li><a href="<?php echo URLROOT; ?>/HeadM/branchManager"><i class="fas fa-user-tie icon-branch-manager"></i></a></li>
                <li><a href="#"><i class="fas fa-clipboard-list icon-order"></i></a></li>
            </ul>
            </nav>
            <div class="logout">
                <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </aside>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
                <div class="user-info">
                    <span>Head Manager</span>
            
                </div>
            </header>
            <section class="dashboard-content">
                <div class="overview">
                    <div class="card">
                        <h2>15</h2>
                        <p>Total Employees</p>
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
                        <h2>200</h2>
                        <p>Total Customers</p>
                    </div>
                    <div class="card">
                        <h2>10</h2>
                        <p>Branches</p>
                    </div>
                    <div class="card">
                        <h2>8</h2>
                        <p>Total Suppliers</p>
                    </div>
                </div>

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
            </section>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/Dashboard.js"></script>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</html>
