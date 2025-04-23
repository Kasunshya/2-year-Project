<div class="report-summary">
    <?php if (isset($data['report']) && !empty($data['report'])): ?>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Orders</th>
                    <th>Quantity Sold</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['report'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item->product_name); ?></td>
                        <td><?php echo htmlspecialchars($item->category_name); ?></td>
                        <td><?php echo $item->orders_count; ?></td>
                        <td><?php echo $item->total_sold; ?></td>
                        <td>$<?php echo number_format($item->revenue, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">No sales data available for this date.</div>
    <?php endif; ?>
</div>
