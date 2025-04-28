<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Orders</title>
    <?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/branchmdashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/DailyOrder.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Background color styling */
        body {
            background-color: #f8e5f4;
        }
        
        .main-content {
            background-color: #;
            min-height: 100vh;
            
        }
        
        /* Match header styling */
        header {
            background-color: #5d2e46;
            padding: 2rem;
            color: white;
            font-size: 2.5rem;
            text-transform: uppercase;
            margin-left: 30px;
            margin-right: 30px; /* Keep this value */
            border-radius: 5px;
            margin-top: 10px;
            z-index: 1;
            text-align: left;
        }

        header h7 {
            padding-left: 15px; /* Add some padding to the left of the text */
            display: inline-block;
            text-align: left;
            margin: 0;
        }

        header i {
            margin-right: 10px;
            text-align: left;
            display: inline-block;
            vertical-align: middle; /* Vertically align the icon with the text */
        }
        
        

        /* Order container styling - aligned with header */
        .order-container {
            width: calc(100% - 80px); /* Calculate width based on margins */
            margin-left: 30px;  /* Match header left margin */
            margin-right: 30px; /* Match header right margin */
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Order form styling */
        .order-form {
            background-color: #fff;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            margin-right: 0; /* Remove this as it's causing the misalignment */
        }
        
        /* Form header styling */
        .form-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .form-group {
            flex: 1;
            min-width: 250px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #5d2e46;
        }
        
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-group textarea {
            height: 120px;
            resize: vertical;
        }
        
        /* Table styling matching with reports page */
        .products-table table, .current-orders table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .products-table th, .current-orders th {
            background-color: #a26b98;
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            border: none;
        }
        
        .products-table th:first-child, .current-orders th:first-child {
            border-top-left-radius: 4px;
        }
        
        .products-table th:last-child, .current-orders th:last-child {
            border-top-right-radius: 4px;
        }
        
        .products-table td, .current-orders td {
            background-color: white;
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .products-table tbody tr:hover td, .current-orders tbody tr:hover td {
            background-color: #f9f5f0;
        }
        
        /* Button styling matching with report page */
        .form-actions {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }
        
        .btn-submit, .btn-reset {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-submit {
            background-color: #a26b98;
            color: white;
            border: none;
        }
        
        .btn-submit:hover {
            background-color: #5d2e46;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-reset {
            background-color: transparent;
            border: 1px solid #e0e0e0;
            color: #555;
        }
        
        .btn-reset:hover {
            background-color: #f9f5f0;
            border-color: #a26b98;
        }
        
        /* Current Orders section styling */
        .current-orders {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .current-orders h2 {
            color: #5d2e46;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        
        /* Status styling */
        .status-pending {
            background-color: #f1c778;
            color: #5d2e46;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .status-approved {
            background-color: #79c879;
            color: #000;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .status-rejected {
            background-color: #e27979;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        /* Quantity input styling */
        .quantity-input {
            width: 80px;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            text-align: center;
        }
        
        .quantity-input:focus {
            outline: none;
            border-color: #a26b98;
            box-shadow: 0 0 0 2px rgba(162, 107, 152, 0.2);
        }
        
        /* Responsive adjustments */
        @media (max-width: 1200px) {
            header, .order-container {
                margin-left: 100px;
                margin-right: 30px;
            }
        }
        
        @media (max-width: 768px) {
            header, .order-container {
                margin-left: 50px;
                margin-right: 20px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn-submit, .btn-reset {
                width: 100%;
            }
        }

        .current-orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .current-orders-table th,
        .current-orders-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .current-orders-table th {
            background-color: #a26b98;
            color: white;
        }

        .current-orders-table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="main-content">
        <header><h7><i class="fas fa-tasks"></i> Daily Orders</h7></header>

        <?php flash('order_message'); ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Detect flash messages and show with SweetAlert instead
            const flashMessage = document.querySelector('.alert');
            if (flashMessage) {
                const isError = flashMessage.classList.contains('alert-danger');
                const message = flashMessage.textContent.trim();
                
                if (message) {
                    Swal.fire({
                        title: isError ? 'Error!' : 'Success!',
                        text: message,
                        icon: isError ? 'error' : 'success',
                        confirmButtonColor: '#a26b98'
                    });
                    
                    // Hide the original flash message
                    flashMessage.style.display = 'none';
                }
            }
        });
        </script>

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
                                                   onchange="updateDescription()">
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

            <div class="current-orders">
                <h2>Today's Orders</h2>
                <div id="orders-container">
                    <table class="current-orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Description</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($data['orders']) && !empty($data['orders'])): ?>
                                <?php foreach($data['orders'] as $order): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($order->dailybranchorder_id); ?></td>
                                        <td><?php echo htmlspecialchars($order->description); ?></td>
                                        <td><?php echo htmlspecialchars($order->orderdate); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3">No orders found for today</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Your existing JavaScript
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
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please enter at least one product quantity',
                    icon: 'warning',
                    confirmButtonColor: '#a26b98'
                });
                return false;
            }
            return true;
        };

        // Replace the existing setupAutoRefresh and updateOrdersTable functions

        function setupAutoRefresh() {
            fetchUpdatedOrders(); // Initial load
            setInterval(fetchUpdatedOrders, 2000); // Check every 2 seconds
        }

        function fetchUpdatedOrders() {
            fetch(`${URLROOT}/Branch/getUpdatedOrders`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received orders:', data); // Debug log
                    if (data.orders) {
                        updateOrdersTable(data.orders);
                    }
                })
                .catch(error => {
                    console.error('Error fetching orders:', error);
                });
        }

        function updateOrdersTable(orders) {
            const tbody = document.querySelector('.current-orders table tbody');
            if (!tbody) return;

            if (!orders || orders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">No orders found for today</td></tr>';
                return;
            }

            tbody.innerHTML = orders.map(order => {
                // Ensure status has a value, default to 'pending'
                const status = (order.status || 'pending').toLowerCase();
                const statusText = status.charAt(0).toUpperCase() + status.slice(1);
                
                return `
                    <tr>
                        <td>${escapeHtml(order.dailybranchorder_id)}</td>
                        <td>${escapeHtml(order.description)}</td>
                        <td>${escapeHtml(order.orderdate)}</td>
                        <td>
                            <span class="status-${escapeHtml(status)}">
                                ${escapeHtml(statusText)}
                            </span>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Add this helper function for HTML escaping
        function escapeHtml(unsafe) {
            return unsafe
                .toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Add this line at the bottom of your script section
        document.addEventListener('DOMContentLoaded', setupAutoRefresh);
    </script>
</body>
</html>
