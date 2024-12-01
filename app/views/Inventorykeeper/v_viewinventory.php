<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Keeper - View Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../public/css/Inventorykeeper/viewinventory.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <?php require APPROOT.'/views/inc/components/ivertical.php'?>
</head>
<body>
    
        <!-- Main Content -->
        <main>
            <!-- Header Section -->
            <header class="header">
                <h1><a href="#"><i class="fas fa-chart-bar"></i></a> Dashboard</h1>
                <div class="user-info">
                    Inventory Keeper<br>
                    Dasun Shanaka
                </div>
            </header>

            <!-- Inventory Chart and Table -->
            <section class="content-container">
                <div class="chart-container">
                    <h2>Inventory Storage Status</h2>
                    <canvas id="inventoryChart"></canvas>
                </div>

                <div class="inventory-table-container">
                    <h2>Inventory Table</h2>
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Inventory ID</th>
                                <th>Inventory Name</th>
                                <th>Price</th>
                                <th>Quantity (kg)</th>
                                <th>Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['inventory'] as $item): ?>
                                <tr>
                                    <td><?php echo $item->inventory_id; ?></td>
                                    <td><?php echo $item->name; ?></td>
                                    <td><?php echo $item->Price_per_kg; ?></td>
                                    <td><?php echo $item->quantity_available; ?></td>
                                    <td><?php echo $item->Expiry_date; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Chart.js script
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        const inventoryChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Low Storage', 'Sufficient Storage'],
                datasets: [{
                    label: 'Inventory Status',
                    data: [<?php echo $data['low_storage']; ?>, <?php echo $data['sufficient_storage']; ?>],
                    backgroundColor: ['#e74c3c', '#2ecc71'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            },
        });
    </script>
</body>
</html>
