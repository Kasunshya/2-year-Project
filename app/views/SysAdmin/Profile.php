<?php require_once APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/profile.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<main class="main-content">
    <?php flash('profile_message'); ?>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h2><?php echo htmlspecialchars($data['employee']->full_name ?? 'N/A'); ?></h2>
            <span class="employee-id">ID: <?php echo htmlspecialchars($data['employee']->employee_id ?? 'N/A'); ?></span>
        </div>

        <div class="profile-details">
            <section>
                <h3>Personal Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Email</label>
                        <p><?php echo htmlspecialchars($data['employee']->email ?? 'N/A'); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Contact Number</label>
                        <p><?php echo htmlspecialchars($data['employee']->contact_no ?? 'N/A'); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Address</label>
                        <p><?php echo htmlspecialchars($data['employee']->address ?? 'N/A'); ?></p>
                    </div>
                    <div class="info-item">
                        <label>NIC</label>
                        <p><?php echo htmlspecialchars($data['employee']->nic ?? 'N/A'); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Date of Birth</label>
                        <p><?php echo htmlspecialchars($data['employee']->dob ?? 'N/A'); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Gender</label>
                        <p><?php echo htmlspecialchars($data['employee']->gender ?? 'N/A'); ?></p>
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
                        <p><?php echo $data['employee']->join_date ? date('F j, Y', strtotime($data['employee']->join_date)) : 'N/A'; ?></p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
