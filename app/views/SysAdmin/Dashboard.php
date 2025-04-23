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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <div class="container">
        <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

        <header class="header">
            <div class="header-left">
                <i class="fas fa-th"></i>
                <span>Dashboard Overview</span>
            </div>
            <div class="header-role">
                <span>System Administrator</span>
            </div>
        </header>

        <main>
            <section class="dashboard-content">
                <!-- Time and Calendar Section -->
                <div class="time-calendar-container">
                    <div class="card time-card animate__animated animate__fadeIn">
                        <div class="card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-content">
                            <p class="card-title">Current Time</p>
                            <h2 id="digital-clock" class="clock-display">00:00:00</h2>
                            <p class="card-subtitle">Local Time</p>
                        </div>
                    </div>

                    <div class="card calendar-card animate__animated animate__fadeIn">
                        <div class="chart calendar-container">
                            <h2>Calendar</h2>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="overview">
                    <div class="card stats-card animate__animated animate__fadeIn">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-content">
                            <p class="card-title">Total Customers</p>
                            <h2><?php echo isset($data['totalCustomers']) ? number_format($data['totalCustomers']) : '0'; ?></h2>
                            <p class="card-subtitle">Registered Users</p>
                        </div>
                    </div>

                    <div class="card stats-card animate__animated animate__fadeIn">
                        <div class="card-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="card-content">
                            <p class="card-title">Active Staff</p>
                            <h2><?php echo isset($data['totalEmployees']) ? number_format($data['totalEmployees']) : '0'; ?></h2>
                            <p class="card-subtitle">Active Employees</p>
                        </div>
                    </div>

                    <div class="card stats-card animate__animated animate__fadeIn">
                        <div class="card-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="card-content">
                            <p class="card-title">Categories</p>
                            <h2><?php echo isset($data['totalCategories']) ? number_format($data['totalCategories']) : '0'; ?></h2>
                            <p class="card-subtitle">Product Categories</p>
                        </div>
                    </div>

                    <div class="card stats-card animate__animated animate__fadeIn">
                        <div class="card-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="card-content">
                            <p class="card-title">Products</p>
                            <h2><?php echo isset($data['totalProducts']) ? number_format($data['totalProducts']) : '0'; ?></h2>
                            <p class="card-subtitle">Active Products</p>
                        </div>
                    </div>

                    <div class="card stats-card animate__animated animate__fadeIn">
                        <div class="card-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="card-content">
                            <p class="card-title">Branches</p>
                            <h2><?php echo isset($data['activeBranches']) ? number_format($data['activeBranches']) : '0'; ?></h2>
                            <p class="card-subtitle">Active Locations</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="<?php echo URLROOT; ?>/public/js/SystemAdmin/Dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize clock
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString('en-US', { 
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('digital-clock').textContent = time;
        }

        setInterval(updateClock, 1000);
        updateClock();

        // Initialize calendar
        flatpickr("#calendar", {
            inline: true,
            enableTime: false,
            dateFormat: "Y-m-d",
            defaultDate: "today"
        });
    </script>
</body>
</html>