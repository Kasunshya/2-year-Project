<?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/salesReport.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    /* Hide all content except print section when printing */
    @media print {
        body * {
            visibility: hidden;
        }
        .print-section,
        .print-section * {
            visibility: visible;
        }
        .print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }

    /* Print section styling */
    .print-section {
        background: white;
        padding: 20px;
        margin: 20px auto;
        max-width: 8.5in;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    /* Same styling as cashier's transaction report */
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

    /* ... existing code for report-tabs and report-content ... */

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

    .invoice-footer {
        clear: both;
        text-align: center;
        margin-top: 60px;
        padding-top: 20px;
        border-top: 1px solid #eaeaea;
        color: #888;
    }

    .invoice-btn {
        background-color: #783b31;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .invoice-btn:hover {
        background-color: #62302a;
    }

    .status-paid { color: #28a745; font-weight: bold; }
    .status-pending { color: #ffc107; font-weight: bold; }
    .status-failed { color: #dc3545; font-weight: bold; }

    /* Add these new styles for tab functionality */
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .tab-btn {
        padding: 10px 20px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .tab-btn.active {
        background: #783b31;
        color: white;
        border-color: #783b31;
    }

    .report-tabs {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
    }
</style>
<body>
<header><i class="fas fa-chart-bar">&nbsp</i> Reports</header>

<div class="report-wrapper">
    <!-- Report Types Tabs -->
    <div class="report-tabs">
        <button class="tab-btn active" data-tab="daily">
            <i class="fas fa-calendar-day"></i>Daily Sales
        </button>
        <button class="tab-btn" data-tab="range">
            <i class="fas fa-calendar-week"></i>Date Range
        </button>
        <button class="tab-btn" data-tab="product">
            <i class="fas fa-chart-line"></i>Product Performance
        </button>
    </div>

    <!-- Report Content -->
    <div class="report-content">
        <!-- Daily Sales Section -->
        <div class="tab-content active" id="daily">
            <div class="report-header">
                <h2>Daily Sales Report</h2>
                <div class="report-actions">
                    <input type="date" id="dailyDate" value="<?php echo $data['date'] ?? date('Y-m-d'); ?>">
                    <button class="btn-generate" onclick="generateDailyReport()">
                        <i class="fas fa-sync"></i> Generate
                    </button>
                    <button class="btn-export" onclick="printDailyReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Print Section -->
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
                                <p>Fresh & Delicious Every Day</p>
                            </div>
                        </div>
                        <div class="invoice-title">
                            <h2>Daily Transactions</h2>
                            <p>Report #DTR-<?php echo date('Ymd'); ?></p>
                        </div>
                    </div>
                    
                    <!-- Company and Report Information -->
                    <div class="company-info">
                        <div class="company-info-left">
                            <h3>Branch Information</h3>
                            <p><?php echo $data['branch']->branch_name; ?></p>
                            <p><?php echo $data['branch']->branch_address; ?></p>
                            <p>Contact: <?php echo $data['branch']->branch_contact; ?></p>
                        </div>
                        <div class="report-info">
                            <p><strong>Date:</strong> <?php 
                                if (isset($data['date'])) {
                                    echo date('d F Y', strtotime($data['date']));
                                } elseif (isset($data['startDate']) && isset($data['endDate'])) {
                                    echo date('d F Y', strtotime($data['startDate'])) . ' to ' . date('d F Y', strtotime($data['endDate']));
                                } else {
                                    echo date('d F Y');
                                }
                            ?></p>
                            <p><strong>Branch ID:</strong> <?php echo $data['branch']->branch_id; ?></p>
                            <p><strong>Report Generated:</strong> <?php echo date('d F Y, h:i A'); ?></p>
                        </div>
                    </div>

                    <!-- Print Table -->
                    <table class="print-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Time</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['transactions'])) : ?>
                                <?php foreach ($data['transactions'] as $transaction) : ?>
                                    <tr>
                                        <td>OID<?php echo $transaction->order_id; ?></td>
                                        <td><?php echo date('h:i A', strtotime($transaction->order_date)); ?></td>
                                        <td>LKR <?php echo number_format($transaction->total, 2); ?></td>
                                        <td><?php echo $transaction->payment_method; ?></td>
                                        <td class="status-<?php echo strtolower($transaction->payment_status); ?>">
                                            <?php echo $transaction->payment_status; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;">No transactions found for today</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Print Summary -->
                    <div class="print-summary">
                        <h3>Transaction Summary</h3>
                        <div class="print-summary-row">
                            <span>Total Transactions</span>
                            <span><?php echo $data['summary']->total_orders ?? 0; ?></span>
                        </div>
                        <div class="print-summary-row">
                            <span>Cash Sales</span>
                            <span>LKR <?php echo number_format($data['summary']->cash_sales ?? 0, 2); ?></span>
                        </div>
                        <div class="print-summary-row">
                            <span>Card Sales</span>
                            <span>LKR <?php echo number_format($data['summary']->card_sales ?? 0, 2); ?></span>
                        </div>
                        <div class="print-summary-row total">
                            <span>Total Sales</span>
                            <span>LKR <?php echo number_format($data['summary']->total_sales ?? 0, 2); ?></span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="invoice-footer">
                        <p>Thank you for your business!</p>
                        <p>&copy; <?php echo date('Y'); ?> FROSTINE BAKERY - All Rights Reserved</p>
                        <p><small>This is a computer generated document</small></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar structure for other tabs -->
        <!-- Date Range Report Content -->
        <div class="tab-content" id="range">
            <div class="report-header">
                <h2>Date Range Sales Report</h2>
                <div class="report-actions">
                    <input type="date" id="startDate" value="<?php echo $data['startDate'] ?? date('Y-m-d', strtotime('-7 days')); ?>">
                    <input type="date" id="endDate" value="<?php echo $data['endDate'] ?? date('Y-m-d'); ?>">
                    <button class="btn-generate" onclick="generateDateRangeReport()">
                        <i class="fas fa-sync"></i> Generate
                    </button>
                    <button class="btn-export" onclick="printDateRangeReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <div class="date-range-report print-section">
                <div class="invoice-container">
                    <div class="watermark">FROSTINE</div>
                    
                    <div class="invoice-header">
                        <div class="invoice-logo">
                            <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
                            <div class="invoice-logo-text">
                                <h1>FROSTINE BAKERY</h1>
                                <p>Date Range Sales Report</p>
                            </div>
                        </div>
                        <div class="invoice-title">
                            <h2>Date Range Transactions</h2>
                            <p>Report #DTR-<?php echo date('Ymd'); ?></p>
                        </div>
                    </div>

                    <div class="company-info">
                        <div class="company-info-left">
                            <h3>Branch Information</h3>
                            <p><?php echo $data['branch']->branch_name; ?></p>
                            <p><?php echo $data['branch']->branch_address; ?></p>
                            <p>Contact: <?php echo $data['branch']->branch_contact; ?></p>
                        </div>
                        <div class="report-info">
                            <p><strong>Date:</strong> <?php 
                                if (isset($data['date'])) {
                                    echo date('d F Y', strtotime($data['date']));
                                } elseif (isset($data['startDate']) && isset($data['endDate'])) {
                                    echo date('d F Y', strtotime($data['startDate'])) . ' to ' . date('d F Y', strtotime($data['endDate']));
                                } else {
                                    echo date('d F Y');
                                }
                            ?></p>
                            <p><strong>Branch ID:</strong> <?php echo $data['branch']->branch_id; ?></p>
                            <p><strong>Report Generated:</strong> <?php echo date('d F Y, h:i A'); ?></p>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <table class="print-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['transactions'])) : ?>
                                <?php foreach ($data['transactions'] as $transaction) : ?>
                                    <tr>
                                        <td>#<?php echo $transaction->order_id; ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($transaction->order_date)); ?></td>
                                        <td><?php echo date('h:i A', strtotime($transaction->order_date)); ?></td>
                                        <td>LKR <?php echo number_format($transaction->total, 2); ?></td>
                                        <td><?php echo $transaction->payment_method; ?></td>
                                        <td class="status-<?php echo strtolower($transaction->payment_status); ?>">
                                            <?php echo $transaction->payment_status; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">No transactions found for selected period</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Summary Section -->
                    <div class="print-summary">
                        <h3>Period Summary</h3>
                        <div class="print-summary-row">
                            <span>Total Days</span>
                            <span><?php echo $data['summary']->total_days ?? 0; ?></span>
                        </div>
                        <div class="print-summary-row">
                            <span>Total Transactions</span>
                            <span><?php echo $data['summary']->total_orders ?? 0; ?></span>
                        </div>
                        <div class="print-summary-row">
                            <span>Cash Sales</span>
                            <span>LKR <?php echo number_format($data['summary']->cash_sales ?? 0, 2); ?></span>
                        </div>
                        <div class="print-summary-row">
                            <span>Card Sales</span>
                            <span>LKR <?php echo number_format($data['summary']->card_sales ?? 0, 2); ?></span>
                        </div>
                        <div class="print-summary-row">
                            <span>Average Order Value</span>
                            <span>LKR <?php echo number_format($data['summary']->average_order_value ?? 0, 2); ?></span>
                        </div>
                        <div class="print-summary-row total">
                            <span>Total Sales</span>
                            <span>LKR <?php echo number_format($data['summary']->total_sales ?? 0, 2); ?></span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="invoice-footer">
                        <p>Thank you for your business!</p>
                        <p>&copy; <?php echo date('Y'); ?> FROSTINE BAKERY - All Rights Reserved</p>
                        <p><small>This is a computer generated document</small></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Performance Report Content -->
        <div class="tab-content" id="product">
            <div class="report-header">
                <h2>Product Performance Report</h2>
                <div class="report-actions">
                    <input type="date" id="productStartDate" value="<?php echo isset($data['startDate']) ? $data['startDate'] : date('Y-m-d', strtotime('-30 days')); ?>">
                    <input type="date" id="productEndDate" value="<?php echo isset($data['endDate']) ? $data['endDate'] : date('Y-m-d'); ?>">
                    <button class="btn-generate" onclick="generateProductReport()">
                        <i class="fas fa-sync"></i> Generate
                    </button>
                    <button class="btn-export" onclick="printProductReport()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <div class="product-report print-section">
                <div class="invoice-container">
                    <div class="watermark">FROSTINE</div>
                    <div class="invoice-header">
                        <div class="invoice-logo">
                            <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
                            <div class="invoice-logo-text">
                                <h1>FROSTINE BAKERY</h1>
                                <p>Product Performance Analysis</p>
                            </div>
                        </div>
                        <div class="invoice-title">
                            <h2>Product Performance Report</h2>
                            <p>Report #PPR-<?php echo date('Ymd'); ?></p>
                        </div>
                    </div>

                    <div class="company-info">
                        <div class="company-info-left">
                            <h3>Branch Information</h3>
                            <p><?php echo $data['branch']->branch_name; ?></p>
                            <p><?php echo $data['branch']->branch_address; ?></p>
                            <p>Contact: <?php echo $data['branch']->branch_contact; ?></p>
                        </div>
                        <div class="report-info">
                            <p><strong>Period:</strong> <?php 
                                $startDate = isset($data['startDate']) ? date('d F Y', strtotime($data['startDate'])) : date('d F Y', strtotime('-30 days'));
                                $endDate = isset($data['endDate']) ? date('d F Y', strtotime($data['endDate'])) : date('d F Y');
                                echo $startDate . ' to ' . $endDate;
                            ?></p>
                            <p><strong>Branch ID:</strong> <?php echo $data['branch']->branch_id; ?></p>
                            <p><strong>Report Generated:</strong> <?php echo date('d F Y, h:i A'); ?></p>
                        </div>
                    </div>

                    <!-- Category Performance -->
                    <h3>Category Performance</h3>
                    <table class="print-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Products</th>
                                <th>Total Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['categories'])) : ?>
                                <?php foreach ($data['categories'] as $category) : ?>
                                    <tr>
                                        <td><?php echo $category->category_name; ?></td>
                                        <td><?php echo $category->product_count; ?></td>
                                        <td><?php echo number_format($category->total_sold); ?></td>
                                        <td>LKR <?php echo number_format($category->total_revenue, 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">No category data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Product Performance -->
                    <h3>Product Performance</h3>
                    <table class="print-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Units Sold</th>
                                <th>Orders</th>
                                <th>Avg. Price</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['products'])) : ?>
                                <?php foreach ($data['products'] as $product) : ?>
                                    <tr>
                                        <td><?php echo $product->product_name; ?></td>
                                        <td><?php echo $product->category_name; ?></td>
                                        <td><?php echo number_format($product->total_sold); ?></td>
                                        <td><?php echo number_format($product->order_count); ?></td>
                                        <td>LKR <?php echo number_format($product->average_price, 2); ?></td>
                                        <td>LKR <?php echo number_format($product->total_revenue, 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">No product data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/reports.js"></script>

<script>
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs and contents
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            // Add active class to clicked tab and corresponding content
            tab.classList.add('active');
            const contentId = tab.getAttribute('data-tab');
            document.getElementById(contentId).classList.add('active');
        });
    });
});

// Daily report functions
function generateDailyReport() {
    const date = document.getElementById('dailyDate').value;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo URLROOT; ?>/Branch/salesReport';
    
    const dateInput = document.createElement('input');
    dateInput.type = 'hidden';
    dateInput.name = 'date';
    dateInput.value = date;
    
    form.appendChild(dateInput);
    document.body.appendChild(form);
    form.submit();
}

function printDailyReport() {
    document.querySelector('.print-section').style.display = 'block';
    setTimeout(() => {
        window.print();
    }, 300);
}

// Date range report functions
function generateDateRangeReport() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo URLROOT; ?>/Branch/dateRangeReport';
    
    const startDateInput = document.createElement('input');
    startDateInput.type = 'hidden';
    startDateInput.name = 'start_date';
    startDateInput.value = startDate;
    
    const endDateInput = document.createElement('input');
    endDateInput.type = 'hidden';
    endDateInput.name = 'end_date';
    endDateInput.value = endDate;
    
    form.appendChild(startDateInput);
    form.appendChild(endDateInput);
    document.body.appendChild(form);
    form.submit();
}

function printDateRangeReport() {
    document.querySelector('.date-range-report').style.display = 'block';
    setTimeout(() => {
        window.print();
    }, 300);
}

function generateProductReport() {
    const startDate = document.getElementById('productStartDate').value;
    const endDate = document.getElementById('productEndDate').value;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo URLROOT; ?>/Branch/productPerformance';
    
    const startDateInput = document.createElement('input');
    startDateInput.type = 'hidden';
    startDateInput.name = 'start_date';
    startDateInput.value = startDate;
    
    const endDateInput = document.createElement('input');
    endDateInput.type = 'hidden';
    endDateInput.name = 'end_date';
    endDateInput.value = endDate;
    
    form.appendChild(startDateInput);
    form.appendChild(endDateInput);
    document.body.appendChild(form);
    form.submit();
}

function printProductReport() {
    document.querySelector('.product-report').style.display = 'block';
    setTimeout(() => {
        window.print();
    }, 300);
}
</script>
</body>
</html>

