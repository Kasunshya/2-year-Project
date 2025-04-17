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
                padding: 20px;
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
            margin: 20px;
        }
        
        /* Rest of your existing styles */
        .print-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        .print-table th, .print-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .print-summary {
            margin-top: 20px;
            border-top: 2px solid #333;
            padding: 15px;
            background: #f9f9f9;
            width: 60%;  /* Reduced from 100% */
            margin-left: 20px;  /* Add left margin */
        }
        .print-summary-row {
            display: flex;
            justify-content: flex-start;  /* Changed from space-between */
            padding: 5px 20px;
            font-size: 16px;
        }
        .print-summary-row span:first-child {
            width: 200px;  /* Fixed width for labels */
            font-weight: 500;
        }
        .print-summary-row span:last-child {
            margin-left: 20px;  /* Add space between label and value */
        }
        .print-summary-row.total {
            font-weight: bold;
            font-size: 18px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 5px;
        }
        .print-summary h3 {
            margin-bottom: 15px;
            text-align: center;
            font-size: 20px;
        }
        .company-info {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            border-bottom: 2px solid #333;
        }
        .company-info h1 {
            margin-bottom: 10px;
            color: #333;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 20px;
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
            <p class="debug-info">No employee ID set in session</p>
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
                            <td>#<?php echo $transaction->order_id; ?></td>
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
        <div class="company-info">
            <h1>FROSTINE BAKERY</h1>
            <p>Daily Transaction Report</p>
            <p><?php echo date('d M Y'); ?></p>
        </div>

        <div class="print-header">
            <h2>Daily Transactions Summary</h2>
            <p>Date: <?php echo date('d M Y'); ?></p>
            <?php if(isset($_SESSION['employee_id'])): ?>
                <p>Cashier ID: <?php echo $_SESSION['employee_id']; ?></p>
            <?php endif; ?>
        </div>

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
                            <td>#<?php echo $transaction->order_id; ?></td>
                            <td><?php echo date('H:i', strtotime($transaction->order_date)); ?></td>
                            <td>LKR <?php echo number_format($transaction->total, 2); ?></td>
                            <td><?php echo $transaction->payment_method; ?></td>
                            <td><?php echo $transaction->payment_status; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="print-summary">
            <h3>Summary</h3>
            <div class="print-summary-row">
                <span>Total Transactions:</span>
                <span><?php echo $data['summary']->transaction_count ?? 0; ?></span>
            </div>
            <div class="print-summary-row total">
                <span>Total Sales:</span>
                <span>LKR <?php echo number_format($data['summary']->total_sales ?? 0, 2); ?></span>
            </div>
            <div class="print-summary-row">
                <span>Generated on:</span>
                <span><?php echo date('d M Y H:i:s'); ?></span>
            </div>
        </div>

        <div class="footer" style="text-align: center; margin-top: 50px;">
            <p>Thank you for your business!</p>
            <p>FROSTINE BAKERY</p>
            <small>This is a computer generated document</small>
        </div>
    </div>

    <!-- Modify the print button to use custom print function -->
    <script>
        function printDailyReport() {
            // Show print section just before printing
            document.querySelector('.print-section').style.display = 'block';
            window.print();
            // Hide print section after printing dialog is closed
            setTimeout(() => {
                document.querySelector('.print-section').style.display = 'none';
            }, 100);
        }
        
        // Remove the DOMContentLoaded listener since we don't want to show print section by default
    </script>
</body>
</html>