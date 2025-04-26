<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Frostine Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT . '/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-tachometer-alt"></i>&nbsp Dashboard</h1>
                <div class="user-info">
                    <div class="user-profile-header" onclick="window.location.href='<?php echo URLROOT; ?>/headmanager/profile'">
                        <i class="fas fa-user avatar"></i>
                        <span class="role" style="font-weight: normal;">Head Manager</span>
                    </div>
                </div>
            </header>
            <section class="dashboard-content">
                <!-- Metrics Overview -->
                <div class="metrics-container">
                    <div class="metric-card">
                        <h3>Total Cashiers</h3>
                        <p><?php echo number_format($data['totalCashiers']); ?></p>
                    </div>
                    <div class="metric-card">
                        <h3>Total Customers</h3>
                        <p><?php echo number_format($data['totalCustomers']); ?></p>
                    </div>
                    <div class="metric-card">
                        <h3>Total Branch Managers</h3>
                        <p><?php echo number_format($data['totalBranchManagers']); ?></p>
                    </div>
                    <div class="metric-card">
                        <h3>Total Products</h3>
                        <p><?php echo isset($data['totalProducts']) ? number_format($data['totalProducts']) : '25'; ?></p>
                    </div>
                    <div class="metric-card">
                        <h3>Total Orders</h3>
                        <p><?php echo isset($data['totalOrders']) ? number_format($data['totalOrders']) : '120'; ?></p>
                    </div>
                    <div class="metric-card">
                        <h3>Total Revenue</h3>
                        <p>Rs <?php echo isset($data['totalRevenue']) ? number_format($data['totalRevenue'], 2) : '0.00'; ?></p>
                    </div>
                </div>

                <!-- Top Widgets: Clock, Calendar, Sales Chart -->
                <div class="dashboard-top">
                    <!-- Left Column: Clock + Latest Product Feedback -->
                    <div class="left-column">
                        <!-- Clock Widget -->
                        <div class="clock-widget">
                            <!-- Analog Clock Face -->
                            <div class="clock-face">
                                <div class="clock-marking" id="hour-marks">
                                    <!-- Hour marks will be added via JavaScript -->
                                </div>
                                <div class="clock-hand hour-hand" id="hour-hand"></div>
                                <div class="clock-hand minute-hand" id="minute-hand"></div>
                                <div class="clock-hand second-hand" id="second-hand"></div>
                                <div class="clock-center"></div>
                            </div>
                            
                            <!-- Digital Clock Display -->
                            <div id="digital-clock"></div>
                            <div id="current-date"></div>
                        </div>

                        <!-- Latest Product Feedback -->
                        <div class="feedback-widget">
                            <h3>Latest Product Feedback</h3>
                            <div class="feedback-container">
                                <?php if(isset($data['latestFeedbacks']) && !empty($data['latestFeedbacks'])): ?>
                                    <?php foreach($data['latestFeedbacks'] as $feedback): ?>
                                        <div class="feedback-item">
                                            <div class="feedback-product-image">
                                                <img src="<?php echo URLROOT; ?>/public/img/products/<?php echo $feedback->product_image ?? 'default.jpg'; ?>" alt="<?php echo $feedback->product_name; ?>">
                                            </div>
                                            <div class="feedback-content">
                                                <div class="feedback-product-name"><strong>Product:</strong> <?php echo $feedback->product_name; ?></div>
                                                <div class="feedback-customer-name"><strong>Customer:</strong> <?php echo $feedback->customer_name; ?></div>
                                                <div class="feedback-text"><?php echo $feedback->feedback_text; ?></div>
                                                <div class="feedback-meta">
                                                    <div class="feedback-date"><?php echo date('M d, Y', strtotime($feedback->feedback_date)); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="feedback-item">
                                        <div class="feedback-content">
                                            <div class="feedback-text">No product feedback available.</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Widget (Middle) -->
                    <div class="calendar-widget">
                        <div id="calendar"></div>
                    </div>

                    <!-- Right Column: Sales Analysis + Branch Performance -->
                    <div class="right-column">
                        <!-- Sales Analysis -->
                        <div class="sales-widget">
                            <h3 style="color: #5d2e46; margin-bottom: 15px;">Sales Analysis</h3>
                            <canvas id="salesChart"></canvas>
                        </div>
                        
                        <!-- Branch Performance Chart -->
                        <div class="branch-performance">
                            <h2>Branch Performance</h2>
                            <canvas id="branchPerformanceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Best Selling Products -->
                <div class="best-sellers-container">
                    <h2>Best Selling Products</h2>
                    <div class="best-sellers-grid">
                        <?php if(isset($data['bestSellers']) && !empty($data['bestSellers'])): ?>
                            <?php foreach($data['bestSellers'] as $product): ?>
                                <div class="best-seller-card">
                                    <h3><?php echo $product->product_name; ?></h3>
                                    <p class="price">Rs <?php echo number_format($product->price, 2); ?></p>
                                    <p class="sold"><?php echo $product->quantity_sold; ?> units sold</p>
                                    <div class="progress-bar">
                                        <?php 
                                        $maxQuantity = max(array_column($data['bestSellers'], 'quantity_sold'));
                                        $percentage = ($product->quantity_sold / $maxQuantity) * 100;
                                        ?>
                                        <div class="progress" style="width: <?php echo $percentage; ?>%"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="best-seller-card">
                                <h3>No product data available</h3>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="recent-orders-container">
                    <h2>Recent Orders</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Branch</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($data['recentOrders']) && !empty($data['recentOrders'])): ?>
                                <?php foreach($data['recentOrders'] as $order): ?>
                                    <tr>
                                        <td>OID<?php echo $order->order_id; ?></td>
                                        <td><?php echo date('M d, H:i', strtotime($order->order_date)); ?></td>
                                        <td><?php echo $order->items; ?></td>
                                        <td><?php echo $order->branch_name ?? 'N/A'; ?></td>
                                        <td>Rs <?php echo number_format($order->total, 2); ?></td>
                                        <td>
                                            <span class="status <?php echo strtolower($order->payment_status); ?>">
                                                <?php echo $order->payment_status; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">No recent orders available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create hour markers for analog clock
        const hourMarksContainer = document.getElementById('hour-marks');
        for (let i = 0; i < 12; i++) {
            const span = document.createElement('span');
            span.style.transform = `rotate(${i * 30}deg)`;
            hourMarksContainer.appendChild(span);
        }
        
        // Clock Function
        function updateClock() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();
            const milliseconds = now.getMilliseconds();
            
            // Update digital clock
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
            
            // Calculate rotations for analog clock hands
            const hourRotation = 30 * hours + minutes / 2;
            const minuteRotation = 6 * minutes + seconds / 10;
            const secondRotation = 6 * seconds + milliseconds / 166.67;
            
            // Apply rotations to clock hands
            document.getElementById('hour-hand').style.transform = `translateX(-50%) rotate(${hourRotation}deg)`;
            document.getElementById('minute-hand').style.transform = `translateX(-50%) rotate(${minuteRotation}deg)`;
            
            const secondHand = document.getElementById('second-hand');
            secondHand.style.setProperty('--rotation', `${secondRotation}deg`);
            secondHand.style.transform = `translateX(-50%) rotate(${secondRotation}deg)`;
            
            // Add pulse animation to second hand at start of each second
            if (milliseconds < 100) {
                secondHand.style.animation = 'pulse 0.5s ease-in-out';
                setTimeout(() => {
                    secondHand.style.animation = 'none';
                }, 500);
            }
        }
        
        // Initialize and update clock
        updateClock();
        setInterval(updateClock, 50);
        
        // Calendar initialization with order dates
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            height: 'auto',
            events: [
                <?php if(isset($data['orderDates']) && !empty($data['orderDates'])): ?>
                <?php foreach($data['orderDates'] as $date): ?>
                {
                    title: '<?php echo $date->order_count; ?> orders',
                    start: '<?php echo $date->order_day; ?>',
                    backgroundColor: '#a26b98', // Changed from #c98d83 to primary-main
                    borderColor: '#5d2e46', // Changed from #783b31 to primary-dark
                    textColor: 'white',
                    display: 'block',
                    extendedProps: {
                        total: '<?php echo number_format($date->day_total, 2); ?>'
                    }
                },
                <?php endforeach; ?>
                <?php endif; ?>
            ],
            eventDidMount: function(info) {
                const tooltip = document.createElement('div');
                tooltip.classList.add('fc-tooltip');
                // Optional enhancement for the tooltip
                tooltip.innerHTML = `
                    <div style="padding: 5px; background: rgba(0,0,0,0.8); color: white; border-radius: 3px; font-size: 12px;">
                        <span style="color: #f1c778;">${info.event.title}</span><br>
                        Total: Rs ${info.event.extendedProps.total}
                    </div>
                `;
                tooltip.style.position = 'absolute';
                tooltip.style.zIndex = 10000;
                tooltip.style.display = 'none';
                document.body.appendChild(tooltip);

                info.el.addEventListener('mouseover', function() {
                    const rect = info.el.getBoundingClientRect();
                    tooltip.style.display = 'block';
                    tooltip.style.left = rect.right + 'px';
                    tooltip.style.top = rect.top + 'px';
                });

                info.el.addEventListener('mouseout', function() {
                    tooltip.style.display = 'none';
                });
            }
        });
        calendar.render();
        
        // Sales Chart
        const salesData = <?php echo json_encode(isset($data['salesAnalytics']) ? $data['salesAnalytics'] : []); ?>;
        if(salesData.length > 0) {
            const salesLabels = salesData.map(item => item.day);
            const salesValues = salesData.map(item => parseFloat(item.daily_total));
            
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Daily Sales',
                        data: salesValues,
                        backgroundColor: 'rgba(162, 107, 152, 0.2)', // Changed from rgba(201, 141, 131, 0.2)
                        borderColor: '#a26b98', // Changed from #c98d83
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#5d2e46' // Changed from #783b31
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true, // Changed to true
                    aspectRatio: 1.5, // Added aspect ratio
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 10,
                                font: {
                                    size: 10 // Smaller font for legend
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Sales: Rs ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(162, 107, 152, 0.1)' // Changed from rgba(201, 141, 131, 0.1)
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rs ' + value;
                                },
                                font: {
                                    size: 9 // Smaller font for y-axis
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: 9 // Smaller font for x-axis
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Branch Performance Chart
        const branchData = <?php echo json_encode(isset($data['branchPerformance']) ? $data['branchPerformance'] : []); ?>;
        if(branchData.length > 0) {
            const branchLabels = branchData.map(item => item.branch_name);
            const branchValues = branchData.map(item => parseFloat(item.total_sales || 0));
            const branchOrders = branchData.map(item => parseInt(item.order_count || 0));
            
            const branchCtx = document.getElementById('branchPerformanceChart').getContext('2d');
            new Chart(branchCtx, {
                type: 'bar',
                data: {
                    labels: branchLabels,
                    datasets: [{
                        label: 'Total Sales (Rs)',
                        data: branchValues,
                        backgroundColor: 'rgba(162, 107, 152, 0.7)', // Changed from rgba(201, 141, 131, 0.7)
                        borderColor: '#a26b98', // Changed from #c98d83
                        borderWidth: 1,
                        yAxisID: 'y'
                    }, {
                        label: 'Order Count',
                        data: branchOrders,
                        type: 'line',
                        backgroundColor: 'rgba(93, 46, 70, 0.2)', // Changed from rgba(120, 59, 49, 0.2)
                        borderColor: '#5d2e46', // Changed from #783b31
                        borderWidth: 2,
                        pointBackgroundColor: '#5d2e46', // Changed from #783b31
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.3, // More compact aspect ratio
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 8,
                                font: {
                                    size: 9 // Smaller legend text
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 8 // Smaller y-axis labels
                                },
                                callback: function(value) {
                                    return 'Rs ' + value;
                                }
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            ticks: {
                                font: {
                                    size: 8 // Smaller y-axis labels
                                }
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 8 // Smaller x-axis labels
                                }
                            }
                        }
                    }
                }
            });
        }
    });
    </script>
</body>
</html>