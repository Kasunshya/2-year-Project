<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SystemAdmin/main.css">
    <title>Employee Management</title>
</head>
<body>
    <div class="container">
    
        <?php require_once APPROOT.'/views/SysAdmin/SideNavBar.php'; ?>

        <div class="sub-container-2">
            <div class="header">
                <div class="page-title">
                    <span>&nbsp;&nbsp;<i class="fas fa-th"></i>&nbsp;Dashboard</span>
                </div>
                <div class="user-info">
                    <div>
                        <span>System Administrator</span>
                    </div>
                </div>
            </div>
            <div class="body-elements">
                <div class="body-elements-1">
                    <div class="users">
                        <h2>Team Members</h2>
                        <div class="team-grid">
                            <div class="team-member">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/team1.jpeg" alt="Sarah">
                                <span class="member-name">Sarah Chen</span>
                                <!-- <span class="member-role">UI Designer</span> -->
                            </div>
                            <div class="team-member">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/team2.jpg" alt="Jerome">
                                <span class="member-name">Jerome Phillips</span>
                                <!-- <span class="member-role">Developer</span> -->
                            </div>
                            <div class="team-member">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Anna">
                                <span class="member-name">Anna Smith</span>
                                <!-- <span class="member-role">Project Manager</span> -->
                            </div>
                            <div class="team-member">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/team3.jpg" alt="Maya">
                                <span class="member-name">Maya Patel</span>
                                <!-- <span class="member-role">UX Designer</span> -->
                            </div>
                            <div class="team-member">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/team4.jpg" alt="David">
                                <span class="member-name">David Kim</span>
                                <!-- <span class="member-role">Backend Dev</span> -->
                            </div>
                            <div class="team-member">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/team5.jpg" alt="Lisa">
                                <span class="member-name">Lisa Wang</span>
                                <!-- <span class="member-role">Data Analyst</span> -->
                            </div>
                            <div class="team-member">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/team6.jpg" alt="Michael">
                                <span class="member-name">Michael Torres</span>
                                <!-- <span class="member-role">Frontend Dev</span> -->
                            </div>
                            <div class="team-member">
                                <img src="<?php echo URLROOT; ?>/public/img/SysAdmin/user-profile.jpg" alt="Emma">
                                <span class="member-name">Emma Wilson</span>
                                <!-- <span class="member-role">QA Engineer</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="products">
                        <h2>Top Products</h2>
                        <div class="product-item">
                            <div class="item">
                                <img src="<?php echo URLROOT; ?>/public/img/Customer/product-2.jpg" alt="Honey Waffles">
                                <p>Honey Waffles</p>
                            </div>
                            <div class="item">
                                <img src="<?php echo URLROOT; ?>/public/img/Customer/product-3.jpg" alt="Butter & Honey Bread">
                                <p>Butter & Honey Bread</p>
                            </div>
                            <div class="item">
                                <img src="<?php echo URLROOT; ?>/public/img/Customer/product-6.jpg" alt="Strawberry Pancake">
                                <p>Strawberry Pancake</p>
                            </div>
                            <div class="item">
                                <img src="<?php echo URLROOT; ?>/public/img/Customer/product-2.jpg" alt="Honey Waffles">
                                <p>Honey Waffles</p>
                            </div>
                            <div class="item">
                                <img src="<?php echo URLROOT; ?>/public/img/Customer/product-3.jpg" alt="Butter & Honey Bread">
                                <p>Butter & Honey Bread</p>
                            </div>
                        </div>
                    </div>

                    <div class="overview">
                        <div class="card">
                            <h2>15</h2>
                            <p>Total Users</p>
                        </div>
                        <div class="card">
                            <h2>120</h2>
                            <p>Total Products</p>
                        </div>
                        <div class="card">
                            <h2>350</h2>
                            <p>Total Customers</p>
                        </div>
                    </div>

                </div>
                <div class="calendar">
                    <h2>Holiday Dates</h2>
                    <div class="calendar-cards">
                        <div class="date-card">
                            <h3>January</h3>
                            <ul>
                                <li>1st - New Year's Day</li>
                                <li>14th - Thai Pongal</li>
                            </ul>
                        </div>
                        <div class="date-card">
                            <h3>April</h3>
                            <ul>
                                <li>13th - Sinhala New Year</li>
                                <li>14th - Good Friday</li>
                            </ul>
                        </div>
                        <div class="date-card">
                            <h3>May</h3>
                            <ul>
                                <li>1st - Labor Day</li>
                                <li>5th - Vesak Full Moon</li>
                            </ul>
                        </div>
                        <div class="date-card">
                            <h3>December</h3>
                            <ul>
                                <li>25th - Christmas</li>
                                <li>31st - New Year's Eve</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
