<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Employee Management</title>
    <?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/transactions.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @media print {
            /* Hide everything except print section */
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
        
        /* Hide print-section by default */
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

        /* Invoice styling */
        .invoice-container {
            padding: 40px;
            position: relative;
            border: 1px solid #eaeaea;
        }
        
        /* Header with Logo */
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
            height: 60px; /* Adjust logo size as needed */
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
        
        .invoice-title p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        /* Company and Report Info */
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
        
        .company-info-left p {
            margin: 5px 0;
            font-size: 14px;
            color: #444;
        }
        
        .report-info {
            flex: 1;
            text-align: right;
        }
        
        .report-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #444;
        }
        
        .report-info strong {
            color: #783b31;
        }
        
        /* Transactions Table */
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
        
        .print-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .print-table tr:hover {
            background-color: #f1f1f1;
        }
        
        /* Summary Box */
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
        
        /* Footer */
        .invoice-footer {
            clear: both;
            text-align: center;
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
            color: #888;
        }
        
        .invoice-footer p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        /* Watermark */
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
        
        /* QR Code spot */
        .qr-code {
            position: absolute;
            bottom: 40px;
            left: 40px;
            width: 80px;
            height: 80px;
            border: 1px dashed #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .qr-code span {
            font-size: 10px;
            color: #999;
            text-align: center;
        }

        /* Status colors */
        .status-paid {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        
        /* Print button */
        .invoice-btn {
            background-color: #783b31;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        .invoice-btn:hover {
            background-color: #62302a;
        }
        
        /* Additional styles to mimic a professional PDF */
        .print-section {
            position: relative;
        }
    </style>
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

    <!-- Header Banner -->
    <header><i class="fas fa-chart-bar">&nbsp</i> Daily Transactions</header>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Debug info - remove in production -->
        <?php if(isset($_SESSION['employee_id'])): ?>
            <p class="debug-info">Logged in as employee ID: <?php echo $_SESSION['employee_id']; ?></p>
        <?php else: ?>
            <!-- Display a more user-friendly message and provide a fallback ID -->
            <?php
                // Set default employee_id for cashier if not set
                if (!isset($_SESSION['employee_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'cashier') {
                    $_SESSION['employee_id'] = 1; // Fallback ID
                }
            ?>
            <p class="debug-info">Using system default cashier ID</p>
        <?php endif; ?>
        
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Date</th>
                    <th>Total Sales</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['transactions'])) : ?>
                    <?php foreach ($data['transactions'] as $transaction) : ?>
                        <tr>
                            <td>OID<?php echo $transaction->order_id; ?></td>
                            <td><?php echo date('d M Y, H:i', strtotime($transaction->order_date)); ?></td>
                            <td>LKR <?php echo number_format($transaction->total, 2); ?></td>
                            <td><?php echo $transaction->payment_method; ?></td>
                            <td><?php echo $transaction->payment_status; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="no-records">No transactions found for today</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Summary Box -->
    <div class="summary-box">
        <h3>Summary Box</h3>
        <p>Total Sales: <strong>LKR <?php echo number_format($data['summary']->total_sales ?? 0, 2); ?></strong></p>
        <p>No of Transactions: <strong><?php echo $data['summary']->transaction_count ?? 0; ?></strong></p>
        <button class="invoice-btn" onclick="printDailyReport()">Print Invoice</button>
    </div>

    <!-- Print Section -->
    <div class="print-section">
        <div class="invoice-container">
            <!-- Watermark -->
            <div class="watermark">FROSTINE</div>
            
            <!-- Invoice Header with Logo -->
            <div class="invoice-header">
                <div class="invoice-logo">
                    <!--img src="<?php echo URLROOT; ?>/public/img/frostineLogo.png" alt="Frostine Logo"-->
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
                    <h3>Bakery Information</h3>
                    <p>123 Baker Street, Colombo</p>
                    <p>Phone: +94 112 345 678</p>
                    <p>Email: info@frostine.com</p>
                    <p>Website: www.frostinebakery.com</p>
                </div>
                <div class="report-info">
                    <p><strong>Date:</strong> <?php echo date('d F Y'); ?></p>
                    <?php if(isset($_SESSION['employee_id'])): ?>
                        <p><strong>Cashier ID:</strong> <?php echo $_SESSION['employee_id']; ?></p>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['branch_id'])): ?>
                        <p><strong>Branch ID:</strong> <?php echo $_SESSION['branch_id']; ?></p>
                    <?php endif; ?>
                    <p><strong>Report Generated:</strong> <?php echo date('d F Y, h:i A'); ?></p>
                </div>
            </div>

            <!-- Transactions Table -->
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

            <!-- Summary Box -->
            <div class="print-summary">
                <h3>Transaction Summary</h3>
                <div class="print-summary-row">
                    <span>Total Transactions</span>
                    <span><?php echo $data['summary']->transaction_count ?? 0; ?></span>
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

            <!-- QR Code placeholder -->
            <div class="qr-code">
                <span>Scan to verify report</span>
            </div>

            <!-- Footer -->
            <div class="invoice-footer">
                <p>Thank you for your business!</p>
                <p>&copy; <?php echo date('Y'); ?> FROSTINE BAKERY - All Rights Reserved</p>
                <p><small>This is a computer generated document and requires no signature</small></p>
            </div>
        </div>
    </div>

    <!-- Modify the print button to use custom print function -->
    <script>
        function printDailyReport() {
            // Show print section just before printing
            document.querySelector('.print-section').style.display = 'block';
            
            // Add a slight delay to ensure CSS is applied before printing
            setTimeout(() => {
                window.print();
                
                // Hide print section after printing dialog is closed
                setTimeout(() => {
                    document.querySelector('.print-section').style.display = 'none';
                }, 100);
            }, 300);
        }
    </script>
</body>
</html>