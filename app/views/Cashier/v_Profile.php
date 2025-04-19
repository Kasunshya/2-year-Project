<?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/profile.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
                </div>
            </section>

            <section>
                <h3>Employment Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Branch</label>
                        <p><?php echo $data['employee']->branch; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Join Date</label>
                        <p><?php echo date('F j, Y', strtotime($data['employee']->join_date)); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Role</label>
                        <p><?php echo ucfirst($data['employee']->user_role); ?></p>
                    </div>
                </div>
            </section>

            <div class="profile-actions">
                <button onclick="openEditModal()" class="btn edit-btn">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
                <button onclick="openPasswordModal()" class="btn password-btn">
                    <i class="fas fa-key"></i> Change Password
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editProfileModal')">&times;</span>
            <h2>Edit Profile</h2>
            <form action="<?php echo URLROOT; ?>/profile/updateProfile" method="POST">
                <div class="form-group">
                    <label for="contact_no">Contact Number</label>
                    <input type="text" id="contact_no" name="contact_no" value="<?php echo $data['employee']->contact_no; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $data['employee']->email; ?>">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address"><?php echo $data['employee']->address; ?></textarea>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn save-btn">Save Changes</button>
                    <button type="button" class="btn cancel-btn" onclick="closeModal('editProfileModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('passwordModal')">&times;</span>
            <h2>Change Password</h2>
            <form action="<?php echo URLROOT; ?>/profile/changePassword" method="POST">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn save-btn">Change Password</button>
                    <button type="button" class="btn cancel-btn" onclick="closeModal('passwordModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
function openEditModal() {
    document.getElementById('editProfileModal').style.display = 'block';
}

function openPasswordModal() {
    document.getElementById('passwordModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Password validation
document.querySelector('#passwordModal form').onsubmit = function(e) {
    const newPass = document.getElementById('new_password').value;
    const confirmPass = document.getElementById('confirm_password').value;
    
    if (newPass !== confirmPass) {
        e.preventDefault();
        alert('New passwords do not match!');
        return false;
    }
    return true;
};

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>
