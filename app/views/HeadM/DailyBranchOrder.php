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
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by Date">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Daily Branch Order ID</th>
                                    <th>Branch Manager ID</th>
                                    <th>Date</th>
                                    <th>Products & Quantities</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>B001</td>
                                    <td>BM101</td>
                                    <td>2024-11-25</td>
                                    <td>
                                        <ul>
                                            <li>Butter and honey bread - 20</li>
                                            <li>Strawberry pancake - 12</li>
                                            <li>choclate cake - 09</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <button class="btn ready">Ready</button>
                                        <button class="btn confirm">Confirm</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>B002</td>
                                    <td>BM102</td>
                                    <td>2024-11-26</td>
                                    <td>
                                        <ul>
                                            <li>Chocolate cake - 30</li>
                                            <li>Honey pancake - 200 </li>
                                            <li>Honey waffles - 40</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <button class="btn ready">Ready</button>
                                        <button class="btn confirm">Confirm</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>B003</td>
                                    <td>BM103</td>
                                    <td>2024-11-27</td>
                                    <td>
                                        <ul>
                                            <li>Rose pink cake - 05</li>
                                            <li>Blueberry pancake - 100</li>
                                            <li>Honey waffles - 15</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <button class="btn ready">Ready</button>
                                        <button class="btn confirm">Confirm</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>