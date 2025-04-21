<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/salesReport.css">
</head>
<body>
<main>
    <div class="report-header">
        <h2>Sales Report</h2>
        <p>Period: <?php echo $data['startDate']; ?> to <?php echo $data['endDate']; ?></p>
        <button onclick="window.print()" class="print-button">Print Report</button>
    </div>

    <div class="report-summary">
        <?php
        $totalSales = 0;
        $totalItems = 0;
        foreach ($data['sales'] as $sale) {
            $totalSales += $sale->total;
            $totalItems += $sale->total_items;
        }
        ?>
        <div class="summary-box">
            <h3>Total Sales</h3>
            <p>$<?php echo number_format($totalSales, 2); ?></p>
        </div>
        <div class="summary-box">
            <h3>Total Orders</h3>
            <p><?php echo count($data['sales']); ?></p>
        </div>
        <div class="summary-box">
            <h3>Total Items Sold</h3>
            <p><?php echo $totalItems; ?></p>
        </div>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Branch</th>
                <th>Cashier</th>
                <th>Items</th>
                <th>Total</th>
                <th>Payment Method</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['sales'] as $sale): ?>
            <tr>
                <td>#<?php echo $sale->order_id; ?></td>
                <td><?php echo date('Y-m-d H:i', strtotime($sale->order_date)); ?></td>
                <td><?php echo $sale->branch_name ?? 'N/A'; ?></td>
                <td><?php echo $sale->cashier_name ?? 'N/A'; ?></td>
                <td><?php echo $sale->total_items; ?></td>
                <td>$<?php echo number_format($sale->total, 2); ?></td>
                <td><?php echo $sale->payment_method; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>
