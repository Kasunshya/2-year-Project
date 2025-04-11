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
            <input type="text" id="searchCustomerInput" placeholder="Search Customer by Email">
            <button onclick="searchCustomer()">Search</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>User ID</th>
                    <th>Customer Email</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Profile</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="customerTable">
                <tr>
                    <td>1</td>
                    <td>18</td>
                    <td>john.doe@example.com</td>
                    <td>Lalithra</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>Active</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>52</td>
                    <td>pasindu@example.com</td>
                    <td>Pasindu</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>Active</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>53</td>
                    <td>kavindya@example.com</td>
                    <td>Kavindya</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>Active</td>
                </tr>
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
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length > 0) {
                const customerEmail = cells[2].textContent.toLowerCase();
                if (customerEmail.includes(input)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>

</body>
</html>