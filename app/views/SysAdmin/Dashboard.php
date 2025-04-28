<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Admin Dashboard</title>
    <?php require APPROOT.'/views/SysAdmin/SideNavBar.php'?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    <style>
        body {
            background-color: #f8e5f4;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            width: 90%;
            margin-left: 120px;
            margin-right: 30px;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #5d2e46;
            padding: 2rem;
            margin-left: 120px;
            margin-right: 20px;
            border-radius: 5px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 2.5rem;
        }
   
}

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .user-profile-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .user-profile-header:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .user-profile-header .avatar {
            font-size: 1.5rem;
            color: white;
        }

        .user-profile-header .role {
            font-size: 1rem;
            color: #e8d7e5;  /* Changed from white to #e8d7e5 */
            text-transform: none;
        }

        .dashboard-top {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 2rem;
            padding: 0;
        }

        .clock-widget {
            background: white;
            border-radius: 15px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.03),
                        -5px -5px 10px rgba(255, 255, 255, 0.5);
            padding: 25px;
            text-align: center;
            width: 320px;
            height: 320px;
        }

        .clock-face {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto 10px;
            border-radius: 50%;
            background: linear-gradient(145deg, #f0e6e3, #fff);
            box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.05),
                        inset -5px -5px 10px rgba(255, 255, 255, 0.8),
                        5px 5px 10px rgba(0, 0, 0, 0.03);
        }

        #calendar {
            flex: 1;
            min-width: 400px;
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            height: 320px !important;
        }

        .analysis-widget {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            height: 320px;
            width: 320px;
        }

        .metrics-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 20px 140px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .metric {
            background: linear-gradient(135deg, #fff 0%, #e8d7e5 100%);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            border-left: 6px solid #a26b98;
            transition: all 0.3s ease;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .metric:hover {
            transform: translateY(-10px);
            border-left: 6px solid #f1c778;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .metric h3 {
            color: #5d2e46;
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .metric p {
            color: #b06f42;
            font-size: 2.5rem;
            font-weight: bold;
            margin: 15px 0 0;
        }

        .metric i {
            font-size: 2rem;
            color: #a26b98;
            margin-bottom: 15px;
        }

        .stats-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .card-icon {
            background-color: #a26b98;
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
        }

        .overview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 140px;
        }

        /* Clock hand styles */
        .clock-hand {
            position: absolute;
            bottom: 50%;
            left: 50%;
            transform-origin: bottom;
            z-index: 5;
        }

        .hour-hand {
            width: 6px;
            height: 50px;
            background: #783b31;
            border-radius: 3px;
        }

        .minute-hand {
            width: 4px;
            height: 70px;
            background: #a96c60;
            border-radius: 2px;
        }

        .second-hand {
            width: 2px;
            height: 80px;
            background: #c98d83;
            border-radius: 1px;
        }

        .clock-center {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 12px;
            height: 12px;
            background: #c98d83;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        #digital-clock {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            color: #5d2e46;
            margin: 10px 0;
        }

        #current-date {
            color: #666;
            font-size: 1rem;
        }

        @media (max-width: 1200px) {
            .metrics-container {
                margin: 20px;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 992px) {
            .dashboard-top {
                flex-direction: column;
                align-items: center;
            }

            .metrics-container {
                flex-direction: column;
                margin: 20px;
            }

            .metric {
                width: auto;
            }
        }

        @media (max-width: 768px) {
            .metric {
                padding: 1.5rem;
                min-height: 150px;
            }
            
            .metric h3 {
                font-size: 1.2rem;
            }
            
            .metric p {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="title">
            <h7><i class="fas fa-th-large"></i>Dashboard</h7>
        </div>
        <div class="user-profile-header" onclick="window.location.href='<?php echo URLROOT; ?>/SysAdminP/profile'" style="cursor: pointer;">
            <i class="fas fa-user-shield avatar"></i>
            <h7 class="role">SYSTEM ADMINISTRATOR</h7>
        </div>
    </header>

    <div class="dashboard-container">
        <div class="dashboard-top">
            <div class="clock-widget">
                <div class="clock-face">
                    <div class="clock-hand hour-hand"></div>
                    <div class="clock-hand minute-hand"></div>
                    <div class="clock-hand second-hand"></div>
                    <div class="clock-center"></div>
                </div>
                <div id="digital-clock">00:00:00</div>
                <p id="current-date"></p>
            </div>
            <div id="calendar"></div>
        </div>

        <div class="metrics-container">
            <div class="metric">
                <i class="fas fa-users"></i>
                <h3>Total Customers</h3>
                <p><?php echo number_format($data['totalCustomers']); ?></p>
            </div>
            <div class="metric">
                <i class="fas fa-user-tie"></i>
                <h3>Active Staff</h3>
                <p><?php echo number_format($data['totalEmployees']); ?></p>
            </div>
            <div class="metric">
                <i class="fas fa-tags"></i>
                <h3>Categories</h3>
                <p><?php echo number_format($data['totalCategories']); ?></p>
            </div>
            <div class="metric">
                <i class="fas fa-box"></i>
                <h3>Products</h3>
                <p><?php echo number_format($data['totalProducts']); ?></p>
            </div>
            <div class="metric">
                <i class="fas fa-store"></i>
                <h3>Active Branches</h3>
                <p><?php echo number_format($data['activeBranches']); ?></p>
            </div>
        </div>
    </div>

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
            
            document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const secondHand = document.querySelector('.second-hand');
            const minuteHand = document.querySelector('.minute-hand');
            const hourHand = document.querySelector('.hour-hand');

            const seconds = now.getSeconds();
            const minutes = now.getMinutes();
            const hours = now.getHours();

            const secondDegree = ((seconds / 60) * 360) + 90;
            const minuteDegree = ((minutes / 60) * 360) + ((seconds / 60) * 6) + 90;
            const hourDegree = ((hours / 12) * 360) + ((minutes / 60) * 30) + 90;

            secondHand.style.transform = `rotate(${secondDegree}deg)`;
            minuteHand.style.transform = `rotate(${minuteDegree}deg)`;
            hourHand.style.transform = `rotate(${hourDegree}deg)`;
        }

        setInterval(updateClock, 1000);
        updateClock();

        // Initialize calendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });
    </script>
</body>
</html>