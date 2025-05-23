<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Frostine Head Manager - Daily Branch Orders</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT.'/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-calendar-check"></i>&nbsp Daily Branch Orders</h1>
                
            </header>

            <div class="content">
                <!-- Daily Branch Orders Table -->
                <div class="branch-orders-list">
                    <div class="search-bar">
                        <form method="GET" action="<?php echo URLROOT; ?>/HeadM/dailyBranchOrder" class="search-form">
                            <div class="search-field">
                                <input type="text" name="branch_name" placeholder="Search by Branch Name" value="<?php echo isset($_GET['branch_name']) ? htmlspecialchars($_GET['branch_name']) : ''; ?>">
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
                                <button class="btn search-btn" type="submit"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Description</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['orders'])): ?>
                                <?php foreach ($data['orders'] as $order): ?>
                                    <tr>
                                        <td><?php echo $order->branch_name; ?></td>
                                        <td><?php echo $order->description; ?></td>
                                        <td><?php echo $order->orderdate; ?></td>
                                        <td>
                                            <span class="status-<?php echo isset($order->status) ? $order->status : 'pending'; ?>">
                                                <?php echo isset($order->status) ? ucfirst($order->status) : 'Pending'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="updateOrderStatus(<?php echo $order->dailybranchorder_id; ?>, 'approved')">Accept</button>
                                            <button class="btn btn-danger btn-sm" onclick="updateOrderStatus(<?php echo $order->dailybranchorder_id; ?>, 'rejected')">Reject</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add JavaScript for approve/reject functionality -->
    <script>
    function updateOrderStatus(orderId, status) {
        Swal.fire({
            title: 'Confirm Action',
            text: `Are you sure you want to ${status} this order?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#a26b98',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, proceed'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('order_id', orderId);
                formData.append('status', status);

                fetch('<?php echo URLROOT; ?>/HeadM/updateOrderStatus', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to update status');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error.message,
                        icon: 'error'
                    });
                });
            }
        });
    }
    </script>
</body>

</html>