<?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/cashierdash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

</head>
<body>
 
    <!-- Sidebar >
    <aside class="sidebar">
        <div class="logo-container">
            <img src="<--?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
        </div>
        <nav>
        <ul>
                <li><a href="<--?php echo URLROOT; ?>/Cashier/cashierdashboard"><i class="fas fa-home"></i></a></li>
                <li><a href="<--?php echo URLROOT; ?>/Cashier/servicedesk"><i class="fas fa-boxes"></i></a></li>
                <li><a href="<--?php echo URLROOT; ?>/Cashier/payment"><i class="fas fa-edit"></i></a></li>
                <li><a href="<--?php echo URLROOT; ?>/Cashier/transaction"><i class="fas fa-chart-bar"></i></a></li>
            </ul>
        </nav>

        
        <div class="logout">
            <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </aside-->

    <header>
      <div class="header-container">
        <h7><i class="fas fa-home">&nbsp</i> Dashboard</h7>
        <div class="user-profile-header">
          <i class="fas fa-user avatar"></i>
          <h7 class="role">Cashier</h7>
        </div>
      </div>
    </header>
    
    <div class="chart-container">
      <div class="card">
          <h2>Sales</h2>
          <canvas id="salesChart"></canvas>
          <button onclick="updateSalesChart()">Toggle Sales Data</button>
      </div>
      <div class="card">
    <h2>Calendar</h2>
    <div id="calendar" style="padding: 1rem;"></div>
</div>

      <!--div class="card">
          <h2>Revenue</h2>
          <canvas id="revenueChart"></canvas>
      </div-->
  </div>
  <div class="metrics-container">
    <div class="metric">
      <h3>Total Sales</h3>
      <p>$4,560</p>
    </div>
    <div class="metric">
      <h3>Total Orders</h3>
      <p><?php echo isset($data['totalOrders']) ? $data['totalOrders'] : '0'; ?></p>
    </div>
    <div class="metric">
      <h3>Total Revenue</h3>
      <p>$<?php echo isset($data['totalRevenue']) ? number_format($data['totalRevenue'], 2) : '0.00'; ?></p>
</div>
    <div class="metric">
      <h3>Pending Orders</h3>
      <p>25</p>
    </div>
  </div>
  
  <div class="recent-orders">
    <h2>Recent Orders</h2>
    <table>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer Name</th>
          <th>Time</th>
          <th>Amount</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1001</td>
          <td>John Doe</td>
          <td>10:30 AM</td>
          <td>$45.00</td>
          <td>Completed</td>
        </tr>
        <tr>
          <td>1002</td>
          <td>Jane Smith</td>
          <td>11:00 AM</td>
          <td>$32.50</td>
          <td>Pending</td>
        </tr>
      </tbody>
    </table>
  </div>
  
  
  <button class="toggle-theme" onclick="toggleTheme()"></button>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let salesChart;
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        function initializeSalesChart() {
            salesChart = new Chart(salesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Sales', 'Visits', 'Income', 'Revenue'],
                    datasets: [{
                        data: [2200, 3400, 1800, 2800],
                        backgroundColor: ['#c98d83', '#ffc85c', '#32b09f', '#783b31'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        function updateSalesChart() {
            salesChart.data.datasets[0].data = [1800, 2200, 3000, 2600];
            salesChart.update();
        }

        const themeToggle = document.querySelector(".toggle-theme");
        function toggleTheme() {
            document.body.classList.toggle("dark-mode");
            const rootStyles = document.documentElement.style;
            if (document.body.classList.contains("dark-mode")) {
                rootStyles.setProperty("--bg", "var(--dark-bg)");
                rootStyles.setProperty("--white", "var(--dark-text)");
            } else {
                rootStyles.setProperty("--bg", "#f2f1ec");
                rootStyles.setProperty("--white", "#ffffff");
            }
        }

        initializeSalesChart();
        new Chart(document.getElementById('ordersChart'), {
            type: 'doughnut',
            data: { labels: ['Orders', 'Completed', 'Pending'], datasets: [{ data: [4400, 3500, 900], backgroundColor: ['#32b09f', '#c98d83', '#783b31'] }] }
        });


        document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 380,
            width:380,
            events: [
                { title: 'Pickup Order #1001', date: '2025-04-12' },
                { title: 'Stock Check', date: '2025-04-13' }
            ]
        });
        calendar.render();
    }
});

        
        function filterOrders() {
  const input = document.getElementById("orderSearch").value.toUpperCase();
  const table = document.querySelector(".recent-orders table tbody");
  const rows = table.getElementsByTagName("tr");
  
  for (let i = 0; i < rows.length; i++) {
    const cells = rows[i].getElementsByTagName("td");
    const customer = cells[1].textContent.toUpperCase();
    const orderId = cells[0].textContent.toUpperCase();
    rows[i].style.display = customer.includes(input) || orderId.includes(input) ? "" : "none";
  }
}
// JavaScript to display today's date
function displayDate() {
    const today = new Date();
    const dateString = today.toLocaleDateString('en-US', {
        weekday: 'long', // "Monday"
        year: 'numeric', // "2024"
        month: 'long', // "November"
        day: 'numeric' // "29"
    });

    document.getElementById("current-date").textContent = dateString;
}

// Call the function when the page loads
window.onload = displayDate;


    </script>
