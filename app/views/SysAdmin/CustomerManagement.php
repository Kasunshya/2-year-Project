<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/bakery-design-system.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>

.header {
          background-color: #5d2e46;
          padding: 2rem;
          text-align: center;
          color: var(--white);
          font-size: 2.5rem;
          text-transform: uppercase;
          margin-top: 10px;
          margin-left: 120px;
          margin-right: 20px;
          border-radius: 5px;
          width: 90%;
}

        /* Page-specific styles only */
        .table-container {
            margin: var(--space-lg) 0;
            overflow-x: auto;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-weight: 500;
            gap: 5px;
        }
        
        .status-badge.active {
            background-color: var(--success-light);
            color: var(--success-dark);
        }
        
        .status-badge.inactive {
            background-color: var(--error-light);
            color: var(--error-dark);
        }
        
        .status-badge i {
            font-size: 0.75rem;
        }
        
        .customer-info {
            display: flex;
            flex-direction: column;
        }
        
        .customer-name {
            font-weight: 500;
            color: var(--primary-dark);
        }
        
        .customer-email {
            font-size: 0.85rem;
            color: var(--neutral-dark);
            margin-top: var(--space-xs);
        }
        
        .export-btn {
            margin-left: var(--space-md);
        }
    </style>
</head>
<body>
<div class="sysadmin-page-container">
    <div class="container">
        <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

        <header class="header">
            <div class="header-left">
                <i class="fas fa-users"></i>
                <span>Customer Management</span>
            </div>
            
        </header>

        <div class="content">
            <?php flash('customer_message'); ?>
            
            <div class="search-bar">
                <form onsubmit="searchCustomer(); return false;">
                    <input type="text" 
                           class="form-control"
                           id="searchCustomerInput" 
                           placeholder="Search by customer name..." 
                           value="">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    
                    <?php if(isset($data['customers']) && !empty($data['customers'])) : ?>
                    <button type="button" class="btn export-btn" onclick="exportCustomerData()">
                        <i class="fas fa-file-export"></i> Export Data
                    </button>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="table-container">
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
                                    <td>
                                        <div class="customer-info">
                                            <span class="customer-name"><?php echo htmlspecialchars($customer->customer_name); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($customer->email ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($customer->customer_contact ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($customer->customer_address ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($customer->customer_gender ?? '-'); ?></td>
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
                                <td colspan="6" style="text-align: center;">No customers found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
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

function exportCustomerData() {
    // Create CSV content
    let csvContent = "data:text/csv;charset=utf-8,";
    
    // Add headers
    csvContent += "Name,Email,Contact,Address,Gender,Status\n";
    
    // Get table rows
    const table = document.getElementById('customerTable');
    const rows = table.getElementsByTagName('tr');
    
    // Loop through rows and add to CSV
    for (let i = 0; i < rows.length; i++) {
        if (rows[i].style.display !== 'none') {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length === 6) { // Only process rows with expected number of cells
                let rowData = [];
                
                // Get data from first 5 columns directly
                for (let j = 0; j < 5; j++) {
                    // Clean the data by removing extra whitespace and quotes
                    let cellText = cells[j].textContent.trim().replace(/"/g, '""');
                    rowData.push(`"${cellText}"`);
                }
                
                // Get status text without the icon
                const statusText = cells[5].textContent.trim().replace(/"/g, '""');
                rowData.push(`"${statusText}"`);
                
                csvContent += rowData.join(',') + '\n';
            }
        }
    }
    
    // Create download link
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', `customer_data_${new Date().toISOString().slice(0,10)}.csv`);
    document.body.appendChild(link);
    
    // Trigger download
    link.click();
    document.body.removeChild(link);
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.classList.add('fade-out');
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 5000);
    });
});
</script>
</body>
</html>
