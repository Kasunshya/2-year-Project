<!-- filepath: c:\xampp\htdocs\Bakery\app\views\HeadM\Branch.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['branch']->branch_name); ?> - Branch</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT . '/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-building"></i>&nbsp <?php echo htmlspecialchars($data['branch']->branch_name); ?></h1>
                <div>
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <section class="content">
                <!-- Branch Manager -->

                <div class="table-container">
                
                    <h2>Branch Manager</h2>
                    <?php if (!empty($data['branchManager'])): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Manager ID</th>
                                    <th>Full Name</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo htmlspecialchars($data['branchManager']->branchmanager_id); ?></td>
                                    <td><?php echo htmlspecialchars($data['branchManager']->branchmanager_name); ?></td>
                                    <td><?php echo htmlspecialchars($data['branchManager']->contact_no); ?></td>
                                    <td><?php echo htmlspecialchars($data['branchManager']->email); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No branch manager assigned to this branch.</p>
                    <?php endif; ?>
                </div>

                <!-- Cashiers -->
                <div class="table-container">
                    <h2>Cashiers</h2>
                    <?php if (!empty($data['cashiers'])): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Full Name</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['cashiers'] as $cashier): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($cashier->employee_id); ?></td>
                                        <td><?php echo htmlspecialchars($cashier->full_name); ?></td>
                                        <td><?php echo htmlspecialchars($cashier->contact_no); ?></td>
                                        <td><?php echo htmlspecialchars($cashier->email); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No cashiers assigned to this branch.</p>
                    <?php endif; ?>
                </div>

                <!-- Sales Reports -->
                <div class="table-container">
                    <h2>Sales Reports</h2>

                    <!-- Filter Form -->
                    <form method="GET" action="" class="filter-form">
                        <div class="filter-group">
                            <label for="year">Year:</label>
                            <input type="number" name="year" id="year" placeholder="e.g., 2025" value="<?php echo htmlspecialchars($_GET['year'] ?? ''); ?>">
                        </div>
                        <div class="filter-group">
                            <label for="month">Month:</label>
                            <select name="month" id="month">
                                <option value="">Select Month</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo (isset($_GET['month']) && $_GET['month'] == $i) ? 'selected' : ''; ?>>
                                        <?php echo date('F', mktime(0, 0, 0, $i, 10)); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="date">Date:</label>
                            <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($_GET['date'] ?? ''); ?>">
                        </div>
                        <button type="submit" class="btn filter-btn">Filter</button>
                    </form>

                    <!-- Total Sales -->
                    <div class="total-sales">
                        <h3>Total Sales: $<?php echo number_format($data['totalSales'], 2); ?></h3>
                    </div>

                    <!-- Sales Data -->
                    <?php if (!empty($data['salesData'])): ?>
                        <div class="table-container sales-table">
                            <h2>Sales Data</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Total Sales ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $counter = 0;
                                    foreach ($data['salesData'] as $sales): 
                                        $rowClass = $counter >= 5 ? 'hidden-row' : '';
                                    ?>
                                        <tr class="<?php echo $rowClass; ?>">
                                            <td><?php echo htmlspecialchars($sales->sales_date); ?></td>
                                            <td><?php echo number_format($sales->total_sales, 2); ?></td>
                                        </tr>
                                    <?php 
                                        $counter++;
                                    endforeach; 
                                    ?>
                                </tbody>
                            </table>
                            <?php if (count($data['salesData']) > 5): ?>
                                <button id="viewMoreBtn" class="btn view-more-btn">
                                    View More <i class="fas fa-chevron-down"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p>No sales data available for this branch.</p>
                    <?php endif; ?>

                    <!-- Graphs Section -->
                    <div class="graphs-container">
                        <div class="graph-left">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Print Section for Sales Report -->
            <div class="print-section">
                <div class="invoice-container">
                    <!-- Watermark -->
                    <div class="watermark">FROSTINE</div>
                    
                    <!-- Invoice Header with Logo -->
                    <div class="invoice-header">
                        <div class="invoice-logo">
                            <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
                            <div class="invoice-logo-text">
                                <h1>FROSTINE BAKERY</h1>
                                <p>Branch Sales Report</p>
                            </div>
                        </div>
                        <div class="invoice-title">
                            <h2><?php echo htmlspecialchars($data['branch']->branch_name); ?></h2>
                            <p>Report #BSR-<?php echo date('Ymd'); ?></p>
                        </div>
                    </div>
                    
                    <!-- Branch Information -->
                    <div class="company-info">
                        <div class="company-info-left">
                            <h3>Branch Information</h3>
                            <p>Address: <?php echo htmlspecialchars($data['branch']->branch_address); ?></p>
                            <p>Contact: <?php echo htmlspecialchars($data['branch']->branch_contact); ?></p>
                        </div>
                        <div class="report-info">
                            <p><strong>Report Period:</strong> 
                                <?php 
                                if (!empty($_GET['date'])) {
                                    echo date('d F Y', strtotime($_GET['date']));
                                } elseif (!empty($_GET['month'])) {
                                    echo date('F Y', mktime(0, 0, 0, $_GET['month'], 1));
                                } elseif (!empty($_GET['year'])) {
                                    echo $_GET['year'];
                                } else {
                                    echo 'All Time';
                                }
                                ?>
                            </p>
                            <p><strong>Generated On:</strong> <?php echo date('d F Y, h:i A'); ?></p>
                        </div>
                    </div>

                    <!-- Sales Data Table -->
                    <table class="print-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total Sales (LKR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['salesData'])): ?>
                                <?php foreach ($data['salesData'] as $sales): ?>
                                    <tr>
                                        <td><?php echo date('d F Y', strtotime($sales->sales_date)); ?></td>
                                        <td><?php echo number_format($sales->total_sales, 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">No sales data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Summary Box -->
                    <div class="print-summary">
                        <h3>Sales Summary</h3>
                        <div class="print-summary-row total">
                            <span>Total Sales</span>
                            <span>LKR <?php echo number_format($data['totalSales'], 2); ?></span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="invoice-footer">
                        <p>Generated from Frostine Management System</p>
                        <p>&copy; <?php echo date('Y'); ?> FROSTINE BAKERY - All Rights Reserved</p>
                        <p><small>This is a computer generated document</small></p>
                    </div>
                </div>
            </div>
            <div class="report-actions">
                <button class="btn download-btn" onclick="printSalesReport()">
                    <i class="fas fa-download"></i> Download Report
                </button>
            </div>
        </main>
    </div>

    <script>
        // Bar chart logic remains unchanged
        const salesData = <?php echo json_encode(array_map(function($sales) {
            return [
                'date' => $sales->sales_date,
                'total_sales' => $sales->total_sales
            ];
        }, $data['salesData'])); ?>;

        const labels = salesData.map(sale => sale.date);
        const data = salesData.map(sale => sale.total_sales);

        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Sales ($)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Add this new code for table functionality
        document.addEventListener('DOMContentLoaded', function() {
            const viewMoreBtn = document.getElementById('viewMoreBtn');
            const salesTable = document.querySelector('.sales-table');
            const hiddenRows = document.querySelectorAll('.hidden-row');

            if (viewMoreBtn) {
                viewMoreBtn.addEventListener('click', function() {
                    salesTable.classList.toggle('expanded');
                    hiddenRows.forEach(row => row.classList.toggle('show'));
                    
                    if (salesTable.classList.contains('expanded')) {
                        viewMoreBtn.innerHTML = 'Show Less <i class="fas fa-chevron-up"></i>';
                    } else {
                        viewMoreBtn.innerHTML = 'View More <i class="fas fa-chevron-down"></i>';
                    }
                    viewMoreBtn.classList.toggle('expanded');
                });
            }
        });

        function printSalesReport() {
            document.querySelector('.print-section').style.display = 'block';
            
            setTimeout(() => {
                window.print();
                
                setTimeout(() => {
                    document.querySelector('.print-section').style.display = 'none';
                }, 100);
            }, 300);
        }
    </script>
</body>

</html>