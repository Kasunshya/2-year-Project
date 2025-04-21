<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Head Manager - Daily Branch Orders</title>
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
                <h1><i class="fas fa-calendar-check"></i>&nbsp DAILY BRANCH ORDERS</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
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
                                                <button class="btn approve">Approve</button>
                                                <button class="btn reject">Reject</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No orders found.</td>
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