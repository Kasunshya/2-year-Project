<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/profile.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    * {
        text-transform: lowercase !important;
    }
</style>

<main class="main-content">
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h2><?php echo $data['employee']->full_name; ?></h2>
            <span class="employee-id">ID: <?php echo $data['employee']->employee_id; ?></span>
        </div>

        <div class="profile-details">
            <section>
                <h3>Personal Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Email</label>
                        <p><?php echo $data['employee']->email; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Contact Number</label>
                        <p><?php echo $data['employee']->contact_no; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Address</label>
                        <p><?php echo $data['employee']->address; ?></p>
                    </div>
                    <div class="info-item">
                        <label>NIC</label>
                        <p><?php echo $data['employee']->nic; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Date of Birth</label>
                        <p><?php echo $data['employee']->dob; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Gender</label>
                        <p><?php echo $data['employee']->gender; ?></p>
                    </div>
                </div>
            </section>

            <section>
                <h3>Employment Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Role</label>
                        <p>Head Manager</p>
                    </div>
                    <div class="info-item">
                        <label>Join Date</label>
                        <p><?php echo date('F j, Y', strtotime($data['employee']->join_date)); ?></p>
                    </div>
                </div>
            </section>

            
        </div>
    </div>
</main>

<script>
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>
