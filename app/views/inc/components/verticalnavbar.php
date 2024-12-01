<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/verticalnavbar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
 
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-container">
            <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
        </div>
        <nav>
        <ul>
        <li><a href="<?php echo URLROOT;?>/BranchM/branchmdashboard"><i class="fas fa-home"></i></a></li>
        <li><a href="<?php echo URLROOT;?>/BranchM/viewCashiers"><i class="fas fa-boxes"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/addCashier"><i class="fas fa-edit"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/DailyOrder"><i class="fas fa-tasks"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/salesReport"><i class="fas fa-chart-bar"></i></a></li>
                <li><a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a></i></a></li>
            </ul>
        </div>
       
    </aside>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.createElement('div');
        toggleBtn.classList.add('toggle-btn');
        toggleBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        sidebar.appendChild(toggleBtn);

        // Add labels to sidebar items
        const sidebarItems = sidebar.querySelectorAll('nav ul li a');
        sidebarItems.forEach(item => {
            const icon = item.querySelector('i');
            const label = document.createElement('span');

            // Map of icons to labels
            const labelMap = {
                'fa-home': 'Dashboard',
                'fa-boxes': 'Cashier Profiles',
                'fa-edit': 'Add cashier',
                'fa-tasks': 'Daily Order',
                'fa-chart-bar': 'Sales Reports',
                'fa-sign-out-alt': 'Logout'
            };

            // Find the corresponding label
            for (let [iconClass, labelText] of Object.entries(labelMap)) {
                if (icon.classList.contains(iconClass)) {
                    label.textContent = labelText;
                    break;
                }
            }

            item.appendChild(label);

            // Create tooltip for mobile devices
            const tooltip = document.createElement('div');
            tooltip.classList.add('sidebar-tooltip');
            tooltip.textContent = label.textContent;
            item.appendChild(tooltip);
        });

        // Toggle sidebar expansion
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('expanded');

             // Rotate toggle button icon
             const chevronIcon = toggleBtn.querySelector('i');
            if (sidebar.classList.contains('expanded')) {
                chevronIcon.classList.remove('fa-chevron-right');
                chevronIcon.classList.add('fa-chevron-left');
            } else {
                chevronIcon.classList.remove('fa-chevron-left');
                chevronIcon.classList.add('fa-chevron-right');
            }
        });

        // Highlight active page
        const currentPath = window.location.pathname;
        sidebarItems.forEach(item => {
            if (item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            }
        });

        // Logout functionality
        const logoutLink = document.querySelector('a[href="#"]');
        if (logoutLink) {
            logoutLink.addEventListener('click', function (e) {
                e.preventDefault();
                // Implement logout logic here
                // For example:
                // window.location.href = '<?php echo URLROOT; ?>/logout';
                alert('Logout functionality to be implemented');
            });
        }
});
</script>

