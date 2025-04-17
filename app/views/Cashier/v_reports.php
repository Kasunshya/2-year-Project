<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Sales Report Management</title>
    <?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/salesReport.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<main>
    <header><i class="fas fa-chart-bar">&nbsp;</i> Reports</header>
    <div class="report-container">
        <div class="report-card">
            <img src="<?php echo URLROOT;?>/img/BranchManger/blue.png" alt="Sales Icon" class="report-image">
            <h3>SALES REPORT</h3>
            <form action="<?php echo URLROOT; ?>/cashier/generateReport" method="POST">
                <div class="date-selection">
                    <label for="start-date">Starting Date:</label>
                    <input type="date" id="start-date" name="start_date" required>
                    
                    <label for="end-date">End Date:</label>
                    <input type="date" id="end-date" name="end_date" required>
                    
                    <label for="branch">Branch:</label>
                    <select name="branch_id" id="branch">
                        <option value="">All Branches</option>
                        <?php foreach($data['branches'] as $branch): ?>
                            <option value="<?php echo $branch->branch_id; ?>">
                                <?php echo $branch->branch_name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="cashier">Cashier:</label>
                    <select name="cashier_id" id="cashier">
                        <option value="">All Cashiers</option>
                        <?php foreach($data['cashiers'] as $cashier): ?>
                            <option value="<?php echo $cashier->employee_id; ?>">
                                <?php echo $cashier->full_name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <button type="submit">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>