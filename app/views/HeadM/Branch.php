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
            <section class="dashboard-content">
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
                    <p>Sales reports are not available for this branch.</p>
                </div>
            </section>
        </main>
    </div>
</body>

</html>