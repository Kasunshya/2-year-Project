<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/branchmdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Debug output - Remove after debugging -->
    <?php 
        // Uncomment to see what data is available
        // echo '<pre>' . print_r($data, true) . '</pre>'; 
    ?>
    
    <header>
      <div class="header-container">
        <h7> <i class="fas fa-home">&nbsp</i>Dashboard</h7>
        <div class="user-profile-header" onclick="window.location.href='<?php echo URLROOT; ?>/Profile/index'" style="cursor: pointer;">
          <i class="fas fa-user avatar"></i>
          <h7 class="username"><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?></h7>
          <h7 class="role">Branch Manager</h7>
        </div>
      </div>
    </header>

    <!-- Time and Calendar Section - Moved to top -->
    <div class="datetime-container">
        <div class="clock-card">
            <i class="fas fa-clock"></i>
            <div class="clock-container">
                <div class="clock-face">
                    <div class="hand hour-hand" id="hour-hand"></div>
                    <div class="hand minute-hand" id="minute-hand"></div>
                    <div class="hand second-hand" id="second-hand"></div>
                    <div class="center-point"></div>
                </div>
            </div>
            <div class="time-display" id="digital-time">00:00:00</div>
        </div>
        <div class="calendar-card">
            <i class="fas fa-calendar-alt"></i>
            <div class="calendar-header">
                <button id="prev-month">&lt;</button>
                <span class="month-year" id="month-year">January 2023</span>
                <button id="next-month">&gt;</button>
            </div>
            <div id="calendar-container">
                <!-- Calendar will be inserted here by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Summary Metrics -->
    <div class="metrics-container">
        <div class="metric">
            <i class="fas fa-shopping-cart fa-2x"></i>
            <h3>Today's Sales</h3>
            <p>Rs. 1,500.50</p> <!-- Hardcoded value for now -->
        </div>
        <div class="metric">
            <i class="fas fa-receipt fa-2x"></i>
            <h3>Today's Orders</h3>
            <p>5</p> <!-- Hardcoded value for now -->
        </div>
        <div class="metric">
            <i class="fas fa-chart-line fa-2x"></i>
            <h3>Weekly Sales</h3>
            <p>Rs. 9,750.75</p> <!-- Hardcoded value for now -->
        </div>
        <div class="metric">
            <i class="fas fa-box fa-2x"></i>
            <h3>Products in Stock</h3>
            <p><?php echo isset($data['stockMetrics']) && isset($data['stockMetrics']->total_products) 
                ? $data['stockMetrics']->total_products 
                : '0'; ?></p>
        </div>
    </div>

    <script>
        // Clock functionality
        function updateClock() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();
            
            // Calculate rotation angles
            const hourDeg = 30 * (hours % 12) + minutes / 2;
            const minuteDeg = 6 * minutes;
            const secondDeg = 6 * seconds;
            
            // Apply rotations
            document.getElementById('hour-hand').style.transform = `translateX(-50%) rotate(${hourDeg}deg)`;
            document.getElementById('minute-hand').style.transform = `translateX(-50%) rotate(${minuteDeg}deg)`;
            document.getElementById('second-hand').style.transform = `translateX(-50%) rotate(${secondDeg}deg)`;
            
            // Update digital time
            document.getElementById('digital-time').textContent = 
                `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        // Calendar functionality
        let currentDate = new Date();
        
        function generateCalendar(year, month) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startDayIndex = firstDay.getDay(); // 0 for Sunday
            
            const today = new Date();
            const isCurrentMonth = today.getMonth() === month && today.getFullYear() === year;
            
            let calendarHTML = '<table class="calendar"><thead><tr>';
            const daysOfWeek = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
            
            for (let day of daysOfWeek) {
                calendarHTML += `<th>${day}</th>`;
            }
            
            calendarHTML += '</tr></thead><tbody><tr>';
            
            // Add empty cells for days before the first day of the month
            for (let i = 0; i < startDayIndex; i++) {
                calendarHTML += '<td></td>';
            }
            
            // Add cells for each day of the month
            let dayCount = startDayIndex;
            for (let i = 1; i <= daysInMonth; i++) {
                if (dayCount % 7 === 0 && dayCount !== 0) {
                    calendarHTML += '</tr><tr>';
                }
                
                const isToday = isCurrentMonth && today.getDate() === i;
                const todayClass = isToday ? 'today' : '';
                
                calendarHTML += `<td class="${todayClass}">${i}</td>`;
                dayCount++;
            }
            
            // Add empty cells for the remaining days in the last row
            while (dayCount % 7 !== 0) {
                calendarHTML += '<td></td>';
                dayCount++;
            }
            
            calendarHTML += '</tr></tbody></table>';
            
            document.getElementById('calendar-container').innerHTML = calendarHTML;
            document.getElementById('month-year').textContent = 
                new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        }
        
        function updateCalendar() {
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }
        
        document.getElementById('prev-month').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateCalendar();
        });
        
        document.getElementById('next-month').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendar();
        });
        
        // Initialize clock and calendar
        updateClock();
        setInterval(updateClock, 1000);
        updateCalendar();
    </script>
</body>
</html>
