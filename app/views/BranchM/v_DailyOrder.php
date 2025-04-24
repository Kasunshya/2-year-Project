<?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/DailyOrder.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<div class="main-content">
    <header>
        <div class="header-container">
            <h7><i class="fas fa-tasks"></i> Daily Orders</h7>
        </div>
    </header>

    <?php flash('order_message'); ?>

    <div class="order-container">
        <div class="order-form">
            <form action="<?php echo URLROOT; ?>/Branch/submitDailyOrder" method="POST">
                <div class="form-header">
                    <div class="form-group">
                        <label for="orderDate">Order Date:</label>
                        <input type="date" id="orderDate" name="orderDate" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Order Summary:</label>
                        <textarea id="description" name="description" readonly class="form-control" rows="5"></textarea>
                        <small class="form-text text-muted">Automatically generated based on quantities</small>
                    </div>
                </div>

                <div class="products-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Unit Price (LKR)</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($data['products']) && is_array($data['products'])): ?>
                                <?php foreach($data['products'] as $product): ?>
                                <tr>
                                    <td><?php echo $product->product_name; ?></td>
                                    <td><?php echo $product->category_name; ?></td>
                                    <td class="price"><?php echo number_format($product->price, 2); ?></td>
                                    <td>
                                        <input type="number" 
                                               name="quantities[<?php echo $product->product_id; ?>]" 
                                               class="quantity-input" 
                                               min="0" 
                                               value="0" 
                                               onchange="calculateTotal(this)">
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Submit Order</button>
                    <button type="reset" class="btn-reset">Reset Form</button>
                </div>
            </form>
        </div>

        <?php if(!empty($data['currentOrders'])): ?>
        <div class="current-orders">
            <h2>Today's Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['currentOrders'] as $order): ?>
                    <tr>
                        <td><?php echo $order->dailybranchorder_id; ?></td>
                        <td><?php echo $order->description; ?></td>
                        <td><?php echo $order->orderdate; ?></td>
                        <td><span class="status-pending">Pending</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function updateDescription() {
    const rows = document.querySelectorAll('.products-table tbody tr');
    let description = [];
    let totalItems = 0;
    
    rows.forEach(row => {
        const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
        if (quantity > 0) {
            const productName = row.querySelector('td:first-child').textContent.trim();
            const category = row.querySelector('td:nth-child(2)').textContent.trim();
            description.push(`${quantity} x ${productName} (${category})`);
            totalItems += quantity;
        }
    });
    
    let summaryText = '';
    if (description.length > 0) {
        const date = document.getElementById('orderDate').value;
        summaryText = `Daily Order - ${date}\n`;
        summaryText += `Total Items: ${totalItems}\n\n`;
        summaryText += description.join('\n');
    } else {
        summaryText = 'No items selected';
    }
    
    document.getElementById('description').value = summaryText;
}

// Add input event listeners to all quantity inputs
document.querySelectorAll('.quantity-input').forEach(input => {
    // Listen for both input and change events
    ['input', 'change'].forEach(eventType => {
        input.addEventListener(eventType, updateDescription);
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', updateDescription);

// Reset handler
document.querySelector('.btn-reset').addEventListener('click', function() {
    setTimeout(updateDescription, 10);
});

// Form validation
document.querySelector('form').onsubmit = function(e) {
    const quantities = document.querySelectorAll('.quantity-input');
    let hasQuantity = false;
    quantities.forEach(input => {
        if (parseInt(input.value) > 0) hasQuantity = true;
    });
    
    if (!hasQuantity) {
        e.preventDefault();
        alert('Please enter at least one product quantity');
        return false;
    }
    return true;
};
</script>
