<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Head Manager Customization</title>
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

            <div class="content">
                <!-- Customization Table -->
                <div class="customization-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" placeholder="Search by Customisation ID">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Customization ID</th>
                                    <th>Customer ID</th>
                                    <th>Flavor</th>
                                    <th>Size</th>
                                    <th>Toppings</th>
                                    <th>Custom Message</th>
                                    <th>Delivery Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>C001</td>
                                    <td>101</td>
                                    <td>Vanilla</td>
                                    <td>Medium</td>
                                    <td>Chocolate Chips, Nuts</td>
                                    <td>Happy Birthday, John!</td>
                                    <td>2024-12-17</td>
                                    <td>
                                        <button class="btn edit">Confirm</button>
                                        <button class="btn delete">Completed</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>C002</td>
                                    <td>102</td>
                                    <td>Chocolate</td>
                                    <td>Large</td>
                                    <td>Fresh Fruits, Sprinkles</td>
                                    <td>Happy Anniversary!</td>
                                    <td>2024-12-12</td>
                                    <td>
                                        <button class="btn edit">Confirm</button>
                                        <button class="btn delete">Completed</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>C003</td>
                                    <td>103</td>
                                    <td>Red Velvet</td>
                                    <td>Small</td>
                                    <td>Nuts</td>
                                    <td>Congratulations!</td>
                                    <td>2024-12-15</td>
                                    <td>
                                        <button class="btn edit">Confirm</button>
                                        <button class="btn delete">Completed</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/Customization.js"></script>
</body>

</html>