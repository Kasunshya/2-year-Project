<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Admin Dashboard</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/bakery-design-system.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SysAdmin/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <style>

.header {
          background-color: #5d2e46;
          padding: 2rem;
          text-align: center;
          color: var(--white);
          font-size: 2.5rem;
          text-transform: uppercase;
          margin-top: 10px;
          margin-left: 120px;
          margin-right: 20px;
          border-radius: 5px;
          width: 90%;
}

        /* Dashboard-specific styles */
        .dashboard-content {
            padding: var(--space-md);
            width: 100%;
        }
        
        .time-calendar-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: var(--space-lg);
            margin-bottom: var(--space-lg);
            min-width: 1000px;
        }
        
        .overview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: var(--space-lg);
            min-width: 1000px;
        }
        
        .card {
            background-color: var(--neutral-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .stats-card {
            display: flex;
            padding: var(--space-lg);
            position: relative;
        }
        
        .card-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: var(--radius-lg);
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-size: 1.5rem;
            margin-right: var(--space-md);
            flex-shrink: 0;
        }
        
        .card-content {
            flex: 1;
        }
        
        .card-title {
            font-size: 0.875rem;
            color: var(--neutral-dark);
            margin-bottom: var(--space-xs);
        }
        
        .card-content h2 {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin: var(--space-xs) 0;
        }
        
        .card-subtitle {
            font-size: 0.75rem;
            color: var(--neutral-gray);
        }
        
        .time-card {
            padding: var(--space-lg);
            display: flex;
            align-items: center;
        }
        
        .clock-display {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: var(--space-sm) 0;
        }
        
        .calendar-card {
            padding: var(--space-lg);
        }
        
        .calendar-container h2 {
            margin-top: 0;
            margin-bottom: var(--space-md);
            color: var(--primary-dark);
            font-size: 1.25rem;
            font-weight: 600;
        }
        
        /* Customize flatpickr calendar */
        .flatpickr-calendar {
            box-shadow: none !important;
            border: 1px solid var(--neutral-light);
            border-radius: var(--radius-md);
            width: 100% !important;
            padding: var(--space-sm);
        }
        
        .flatpickr-day.selected {
            background: var(--primary-main) !important;
            border-color: var(--primary-main) !important;
        }
        
        .flatpickr-day.today {
            border-color: var(--primary-light) !important;
        }
        
        .flatpickr-day:hover {
            background: var(--primary-light) !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .time-calendar-container {
                grid-template-columns: 1fr;
            }
            
            .overview {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }
        
        @media (max-width: 576px) {
            .stats-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .card-icon {
                margin-right: 0;
                margin-bottom: var(--space-md);
            }
        }
        
        /* Add entrance animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeIn {
            animation: fadeInUp 0.5s ease forwards;
        }
        
        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }
        .stats-card:nth-child(4) { animation-delay: 0.4s; }
        .stats-card:nth-child(5) { animation-delay: 0.5s; }

        /* Fix content width to match other pages */
        .content {
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: var(--space-md);
        }

        /* Add container with overflow for mobile responsiveness */
        .table-container {
            margin: var(--space-lg) 0;
            overflow-x: auto;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
        }

        /* Fix container padding and margin */
        .container {
            width: 100%;
            min-height: 100vh;
            position: relative;
            padding-left: 65px;
            transition: padding-left 0.3s ease;
        }

        .sidebar.expanded + .container {
            padding-left: 220px;
        }

        /* Add this media query for better mobile support */
        @media (max-width: 768px) {
            .container {
                padding-left: 0;
            }
            
            .sidebar.expanded + .container {
                padding-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Add this right after <body> in each SysAdmin page -->
    <div class="sysadmin-page-container">
        <div class="container">
            <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

            <header class="header">
                <div class="header-left">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard Overview</span>
                </div>
                <div class="header-role">
                    <div class="header-role-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span>System Administrator</span>
                </div>
            </header>

            <div class="content">
                <section class="dashboard-content">
                    <!-- Time and Calendar Section -->
                    <div class="time-calendar-container">
                        <div class="card time-card animate-fadeIn">
                            <div class="card-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="card-content">
                                <p class="card-title">Current Time</p>
                                <h2 id="digital-clock" class="clock-display">00:00:00</h2>
                                <p class="card-subtitle">Local Time</p>
                            </div>
                        </div>

                        <div class="card calendar-card animate-fadeIn">
                            <div class="calendar-container">
                                <h2>Calendar</h2>
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="overview">
                        <div class="card stats-card animate-fadeIn">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-content">
                                <p class="card-title">Total Customers</p>
                                <h2><?php echo isset($data['totalCustomers']) ? number_format($data['totalCustomers']) : '0'; ?></h2>
                                <p class="card-subtitle">Registered Users</p>
                            </div>
                        </div>

                        <div class="card stats-card animate-fadeIn">
                            <div class="card-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="card-content">
                                <p class="card-title">Active Staff</p>
                                <h2><?php echo isset($data['totalEmployees']) ? number_format($data['totalEmployees']) : '0'; ?></h2>
                                <p class="card-subtitle">Active Employees</p>
                            </div>
                        </div>

                        <div class="card stats-card animate-fadeIn">
                            <div class="card-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="card-content">
                                <p class="card-title">Categories</p>
                                <h2><?php echo isset($data['totalCategories']) ? number_format($data['totalCategories']) : '0'; ?></h2>
                                <p class="card-subtitle">Product Categories</p>
                            </div>
                        </div>

                        <div class="card stats-card animate-fadeIn">
                            <div class="card-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="card-content">
                                <p class="card-title">Products</p>
                                <h2><?php echo isset($data['totalProducts']) ? number_format($data['totalProducts']) : '0'; ?></h2>
                                <p class="card-subtitle">Active Products</p>
                            </div>
                        </div>

                        <div class="card stats-card animate-fadeIn">
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
            </div>
        </div>
    </div>

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
        
        // Apply staggered animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        });
    </script>
</body>
</html>