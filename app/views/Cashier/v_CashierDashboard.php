<?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/cashierdash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
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
        <h7><i class="fas fa-home">&nbsp</i> <?php echo $_SESSION['user_id'];  ?>Dashboard</h7>
        <div class="user-profile-header">
          <i class="fas fa-user avatar"></i>
          <h7 class="role">Cashier</h7>
        </div>
      </div>
    </header>
    
    <main class="main-content">
        <div class="dashboard-top">
            <!-- Clock Widget -->
            <div class="clock-widget">
                <div id="digital-clock"></div>
                <div id="current-date"></div>
            </div>

            <!-- Calendar Widget - Single div structure -->
            <div id="calendar"></div>

            <!-- Analysis Widget -->
            <div class="analysis-widget">
                <h3>Sales Analysis</h3>
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Metrics Container -->
        <div class="metrics-container">
            <div class="metric">
                <h3>Total Orders</h3>
                <p><?php echo $data['totalOrders']; ?></p>
            </div>
            <div class="metric">
                <h3>Today's Revenue</h3>
                <p>Rs <?php echo number_format($data['totalRevenue'], 2); ?></p>
            </div>
            <div class="metric">
                <h3>Pending Orders</h3>
                <p>0</p>
            </div>
            <div class="metric">
                <h3>Average Order Value</h3>
                <p>Rs <?php echo $data['totalOrders'] > 0 ? number_format($data['totalRevenue'] / $data['totalOrders'], 2) : '0.00'; ?></p>
            </div>
        </div>

        <!-- Best Sellers Box -->
        <div class="best-sellers-container">
            <h2>Best Selling Products</h2>
            <div class="best-sellers-grid">
                <?php foreach($data['bestSellers'] as $product): ?>
                    <div class="best-seller-card">
                        <div class="best-seller-info">
                            <h3><?php echo $product->product_name; ?></h3>
                            <p class="price">Rs <?php echo number_format($product->price, 2); ?></p>
                            <p class="sold"><?php echo $product->quantity_sold; ?> units sold</p>
                        </div>
                        <div class="best-seller-progress">
                            <div class="progress-bar" style="width: <?php echo min(($product->quantity_sold / 100) * 100, 100); ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="recent-orders">
            <h2>Recent Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['recentOrders'] as $order): ?>
                        <tr>
                            <td>OID<?php echo $order->order_id; ?></td>
                            <td><?php echo date('M d, H:i', strtotime($order->order_date)); ?></td>
                            <td><?php echo $order->items; ?></td>
                            <td>Rs <?php echo number_format($order->total, 2); ?></td>
                            <td>
                                <span class="status <?php echo strtolower($order->payment_status); ?>">
                                    <?php echo $order->payment_status; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Clock Function
                function updateClock() {
                    const now = new Date();
                    document.getElementById('digital-clock').textContent = 
                        now.toLocaleTimeString('en-US', { 
                            hour12: false,
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
                    document.getElementById('current-date').textContent = 
                        now.toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                }

                // Initialize Calendar
                var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                    initialView: 'dayGridMonth',
                    height: 350, // Reduced height
                    headerToolbar: {
                        left: 'prev',
                        center: 'title',
                        right: 'next'
                    },
                    dayMaxEvents: 1,
                    aspectRatio: 1.2
                });
                
                calendar.render();
                updateClock();
                setInterval(updateClock, 1000);

                // Process sales data
                const salesData = <?php echo json_encode($data['salesAnalytics']); ?>;
                const labels = salesData.map(item => item.day);
                const values = salesData.map(item => parseFloat(item.daily_total));

                // Initialize Sales Chart
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Daily Sales (Rs)',
                            data: values,
                            borderColor: '#c98d83',
                            tension: 0.4,
                            fill: true,
                            backgroundColor: 'rgba(201, 141, 131, 0.1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Rs ' + context.parsed.y.toFixed(2);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rs ' + value;
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });
        </script>
    </main>
</body>
</html>
