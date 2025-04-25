<style>
    /* Updated Sidebar Styling to match design system */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 65px;
        background-color: var(--primary-dark);
        color: var(--neutral-white); /* Set base text color to white */
        transition: width 0.3s ease;
        z-index: 100;
        box-shadow: var(--shadow-md);
        overflow-x: hidden;
    }
    
    .sidebar.expanded {
        width: 220px;
    }
    
    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: var(--space-md);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        height: 65px;
    }
    
    .logo {
        height: 40px;
        width: auto;
        transition: all 0.3s ease;
    }
    
    .sidebar.expanded .logo {
        transform: scale(1.1);
    }
    
    .sidebar nav {
        padding: var(--space-md) 0;
    }
    
    .sidebar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    
    .sidebar li {
        margin-bottom: var(--space-xs);
    }
    
    .sidebar a {
        display: flex;
        align-items: center;
        padding: var(--space-sm) var(--space-md);
        color: white; /* Changed from var(--neutral-light) to white */
        text-decoration: none;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
        white-space: nowrap;
    }
    
    .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white; /* Ensure hover state maintains white */
    }
    
    .sidebar a.active {
        background-color: rgba(255, 255, 255, 0.15);
        color: white; /* Ensure active state maintains white */
        border-left: 3px solid var(--secondary-main);
    }
    
    .sidebar i {
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
        margin-right: var(--space-md);
        color: white; /* Explicitly set icon color to white */
    }
    
    .sidebar span {
        font-size: 0.9rem;
        font-weight: 500;
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.3s ease;
        color: white; /* Explicitly set span color to white */
    }
    
    .sidebar.expanded span {
        opacity: 1;
        transform: translateX(0);
    }
    
    /* Update the toggle button styles to better center the icon */
    .toggle-btn {
        position: absolute;
        bottom: var(--space-lg);
        left: 0;
        right: 0;
        margin: 0 auto;
        width: 30px;
        height: 30px;
        background-color: var(--primary-main);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        z-index: 101;
        padding: 0; /* Remove any padding */
    }

    .toggle-btn i {
        color: var(--neutral-white);
        font-size: 0.8rem;
        transition: transform 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        margin: 0; /* Remove margins */
        line-height: 1; /* Reset line height */
        text-align: center;
        position: relative; /* Allow positioning adjustments */
    }

    .sidebar-tooltip {
        position: absolute;
        left: 65px;
        background-color: var(--neutral-dark);
        color: var(--neutral-white);
        padding: var(--space-xs) var(--space-sm);
        border-radius: var(--radius-md);
        font-size: 0.8rem;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        pointer-events: none;
        white-space: nowrap;
        z-index: 1000;
    }
    
    .sidebar-tooltip::before {
        content: '';
        position: absolute;
        top: 50%;
        left: -5px;
        transform: translateY(-50%);
        border-width: 5px 5px 5px 0;
        border-style: solid;
        border-color: transparent var(--neutral-dark) transparent transparent;
    }
    
    .sidebar a:hover .sidebar-tooltip {
        opacity: 1;
        visibility: visible;
    }
    
    .sidebar.expanded .sidebar-tooltip {
        display: none;
    }
    
    /* Add this to adjust content for sidebar */
    .container {
        padding-left: 65px;
        transition: padding-left 0.3s ease;
    }
    
    .sidebar.expanded + .container {
        padding-left: 220px;
    }
    
    @media (max-width: 768px) {
        .sidebar {
            width: 0;
        }
        
        .sidebar.expanded {
            width: 220px;
        }
        
        .container {
            padding-left: 0;
        }
        
        .sidebar.expanded + .container {
            padding-left: 0;
        }
        
        .toggle-btn {
            left: auto;
            right: -15px;
            top: 15px;
            bottom: auto;
            width: 35px;
            height: 35px;
        }
        
        .toggle-btn i {
            font-size: 0.9rem; /* Slightly larger for mobile */
        }
    }

    .header-role {
        display: flex;
        align-items: center;
        gap: var(--space-xs);
        background-color: var(--primary-light);
        color: var(--primary-dark);
        padding: var(--space-xs) var(--space-md);
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .header-role i {
        font-size: 1rem;
    }

    .header-role-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background-color: var(--primary-main);
        color: var(--neutral-white);
        border-radius: var(--radius-full);
        font-size: 0.9rem;
    }
</style>

<aside class="sidebar">
    <div class="logo-container">
        <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/frostine-logo.png" alt="Logo" class="logo">
    </div>
    <nav>
        <ul>
            <li><a href="<?php echo URLROOT; ?>/SysAdmin/Dashboard"><i class="fas fa-th-large"></i></a></li>
            <li><a href="<?php echo URLROOT; ?>/SysAdmin/EmployeeManagement"><i class="fas fa-user-tie"></i></a></li>
            <li><a href="<?php echo URLROOT; ?>/SysAdminP/CustomerManagement"><i class="fas fa-users"></i></a></li>
            <li><a href="<?php echo URLROOT; ?>/SysAdminP/CategoryManagement"><i class="fas fa-tags"></i></a></li>  
            <li><a href="<?php echo URLROOT; ?>/SysAdminP/ProductManagement"><i class="fas fa-cookie-bite"></i></a></li>  
            <li><a href="<?php echo URLROOT; ?>/SysAdminP/promotionManagement"><i class="fas fa-percentage"></i></a></li>      
            <li><a href="<?php echo URLROOT; ?>/SysAdminP/BranchManagement"><i class="fas fa-store"></i></a></li>
            <li><a href="<?php echo URLROOT; ?>/Login/indexx"><i class="fas fa-sign-out-alt"></i></a></li>
        </ul>
    </nav>
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
                'fa-th-large': 'Dashboard',
                'fa-user-tie': 'Employee Management',
                'fa-users': 'Customer Management',
                'fa-tags': 'Category Management',
                'fa-cookie-bite': 'Product Management',
                'fa-percentage': 'Promotion Management',
                'fa-store': 'Branch Management',
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
            const href = item.getAttribute('href');
            // Check if current URL contains the href path
            if (currentPath.includes(href.split('/').pop())) {
                item.classList.add('active');
            }
        });
    });
</script>