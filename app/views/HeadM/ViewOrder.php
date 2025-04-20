<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Head Manager - View Orders</title>
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
                <h1><i class="fas fa-clipboard-list"></i>&nbsp VIEW ORDERS</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>

            <div class="content">
                <!-- Orders Table -->
                <div class="order-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" name="search" placeholder="Search by Customer Name or Branch" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Order Date</th>
                                    <th>Order Type</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Discount</th>
                                    <th>Employee Name</th>
                                    <th>Branch</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['orders'])): ?>
                                    <?php foreach ($data['orders'] as $order): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($order->customer_name); ?></td>
                                            <td><?php echo htmlspecialchars($order->order_date); ?></td>
                                            <td><?php echo htmlspecialchars($order->order_type); ?></td>
                                            <td><?php echo htmlspecialchars($order->payment_method); ?></td>
                                            <td><?php echo htmlspecialchars($order->payment_status); ?></td>
                                            <td><?php echo htmlspecialchars($order->discount); ?></td>
                                            <td><?php echo htmlspecialchars($order->employee_name); ?></td>
                                            <td><?php echo htmlspecialchars($order->branch_name); ?></td>
                                            <td><?php echo htmlspecialchars($order->total); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" style="text-align: center;">No orders found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>