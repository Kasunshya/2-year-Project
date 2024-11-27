<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/editTable.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-container">
        <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
        </div>
        <nav>
        <ul>
                <li><a href="<?php echo URLROOT;?>/BranchM/addCashier"><i class="fas fa-home"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/editTable"><i class="fas fa-boxes"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/DailyOrder"><i class="fas fa-edit"></i></a></li>
                <li><a href="<?php echo URLROOT;?>/BranchM/salesReport"><i class="fas fa-chart-bar"></i></a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
</aside>
<main style="margin-left: 100px; padding: 20px; flex: 1; overflow-y: auto; background-image: url(' <?php echo URLROOT;?>/public/img/BranchManger/background.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
            <!-- Table -->
            <div class="table-container">
            <h1>Cashier Profiles</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Join Date</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php foreach ($data['cashiers'] as $cashier): ?>
                <tr>
                    <td><?php echo $cashier->Name; ?></td>
                    <td><?php echo $cashier->ID; ?></td>
                    <td><?php echo $cashier->Contact; ?></td>
                    <td><?php echo $cashier->Address; ?></td>
                    <td><?php echo $cashier->Email; ?></td>
                    <td><?php echo $cashier->Join_Date; ?></td>
                    <td><?php echo $cashier->Password; ?></td>
                    <td>
                        <a href="<?php echo URLROOT; ?>/BranchM/updateCashier/<?php echo $cashier->ID; ?>" class=" btn update-btn">Update</a>
                        <a href="<?php echo URLROOT; ?>/BranchM/deleteCashier/<?php echo $cashier->ID; ?>" class=" btn delete-btn" onclick="return confirm('Are you sure you want to delete this cashier?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>