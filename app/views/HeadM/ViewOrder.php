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
                        <form method="GET" action="<?php echo URLROOT; ?>/HeadM/viewOrder" class="search-form">
                            <div class="search-field">
                                <input type="text" name="customer_name" placeholder="Search by Customer Name" value="<?php echo isset($_GET['customer_name']) ? htmlspecialchars($_GET['customer_name']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <select name="payment_method">
                                    <option value="">All Payment Methods</option>
                                    <option value="Cash" <?php echo (isset($_GET['payment_method']) && $_GET['payment_method'] == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                                    <option value="Card" <?php echo (isset($_GET['payment_method']) && $_GET['payment_method'] == 'Card') ? 'selected' : ''; ?>>Card</option>
                                </select>
                            </div>
                            <div class="search-field">
                                <select name="order_type">
                                    <option value="">All Order Types</option>
                                    <option value="Dine-In" <?php echo (isset($_GET['order_type']) && $_GET['order_type'] == 'Dine-In') ? 'selected' : ''; ?>>Dine-In</option>
                                    <option value="Takeaway" <?php echo (isset($_GET['order_type']) && $_GET['order_type'] == 'Takeaway') ? 'selected' : ''; ?>>Takeaway</option>
                                    <option value="Delivery" <?php echo (isset($_GET['order_type']) && $_GET['order_type'] == 'Delivery') ? 'selected' : ''; ?>>Delivery</option>
                                </select>
                            </div>
                            <div class="search-field">
                                <select name="branch_id">
                                    <option value="">All Branches</option>
                                    <?php foreach ($data['branches'] as $branch): ?>
                                        <option value="<?php echo $branch->branch_id; ?>" <?php echo (isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->branch_id) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($branch->branch_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="search-field">
                                <input type="date" name="date" value="<?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <input type="number" name="month" placeholder="Month (1-12)" min="1" max="12" value="<?php echo isset($_GET['month']) ? htmlspecialchars($_GET['month']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <input type="number" name="year" placeholder="Year" min="2000" max="<?php echo date('Y'); ?>" value="<?php echo isset($_GET['year']) ? htmlspecialchars($_GET['year']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <button class="btn search-btn" type="submit"><i class="fas fa-search"></i> Search</button>
                            </div>
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