<?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/cashierdash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

</head>
<body>
 
    <header>
      <div class="header-container">
        <h7><i class="fas fa-home">&nbsp</i> Dashboard</h7>
        <div class="user-profile-header" onclick="window.location.href='<?php echo URLROOT; ?>/Profile/index'" style="cursor: pointer;">
            <i class="fas fa-user avatar"></i>
            <h7 class="role">Cashier</h7>
        </div>
      </div>
    </header>
    
    <main class="main-content">
        <div class="dashboard-top">
            
            <div class="clock-widget">
                
                <div class="clock-face">
                    <div class="clock-marking" id="hour-marks">
                       
                    </div>
                    <div class="clock-hand hour-hand" id="hour-hand"></div>
                    <div class="clock-hand minute-hand" id="minute-hand"></div>
                    <div class="clock-hand second-hand" id="second-hand"></div>
                    <div class="clock-center"></div>
                </div>
                
                
                <div id="digital-clock"></div>
                <div id="current-date"></div>
            </div>

            
            <div id="calendar"></div>

            
            <div class="analysis-widget">
                <h3>Sales Analysis</h3>
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        
        <div class="metrics-container">
            <div class="metric">
                <h3>Today's Orders</h3>
                <p><?php echo $data['todayOrders']; ?></p>
            </div>
            <div class="metric">
                <h3>Today's Revenue</h3>
                <p>LKR <?php echo number_format($data['todaysRevenue'], 2); ?></p>
            </div>
            
            <div class="metric">
                <h3>Average Order Value</h3>
                <p>LKR <?php echo number_format($data['averageOrderValue'], 2); ?></p>
            </div>
        </div>

        
        <div class="best-sellers-container">
            <h2>Best Selling Products</h2>
            <div class="best-sellers-grid">
                <?php foreach($data['bestSellers'] as $product): ?>
                    <div class="best-seller-card">
                        <div class="best-seller-info">
                            <h3><?php echo $product->product_name; ?></h3>
                            <p class="price">LKR <?php echo number_format($product->price, 2); ?></p>
                            <p class="sold"><?php echo $product->quantity_sold; ?> units sold</p>
                        </div>
                        <div class="best-seller-progress">
                            <div class="progress-bar" style="width: <?php echo min(($product->quantity_sold / 100) * 100, 100); ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

       
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
                            <td>LKR <?php echo number_format($order->total, 2); ?></td>
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
                
                const hourMarksContainer = document.getElementById('hour-marks');
                for (let i = 0; i < 12; i++) {
                    const span = document.createElement('span');
                    span.style.transform = `rotate(${i * 30}deg)`;
                    hourMarksContainer.appendChild(span);
                }
                
                
                function updateClock() {
                    const now = new Date();
                    const hours = now.getHours();
                    const minutes = now.getMinutes();
                    const seconds = now.getSeconds();
                    const milliseconds = now.getMilliseconds();
                    
                    
                    const period = hours >= 12 ? 'PM' : 'AM';
                    const hours12 = hours % 12 || 12;
                    
                    document.getElementById('digital-clock').innerHTML = 
                        `${String(hours12).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')} <span class="clock-period">${period}</span>`;
                    
                    document.getElementById('current-date').textContent = 
                        now.toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    
                    
                    const hourRotation = 30 * hours + minutes / 2;
                    const minuteRotation = 6 * minutes + seconds / 10;
                    const secondRotation = 6 * seconds + milliseconds / 166.67;
                    
                    
                    document.getElementById('hour-hand').style.transform = `translateX(-50%) rotate(${hourRotation}deg)`;
                    document.getElementById('minute-hand').style.transform = `translateX(-50%) rotate(${minuteRotation}deg)`;
                    
                    const secondHand = document.getElementById('second-hand');
                    secondHand.style.setProperty('--rotation', `${secondRotation}deg`);
                    secondHand.style.transform = `translateX(-50%) rotate(${secondRotation}deg)`;
                    
                    
                    if (milliseconds < 100) {
                        secondHand.style.animation = 'pulse 0.5s ease-in-out';
                        setTimeout(() => {
                            secondHand.style.animation = 'none';
                        }, 500);
                    }
                }

                
                var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                    initialView: 'dayGridMonth',
                    height: 350, 
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
                setInterval(updateClock, 50); 

                
                const salesData = <?php echo json_encode($data['salesAnalytics']); ?>;
                const labels = salesData.map(item => item.day);
                const values = salesData.map(item => parseFloat(item.daily_total));

                
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Daily Sales (LKR)',
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
                                        return 'LKR ' + context.parsed.y.toFixed(2);
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
                                        return 'LKR ' + value;
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
