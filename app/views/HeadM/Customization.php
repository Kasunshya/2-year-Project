<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--title>Frostine Head Manager Customization</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Dashboard.css"-->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT.'/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-palette icon-customization"></i> CUSTOMIZED ORDERS</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>

                <!-- Customization Table -->
                <div class="customization-list">
                    <div class="search-bar">
                        <form method="GET" action="<?php echo URLROOT; ?>/HeadM/customization" class="search-form">
                            <div class="search-field">
                                <input type="text" name="customer_name" placeholder="Search by Customer Name" value="<?php echo isset($_GET['customer_name']) ? htmlspecialchars($_GET['customer_name']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <button class="btn search-btn" type="submit"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </form>
                    </div>
                    <section class="dashboard-content">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Flavor</th>
                                    <th>Size</th>
                                    <th>Toppings</th>
                                    <th>Premium Toppings</th>
                                    <th>Message</th>
                                    <th>Delivery Option</th>
                                    <th>Delivery Address</th>
                                    <th>Delivery Date</th>
                                    <th>Order Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['customizations'])): ?>
                                    <?php foreach ($data['customizations'] as $customization): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($customization->customer_name); ?></td>
                                            <td><?php echo htmlspecialchars($customization->flavor); ?></td>
                                            <td><?php echo htmlspecialchars($customization->size); ?></td>
                                            <td><?php echo htmlspecialchars($customization->toppings); ?></td>
                                            <td><?php echo htmlspecialchars($customization->premium_toppings); ?></td>
                                            <td><?php echo htmlspecialchars($customization->message); ?></td>
                                            <td><?php echo htmlspecialchars($customization->delivery_option); ?></td>
                                            <td><?php echo htmlspecialchars($customization->delivery_address); ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($customization->delivery_date)); ?></td>
                                            <td><?php echo htmlspecialchars($customization->order_status); ?></td>
                                            <td><?php echo date('Y-m-d H:i:s', strtotime($customization->created_at)); ?></td>
                                            <td class="actions">
                                                <button class="btn approve" onclick="updateStatus(<?php echo $customization->customization_id; ?>, 'approved')">
                                                    Approve
                                                </button>
                                                <button class="btn reject" onclick="updateStatus(<?php echo $customization->customization_id; ?>, 'rejected')">
                                                    Reject
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="12">No customizations found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                </div>
        </main>
    </div>
    
    <script>
        function updateStatus(customizationId, status) {
            if (confirm('Are you sure you want to ' + status + ' this customization order?')) {
                // Send AJAX request to update status
                fetch('<?php echo URLROOT; ?>/HeadM/updateCustomizationStatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        customization_id: customizationId,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Reload the page to show updated status
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the status');
                });
            }
        }
    </script>
</body>

</html>