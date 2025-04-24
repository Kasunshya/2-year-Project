<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/bill.css">
    <style>
    .warning-message {
        background-color: #fff3cd;
        color: #856404;
        padding: 10px;
        border-radius: 4px;
        margin: 10px 0;
        text-align: center;
    }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>Frostine Bakery</h1>
            <p>Order OID<?php echo isset($data['order_id']) ? $data['order_id'] : 'N/A'; ?></p>
            <p>Date: <?php echo isset($data['date']) ? $data['date'] : date('Y-m-d H:i:s'); ?></p>
            <hr>
        </div>

        <div class="receipt-body">
            <?php
            if (empty($data)) {
                error_log('No data passed to bill view');
            } else {
                error_log('Bill data: ' . print_r($data, true));
            }
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['items'])): ?>
                        <?php foreach ($data['items'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>LKR<?php echo number_format($item['price'], 2); ?></td>
                                <td>LKR<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No items</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="receipt-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>LKR<?php echo number_format($data['subtotal'] ?? 0, 2); ?></span>
                </div>
                <div class="summary-row">
                    <span>Discount:</span>
                    <span>LKR<?php echo number_format($data['discount'] ?? 0, 2); ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span>LKR<?php echo number_format($data['total'] ?? 0, 2); ?></span>
                </div>
                <?php if (isset($data['payment_method']) && $data['payment_method'] === 'cash'): ?>
                <div class="summary-row">
                    <span>Amount Tendered:</span>
                    <span>LKR<?php echo number_format($data['amount_tendered'] ?? 0, 2); ?></span>
                </div>
                <div class="summary-row">
                    <span>Change:</span>
                    <span>LKR<?php echo number_format($data['change'] ?? 0, 2); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if(isset($data['stock_updated']) && !$data['stock_updated']): ?>
        <div class="warning-message">
            <strong>Note:</strong> There was an issue updating the inventory. Please notify the manager.
        </div>
        <?php endif; ?>

        <div class="receipt-footer">
            <p>Thank you for shopping with us!</p>
            <p>Payment Method: <?php echo htmlspecialchars($data['payment_method']); ?></p>
            <button onclick="window.print()" class="print-btn">Print Receipt</button>
            <a href="<?php echo URLROOT; ?>/Cashier/servicedesk" class="new-order-btn">New Order</a>
        </div>
    </div>
</body>
</html>
