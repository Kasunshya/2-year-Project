<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <?php require APPROOT.'/views/SysAdmin/SideNavBar.php'?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Typography */
        :root {
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        * {
            font-family: var(--font-family);
        }

        .customer-container {
            width: 90%;
            margin-left: 120px;
            margin-right: 30px;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #5d2e46;
            padding: 2rem;
            color: white;
            font-size: 2.5rem;
            text-transform: uppercase;
            margin-left: 120px;
            margin-right: 0px;
            border-radius: 5px;
            z-index: 1;
            text-align: left;
        }

        header i {
            margin-right: 10px;
            text-align: left;
            display: inline-block;
            vertical-align: middle;
        }

        body {
            background-color: #e8d7e5;
        }

        .customer-table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            border-radius: 4px;
            overflow: hidden;
        }

        .customer-table th {
            background-color: #a26b98;
            color: white;
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .customer-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .customer-table tbody tr:hover {
            background-color: #f9f5f0;
        }

        .search-container {
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-input {
            padding: 8px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            width: 300px;
        }

        .export-btn {
            background-color: #a26b98;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .export-btn:hover {
            background-color: #5d2e46;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            gap: 5px;
        }

        .status-badge.active {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-badge.inactive {
            background-color: #ffebee;
            color: #c62828;
        }

        .customer-info {
            display: flex;
            flex-direction: column;
        }

        .customer-name {
            font-weight: 500;
            color: #5d2e46;
        }

        .customer-email {
            font-size: 0.85rem;
            color: #666;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <header>
        <h7><i class="fas fa-users"></i>Customer Management</h7>
    </header>

    <div class="customer-container">
        <?php flash('customer_message'); ?>

        <div class="search-container">
            <input type="text" 
                   class="search-input" 
                   id="searchCustomer" 
                   placeholder="Search customer...">
            <button class="export-btn" onclick="exportCustomerData()">
                <i class="fas fa-file-export"></i> Export Data
            </button>
        </div>

        <table class="customer-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($data['customers']) && !empty($data['customers'])) : ?>
                    <?php foreach($data['customers'] as $customer) : ?>
                        <tr>
                            <td>
                                <div class="customer-info">
                                    <span class="customer-name"><?php echo htmlspecialchars($customer->customer_name); ?></span>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($customer->email ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($customer->customer_contact ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($customer->customer_address ?? '-'); ?></td>
                            <td>
                                <span class="status-badge <?php echo strtolower($customer->customer_status); ?>">
                                    <i class="fas <?php echo strtolower($customer->customer_status) === 'active' ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                    <?php echo htmlspecialchars($customer->customer_status); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No customers found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('searchCustomer').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let rows = document.querySelectorAll('.customer-table tbody tr');
            
            rows.forEach(row => {
                let name = row.cells[0].textContent.toLowerCase();
                let email = row.cells[1].textContent.toLowerCase();
                let contact = row.cells[2].textContent.toLowerCase();
                
                if (name.includes(searchText) || 
                    email.includes(searchText) || 
                    contact.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function exportCustomerData() {
            // Get table data
            const table = document.querySelector('.customer-table');
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            
            // Create CSV content
            let csvContent = 'Name,Email,Contact,Address,Status\n';
            
            rows.forEach(row => {
                // Skip the "No customers found" row if it exists
                if (row.cells.length === 1) return;
                
                const name = row.cells[0].textContent.trim();
                const email = row.cells[1].textContent.trim();
                const contact = row.cells[2].textContent.trim();
                const address = row.cells[3].textContent.trim();
                const status = row.cells[4].textContent.trim();
                
                // Escape commas and quotes in the data
                const escapedRow = [name, email, contact, address, status].map(cell => {
                    if (cell.includes(',') || cell.includes('"') || cell.includes('\n')) {
                        return `"${cell.replace(/"/g, '""')}"`;
                    }
                    return cell;
                });
                
                csvContent += escapedRow.join(',') + '\n';
            });
            
            // Create and trigger download
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', 'customers_' + new Date().toISOString().split('T')[0] + '.csv');
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Show success message
            Swal.fire({
                title: 'Success!',
                text: 'Customer data has been exported successfully',
                icon: 'success',
                confirmButtonColor: '#a26b98'
            });
        }
    </script>
</body>
</html>
