<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/branchmdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
 
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-container">
            <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
        </div>
        <nav>
        <ul>
        <li><a href="<?php echo URLROOT;?>/BranchM/branchmdashboard"><i class="fas fa-home"></i></a></li>
        <li><a href="<?php echo URLROOT;?>/BranchM/viewCashiers"><i class="fas fa-boxes"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/addCashier"><i class="fas fa-edit"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/DailyOrder"><i class="fas fa-tasks"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/salesReport"><i class="fas fa-chart-bar"></i></a></li>
            </ul>
        </div>
        <div class="logout">
            <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    
    </aside>

    <header>
      <div class="header-container">
        <h7> <i class="fas fa-home">&nbsp</i>Dashboard</h7>
        <div class="user-profile-header">
          <i class="fas fa-user avatar"></i>
          <h7 class="username">John Doe</h7>
          <h7 class="role">Branch Manger</h7>
        </div>
      </div>
    </header>
    <main>
      <div class="chart-container">
          <div class="card">
              <h3 style="color: #783b31;">Sales Performance</h3>
              <canvas id="salesChart"></canvas>
          </div>
          <div class="card">
              <h3 style="color: #783b31;">Revenue Growth</h3>
              <canvas id="revenueChart"></canvas>
          </div>
      </div>

      <div class="metrics-container">
          <div class="metric">
              <h3>Total Sales</h3>
              <p>$2000</p>
          </div>
          <div class="metric">
              <h3>Total Revenue</h3>
              <p>$5000</p>
          </div>
          <div class="metric">
              <h3>Orders Delivered</h3>
              <p>150</p>
          </div>
          <div class="metric">
              <h3>New Customers</h3>
              <p>20</p>
          </div>
      </div>
      <div class="recent-orders">
        <h3 style="color: #783b31;">Recent Orders</h3>
        <table>
            <thead>
                <tr>
                    <th style="color: #783b31;">Order ID</th>
                    <th style="color: #783b31;">Product</th>
                    <th style="color: #783b31;">Customer</th>
                    <th style="color: #783b31;">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#101</td>
                    <td>Chocolate Cake</td>
                    <td>John Doe</td>
                    <td>Delivered</td>
                </tr>
                <tr>
                    <td>#102</td>
                    <td>Wedding Bouquet</td>
                    <td>Jane Smith</td>
                    <td>Pending</td>
                </tr>
            </tbody>
        </table>
    </div>

</main>
</div>

<button class="toggle-theme"></button>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const toggleButton = document.querySelector(".toggle-theme");
toggleButton.addEventListener("click", () => {
  document.body.classList.toggle("dark-mode");
});

// Sales Data for the Sales Performance Chart
const salesData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
        label: "Sales",
        data: [300, 500, 400, 700, 800, 600, 700, 800, 900, 1100, 1200, 1300],
        borderColor: 'rgb(255, 99, 132)',
        fill: false,
        tension: 0.1
    }]
};

// Revenue Data for the Revenue Growth Chart
const revenueData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
        label: "Revenue",
        data: [1000, 1500, 1300, 1700, 1900, 1800, 2100, 2200, 2300, 2500, 2600, 2700],
        borderColor: 'rgb(54, 162, 235)',
        fill: false,
        tension: 0.1
    }]
};

// Create Sales Performance Chart
const salesChart = document.getElementById("salesChart").getContext("2d");
new Chart(salesChart, {
    type: "line",
    data: salesData,
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Create Revenue Growth Chart
const revenueChart = document.getElementById("revenueChart").getContext("2d");
new Chart(revenueChart, {
    type: "line",
    data: revenueData,
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>
