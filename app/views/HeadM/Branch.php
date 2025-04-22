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
    <style>
        @media print {
            body > *:not(.print-section) {
                display: none;
            }
            .print-section {
                display: block !important;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 0;
                margin: 0;
                background-color: white;
            }
            .print-table {
                page-break-inside: avoid;
            }
            .no-print {
                display: none;
            }
        }
        
        .print-section {
            display: none;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: white;
            color: #333;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 8.5in;
            margin: 0 auto;
        }

        .invoice-container {
            padding: 40px;
            position: relative;
            border: 1px solid #eaeaea;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #783b31;
            padding-bottom: 20px;
        }
        
        .invoice-logo {
            display: flex;
            align-items: center;
        }
        
        .invoice-logo img {
            height: 60px;
        }
        
        .invoice-logo-text {
            margin-left: 15px;
        }
        
        .invoice-logo-text h1 {
            font-size: 24px;
            color: #783b31;
            margin: 0;
        }
        
        .invoice-logo-text p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #888;
        }
        
        .invoice-title {
            flex-grow: 0;
            text-align: right;
        }
        
        .invoice-title h2 {
            font-size: 28px;
            color: #783b31;
            margin: 0 0 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .company-info {
            text-align: left;
            margin-bottom: 30px;
            padding: 0;
            border-bottom: none;
            display: flex;
            justify-content: space-between;
        }
        
        .company-info-left {
            flex: 1;
        }
        
        .company-info-left h3 {
            font-size: 18px;
            color: #783b31;
            margin: 0 0 10px;
        }
        
        .report-info {
            flex: 1;
            text-align: right;
        }
        
        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            border: 1px solid #dee2e6;
        }
        
        .print-table th {
            background-color: #f8f9fa;
            color: #495057;
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-weight: 600;
        }
        
        .print-table td {
            padding: 10px 12px;
            border: 1px solid #dee2e6;
            color: #333;
        }
        
        .print-summary {
            margin: 30px 0;
            background: #f9f9f9;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 20px;
            width: 350px;
            float: right;
        }
        
        .print-summary h3 {
            text-align: left;
            color: #783b31;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }
        
        .print-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        
        .print-summary-row.total {
            font-weight: 700;
            font-size: 16px;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
            margin-top: 10px;
            color: #783b31;
        }
        
        .invoice-footer {
            clear: both;
            text-align: center;
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
            color: #888;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(200, 200, 200, 0.1);
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
        }
        
        .filter-form {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .filter-group label {
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }
        
        .filter-group select,
        .filter-group input {
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .filter-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
            font-size: 14px;
        }
        
        .filter-btn:hover {
            background-color: var(--secondary-color);
        }
        
        .download-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
            font-size: 14px;
            margin-top: 20px;
        }
        
        .download-btn:hover {
            background-color: #218838;
        }
    </style>
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

                <!-- Sales Reports Section -->
                <div class="table-container">
                    <h2>Sales Reports</h2>
                    
                    <!-- Report Filter Form -->
                    <form method="GET" action="" class="filter-form" id="reportForm">
                        <input type="hidden" name="id" value="<?php echo $data['branch']->branch_id; ?>">
                        
                        <div class="filter-group">
                            <label>Report Type:</label>
                            <select name="report_type" id="reportType" onchange="toggleFilterFields()">
                                <option value="">Select Type</option>
                                <option value="daily" <?php echo $data['reportType'] === 'daily' ? 'selected' : ''; ?>>Daily Report</option>
                                <option value="monthly" <?php echo $data['reportType'] === 'monthly' ? 'selected' : ''; ?>>Monthly Report</option>
                                <option value="yearly" <?php echo $data['reportType'] === 'yearly' ? 'selected' : ''; ?>>Yearly Report</option>
                            </select>
                        </div>

                        <div class="filter-group" id="dailyFilter" style="display: none;">
                            <label for="date">Date:</label>
                            <input type="date" name="date" id="date" 
                                value="<?php echo isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); ?>">
                        </div>

                        <div class="filter-group" id="monthlyFilter" style="display: none;">
                            <label for="month">Month:</label>
                            <select name="month" id="month">
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo $i; ?>" 
                                        <?php echo (isset($_GET['month']) && $_GET['month'] == $i) ? 'selected' : 
                                              (!isset($_GET['month']) && date('n') == $i ? 'selected' : ''); ?>>
                                        <?php echo date('F', mktime(0, 0, 0, $i, 10)); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="filter-group" id="yearFilter" style="display: none;">
                            <label for="year">Year:</label>
                            <select name="year" id="year">
                                <?php 
                                $currentYear = date('Y');
                                for ($i = $currentYear; $i >= $currentYear - 5; $i--): 
                                ?>
                                    <option value="<?php echo $i; ?>" 
                                        <?php echo (isset($_GET['year']) && $_GET['year'] == $i) ? 'selected' : 
                                              (!isset($_GET['year']) && date('Y') == $i ? 'selected' : ''); ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <button type="button" class="filter-btn" onclick="submitForm()">
                                <i class="fas fa-filter"></i> Generate Report
                            </button>
                        </div>
                    </form>

                    <!-- Total Sales -->
                    <div class="total-sales">
                        <h3>Total Sales: LKR <?php echo number_format($data['totalSales'], 2); ?></h3>
                        <button class="download-btn" onclick="printSalesReport()">
                            <i class="fas fa-download"></i> Download PDF
                        </button>
                    </div>

                    <!-- Sales Data -->
                    <?php if (!empty($data['salesData'])): ?>
                        <div class="table-container sales-table">
                            <h2>Sales Data</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Total Sales (LKR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['salesData'] as $sales): ?>
                                        <tr>
                                            <td><?php echo date('d M Y', strtotime($sales->sales_date)); ?></td>
                                            <td><?php echo number_format($sales->total_sales, 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No sales data available for this branch.</p>
                    <?php endif; ?>

                    <!-- Graphs Section -->
                    <div class="graphs-container" style="display: flex; gap: 20px; margin-top: 30px;">
                        <!-- Left side: Bar Chart -->
                        <div class="graph-left" style="flex: 1; background: white; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 15px;">
                            <h3 style="color: #783b31; margin-bottom: 15px; font-size: 1.1rem; border-bottom: 1px solid #f2f1ec; padding-bottom: 8px;">
                                Sales by Date
                            </h3>
                            <div style="height: 250px;">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                        
                        <!-- Right side: Analysis Chart -->
                        <div class="graph-right" style="flex: 1; background: white; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 15px;">
                            <h3 style="color: #783b31; margin-bottom: 15px; font-size: 1.1rem; border-bottom: 1px solid #f2f1ec; padding-bottom: 8px;">
                                Sales Trend Analysis
                            </h3>
                            <div style="height: 250px;">
                                <canvas id="salesAnalysisChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

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
                    <p>Report #BSR-<?php echo date('Ymd'); ?>-<?php echo $data['branch']->branch_id; ?></p>
                </div>
            </div>
            
            <!-- Branch Information -->
            <div class="company-info">
                <div class="company-info-left">
                    <h3>Branch Information</h3>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($data['branch']->branch_address); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($data['branch']->branch_contact); ?></p>
                </div>
                <div class="report-info">
                    <p><strong>Report Period:</strong> 
                        <?php 
                        if (isset($_GET['date'])) {
                            echo date('d F Y', strtotime($_GET['date']));
                        } elseif (isset($_GET['month']) && isset($_GET['year'])) {
                            echo date('F Y', mktime(0, 0, 0, $_GET['month'], 1, $_GET['year']));
                        } elseif (isset($_GET['year'])) {
                            echo $_GET['year'];
                        } else {
                            echo 'All Time';
                        }
                        ?>
                    </p>
                    <p><strong>Report Generated:</strong> <?php echo date('d F Y, h:i A'); ?></p>
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
                            <td colspan="2">No sales data available for this branch.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Sales Summary -->
            <div class="print-summary">
                <h3>Sales Summary</h3>
                <div class="print-summary-row">
                    <span>Total Sales:</span>
                    <span>LKR <?php echo number_format($data['totalSales'], 2); ?></span>
                </div>
            </div>

            <!-- Footer -->
            <div class="invoice-footer">
                <p>Generated by Frostine Bakery System</p>
            </div>
        </div>
    </div>

    <script>
        // Bar chart logic - Updated with dashboard colors
        const salesData = <?php echo json_encode(array_map(function($sales) {
            return [
                'date' => date('d M', strtotime($sales->sales_date)),
                'total_sales' => $sales->total_sales
            ];
        }, $data['salesData'])); ?>;

        const labels = salesData.map(sale => sale.date);
        const data = salesData.map(sale => sale.total_sales);
        
        // Calculate running average for analysis chart
        const runningAvg = [];
        let sum = 0;
        for (let i = 0; i < data.length; i++) {
            sum += parseFloat(data[i]);
            runningAvg.push(sum / (i + 1));
        }

        // Bar Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales (LKR)',
                    data: data,
                    backgroundColor: 'rgba(201, 141, 131, 0.7)',
                    borderColor: '#c98d83',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1.5,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 10,
                            font: {
                                size: 10
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'LKR ' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(201, 141, 131, 0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'LKR ' + value;
                            },
                            font: {
                                size: 9
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 9
                            }
                        }
                    }
                }
            }
        });

        // Sales Analysis Chart (Trend Line)
        const analysisCtx = document.getElementById('salesAnalysisChart').getContext('2d');
        const salesAnalysisChart = new Chart(analysisCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Sales',
                    data: data,
                    backgroundColor: 'rgba(201, 141, 131, 0.2)',
                    borderColor: '#c98d83',
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#c98d83',
                    fill: false
                }, {
                    label: 'Average Trend',
                    data: runningAvg,
                    backgroundColor: 'rgba(120, 59, 49, 0.1)',
                    borderColor: '#783b31',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    tension: 0.4,
                    pointRadius: 0,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1.5,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 10,
                            font: {
                                size: 10
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': LKR ' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(201, 141, 131, 0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'LKR ' + value;
                            },
                            font: {
                                size: 9
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 9
                            }
                        }
                    }
                }
            }
        });

        // Toggle filter fields based on report type
        function toggleFilterFields() {
            const reportType = document.getElementById('reportType').value;
            const dailyFilter = document.getElementById('dailyFilter');
            const monthlyFilter = document.getElementById('monthlyFilter');
            const yearFilter = document.getElementById('yearFilter');

            // Hide all filters first
            dailyFilter.style.display = 'none';
            monthlyFilter.style.display = 'none';
            yearFilter.style.display = 'none';
            
            // Show relevant filters based on report type
            switch(reportType) {
                case 'daily':
                    dailyFilter.style.display = 'block';
                    yearFilter.style.display = 'none'; // Year is included in the date picker
                    break;
                case 'monthly':
                    monthlyFilter.style.display = 'block';
                    yearFilter.style.display = 'block';
                    break;
                case 'yearly':
                    yearFilter.style.display = 'block';
                    break;
                default:
                    // No filters shown if none selected
                    break;
            }
        }

        // Submit form with appropriate parameters
        function submitForm() {
            const form = document.getElementById('reportForm');
            const reportType = document.getElementById('reportType').value;
            
            // Create a new FormData object to manipulate what gets submitted
            const formData = new FormData(form);
            
            // Remove all parameters first
            formData.delete('date');
            formData.delete('month');
            formData.delete('year');
            
            // Only add the relevant parameters based on report type
            if (reportType === 'daily') {
                formData.set('date', document.getElementById('date').value);
            } else if (reportType === 'monthly') {
                formData.set('month', document.getElementById('month').value);
                formData.set('year', document.getElementById('year').value);
            } else if (reportType === 'yearly') {
                formData.set('year', document.getElementById('year').value);
            }
            
            // Build the query string manually
            const params = new URLSearchParams();
            formData.forEach((value, key) => {
                params.append(key, value);
            });
            
            // Redirect with the correct parameters
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }

        // Initialize filter fields on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set the report type based on URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            let reportType = '';
            
            if (urlParams.has('date')) {
                reportType = 'daily';
            } else if (urlParams.has('month')) {
                reportType = 'monthly';
            } else if (urlParams.has('year')) {
                reportType = 'yearly';
            }
            
            // Set the selected value
            if (reportType) {
                document.getElementById('reportType').value = reportType;
            }
            
            // Show/hide appropriate fields
            toggleFilterFields();
        });

        // Print sales report function (unchanged)
        function printSalesReport() {
            window.print();
        }
    </script>
</body>

</html>