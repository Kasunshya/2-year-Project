<?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/editTable.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<body>
    <!-- Sidebar >
    <aside class="sidebar">
        <div class="logo-container">
        <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
        </div>
        <nav>
        <ul>
                <li><a href="<!?php echo URLROOT;?>/BranchM/branchmdashboard"><i class="fas fa-home"></i></a></li>
                <li><a href="<!?php echo URLROOT;?>/BranchM/viewCashiers"><i class="fas fa-boxes"></i></a></li>
                <li><a href="<!?php echo URLROOT;?>/BranchM/addCashier"><i class="fas fa-edit"></i></a></li>
                <li><a href="<!?php echo URLROOT;?>/BranchM/DailyOrder"><i class="fas fa-tasks"></i></a></li>
                <li><a href="<!?php echo URLROOT;?>/BranchM/salesReport"><i class="fas fa-chart-bar"></i></a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
</aside-->
<header>
      <div class="header-container">
      <h7> <i class="fas fa-boxes">&nbsp</i> Cashier Profiles</h7>
          
        </div>
      </div>
    </header>
            <!-- Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="color: #783b31;">Name</th>
                            <th style="color: #783b31;">Address</th>
                            <th style="color: #783b31;">Contacts</th>
                            <th style="color: #783b31;">Join_Date</th>
                            <th style="color: #783b31;">Branch Name</th>
                            <th style="color: #783b31;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['cashiers'] as $cashier):?>
                    <tr>
                           <td><?php echo htmlspecialchars($cashier->cashier_name); ?></td>
                            <td><?php echo htmlspecialchars($cashier->address); ?></td>
                            <td><?php echo htmlspecialchars($cashier->contacts); ?></td>
                            <td><?php echo htmlspecialchars($cashier->join_date); ?></td>
                            <td><?php echo htmlspecialchars($cashier->branch_name); ?></td>
                        <td>

    <a href="<?php echo URLROOT; ?>/BranchM/updateCashier/<?php echo htmlspecialchars($cashier->cashier_id); ?>" class="btn update-btn">Update</a>
    <form action="<?php echo URLROOT; ?>/BranchM/deleteCashier/<?php echo htmlspecialchars($cashier->cashier_id); ?>" method="POST" style="display:inline;">
    <button type="submit" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this cashier?');">Delete</button>
</form>
</td>

                    </td>
                </tr>
            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </main>
        </div>
</body>