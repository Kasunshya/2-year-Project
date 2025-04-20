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
                <div class="overview">
                    <h2>Branch Manager</h2>
                    <?php if (!empty($data['branchManager'])): ?>
                        <table class="styled-table">
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
                <div class="overview">
                    <h2>Cashiers</h2>
                    <?php if (!empty($data['cashiers'])): ?>
                        <table class="styled-table">
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
                <div class="overview">
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
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Total Sales ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['salesData'] as $sales): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($sales->sales_date); ?></td>
                                        <td><?php echo number_format($sales->total_sales, 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
        </main>
    </div>

    

    <script>
        // Prepare data for the bar chart
        const salesData = <?php echo json_encode(array_map(function($sales) {
            return [
                'date' => $sales->sales_date,
                'total_sales' => $sales->total_sales
            ];
        }, $data['salesData'])); ?>;

        const labels = salesData.map(sale => sale.date);
        const data = salesData.map(sale => sale.total_sales);

        // Create the bar chart
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

        // Prepare data for the pie chart
        const pieData = {
            labels: labels,
            datasets: [{
                label: 'Sales Distribution',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Create the pie chart
        const pieCtx = document.getElementById('salesPieChart').getContext('2d');
        const salesPieChart = new Chart(pieCtx, {
            type: 'pie',
            data: pieData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>

</html>