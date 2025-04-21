<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f1ec;
        }

        .header {
            background-color: #c98d83;
            color: #ffffff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px;
            margin-left: 150px;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.8rem;
        }

        .header-left i {
            font-size: 1.8rem;
            color: #ffffff;
        }

        .header-role {
            font-size: 1.2rem;
            font-weight: normal;
            color: #ffffff;
            text-align: right;
        }

        .content {
            margin-left: 150px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-bar input {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .search-bar button {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #c98d83;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #783b31;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #c98d83;
            color: white;
        }

        table td {
            background-color: #ffffff;
        }

        .status-badge.active {
            color: green;
            font-weight: bold;
        }

        .status-badge.inactive {
            color: red;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #999;
        }
    </style>
</head>
<body>
<div class="container">
    <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

    <header class="header">
        <div class="header-left">
            <i class="fas fa-users"></i>
            <span>Customer Management</span>
        </div>
        <div class="header-role">
            <span>System Administrator</span>
        </div>
    </header>

    <div class="content">
        <div class="search-bar">
            <input type="text" id="searchCustomerInput" placeholder="Search Customer by name...">
            <button onclick="searchCustomer()">Search</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="customerTable">
                <?php if(isset($data['customers']) && !empty($data['customers'])) : ?>
                    <?php foreach($data['customers'] as $customer) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer->customer_name); ?></td>
                            <td><?php echo htmlspecialchars($customer->email ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($customer->customer_contact ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($customer->customer_address ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($customer->customer_gender ?? '-'); ?></td>
                            <td>
                                <span class="status-badge <?php echo strtolower($customer->customer_status); ?>">
                                    <?php echo htmlspecialchars($customer->customer_status); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-data">No customers found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function searchCustomer() {
    const input = document.getElementById('searchCustomerInput').value.toLowerCase();
    const table = document.getElementById('customerTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const nameCell = rows[i].getElementsByTagName('td')[0]; // Name is in first column
        if (nameCell) {
            const name = nameCell.textContent.toLowerCase();
            rows[i].style.display = name.includes(input) ? '' : 'none';
        }
    }
}
</script>

</body>
</html>
