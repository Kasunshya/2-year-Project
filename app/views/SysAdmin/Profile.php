<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<main class="main-content">
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h2><?php echo $data['employee']->full_name ?? 'N/A'; ?></h2>
            <span class="employee-id">ID: <?php echo $data['employee']->employee_id ?? 'N/A'; ?></span>
        </div>

        <div class="profile-details">
            <section>
                <h3>Personal Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Email</label>
                        <p><?php echo $data['employee']->email ?? 'N/A'; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Contact Number</label>
                        <p><?php echo $data['employee']->contact_no ?? 'N/A'; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Address</label>
                        <p><?php echo $data['employee']->address ?? 'N/A'; ?></p>
                    </div>
                    <div class="info-item">
                        <label>NIC</label>
                        <p><?php echo $data['employee']->nic ?? 'N/A'; ?></p>
                    </div>
                </div>
            </section>

            <section>
                <h3>Employment Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Role</label>
                        <p>System Administrator</p>
                    </div>
                    <div class="info-item">
                        <label>Join Date</label>
                        <p><?php echo isset($data['employee']->join_date) ? date('F j, Y', strtotime($data['employee']->join_date)) : 'N/A'; ?></p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
</body>
</html>
