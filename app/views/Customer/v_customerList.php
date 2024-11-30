<?php require APPROOT . '/views/inc/sysAdminHeader.php'; ?>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="<?php echo URLROOT; ?>/Dashboard"><i class="fas fa-th"></i>Dashboard</a></li>
            <li><a href="<?php echo URLROOT; ?>/User"><i class="fas fa-user"></i>User Management</a></li>
            <li><a href="<?php echo URLROOT; ?>/Product"><i class="fas fa-truck"></i>Product Management</a></li>
            <li><a href="<?php echo URLROOT; ?>/Customer" class="active"><i class="fas fa-users"></i>Customer Management</a></li>
            <li><a href="<?php echo URLROOT; ?>/Order"><i class="fas fa-eye"></i>View Orders</a></li>
        </ul>
        <div class="logo">
            <!-- Updated image path -->
            <img src="<?php echo URLROOT; ?>/public/img/logo.jpg" alt="Logo">
        </div>
        <div class="logout">
            <button onclick="location.href='<?php echo URLROOT; ?>/User/logout'">Logout</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="sub-container-2">
        <div class="header">
            <div class="user-info">
                <div>
                    <span><?php echo $_SESSION['user_name']; ?></span>
                    <span><?php echo $_SESSION['user_role']; ?></span>
                </div>
                <div>
                    <!-- Updated profile image path -->
                    <img src="<?php echo URLROOT; ?>/public/img/admin-profile.png" alt="User Avatar">
                </div>
            </div>
        </div>

        <div class="dashboard">
            <p><i class="fas fa-users"></i>&nbsp; Customer Management</p>
        </div>

        <div class="table-elements">
            <div class="role-details">
                <div class="users">
                    <h2>Customer Details Table</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Customer Id</th>
                            <th>Full Name</th>
                            <th>Address</th>
                            <th>Contact No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['customers'] as $customer): ?>
                            <tr>
                                <td><?php echo $customer->customer_id; ?></td>
                                <td><?php echo $customer->full_name; ?></td>
                                <td><?php echo $customer->address; ?></td>
                                <td><?php echo $customer->contact_no; ?></td>
                                <td class="action-icons">
                                    <a href="<?php echo URLROOT; ?>/Customer/edit/<?php echo $customer->customer_id; ?>" class="edit" title="Edit">&#9998;</a>
                                    <a href="<?php echo URLROOT; ?>/Customer/delete/<?php echo $customer->customer_id; ?>" class="delete" title="Delete">&#128465;</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="new-buttons">
                    <button onclick="location.href='<?php echo URLROOT; ?>/Customer/add'">Add New Customer</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
