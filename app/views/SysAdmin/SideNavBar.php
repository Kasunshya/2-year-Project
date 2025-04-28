<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Connect the CSS file -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SystemAdmin/SideNavBar.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="logo-container">
             <img src="<?php echo URLROOT; ?>/public/img/HeadM/frostinelogo2.png" alt="Logo" class="logo">
          
        </div>
        <nav>
            <ul>
                <li>
                    <a href="<?php echo URLROOT;?>/SysAdmin/dashboard" class="<?php echo ($_SERVER['REQUEST_URI'] == URLROOT.'/SysAdmin/dashboard') ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URLROOT;?>/SysAdmin/employeeManagement" class="<?php echo ($_SERVER['REQUEST_URI'] == URLROOT.'/SysAdmin/employeeManagement') ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i>
                        <span>Employee Management</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URLROOT;?>/SysAdminP/customerManagement" class="<?php echo ($_SERVER['REQUEST_URI'] == URLROOT.'/SysAdmin/customerManagement') ? 'active' : ''; ?>">
                        <i class="fas fa-user-friends"></i>
                        <span>Customer Management</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URLROOT;?>/SysAdminP/productManagement" class="<?php echo ($_SERVER['REQUEST_URI'] == URLROOT.'/SysAdmin/productManagement') ? 'active' : ''; ?>">
                        <i class="fas fa-cookie"></i>
                        <span>Product Management</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URLROOT;?>/SysAdminP/categoryManagement" class="<?php echo ($_SERVER['REQUEST_URI'] == URLROOT.'/SysAdmin/categoryManagement') ? 'active' : ''; ?>">
                        <i class="fas fa-tags"></i>
                        <span>Category Management</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URLROOT;?>/SysAdminP/promotionManagement" class="<?php echo ($_SERVER['REQUEST_URI'] == URLROOT.'/SysAdmin/promotionManagement') ? 'active' : ''; ?>">
                        <i class="fas fa-percentage"></i>
                        <span>Promotion Management</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URLROOT;?>/SysAdminP/branchManagement" class="<?php echo ($_SERVER['REQUEST_URI'] == URLROOT.'/SysAdmin/branchManagement') ? 'active' : ''; ?>">
                        <i class="fas fa-building"></i>
                        <span>Branch Management</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URLROOT;?>/Users/logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="toggle-btn">
            <i class="fas fa-chevron-right"></i>
        </div>
    </aside>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.toggle-btn');

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('expanded');
                const chevronIcon = toggleBtn.querySelector('i');
                
                if (sidebar.classList.contains('expanded')) {
                    chevronIcon.classList.remove('fa-chevron-right');
                    chevronIcon.classList.add('fa-chevron-left');
                } else {
                    chevronIcon.classList.remove('fa-chevron-left');
                    chevronIcon.classList.add('fa-chevron-right');
                }
            });
        });
    </script>
</body>
</html>