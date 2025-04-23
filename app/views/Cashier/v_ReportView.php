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
