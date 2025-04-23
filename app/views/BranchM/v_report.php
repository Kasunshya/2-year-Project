<?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/report.css">

<div class="content-wrapper">
    <header>
        <div class="header-container">
            <h1><i class="fas fa-file-alt"></i> Branch Report</h1>
        </div>
    </header>

    <div class="report-container">
        <div class="report-filters">
            <form action="<?php echo URLROOT; ?>/Branch/generateReport" method="POST">
                <div class="date-filters">
                    <input type="date" name="start_date" value="<?php echo $data['startDate']; ?>">
                    <span>to</span>
                    <input type="date" name="end_date" value="<?php echo $data['endDate']; ?>">
                    <button type="submit">Generate Report</button>
                </div>
            </form>
        </div>

        <div class="report-content">
            <h2>Branch: <?php echo $data['branch']->branch_name; ?></h2>
            <p>Report Period: <?php echo $data['startDate']; ?> to <?php echo $data['endDate']; ?></p>

            <table class="report-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Expiry Date</th>
                        <th>Total Orders</th>
                        <th>Total Sold</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['report'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item->product_name); ?></td>
                            <td><?php echo htmlspecialchars($item->category_name); ?></td>
                            <td><?php echo $item->current_stock; ?></td>
                            <td><?php echo $item->expiry_date; ?></td>
                            <td><?php echo $item->total_orders; ?></td>
                            <td><?php echo $item->total_sold; ?></td>
                            <td>$<?php echo number_format($item->total_revenue, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="report-actions">
                <button onclick="window.print()" class="print-btn">Print Report</button>
            </div>
        </div>
    </div>
</div>
