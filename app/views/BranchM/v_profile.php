<?php require APPROOT.'/views/inc/components/verticalnavbar.php'?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/profile.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<main class="main-content">
    <?php if(isset($_SESSION['success_message'])): ?>
        <div class="alert success">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']);
            ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['error_message'])): ?>
        <div class="alert error">
            <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h2><?php echo isset($data['manager']->full_name) ? $data['manager']->full_name : 'N/A'; ?></h2>
            <span class="employee-id">ID: <?php echo isset($data['manager']->employee_id) ? $data['manager']->employee_id : 'N/A'; ?></span>
        </div>

        <div class="profile-details">
            <section>
                <h3>Personal Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Email</label>
                        <p><?php echo isset($data['manager']->email) ? $data['manager']->email : 'N/A'; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Contact Number</label>
                        <p><?php echo isset($data['manager']->contact_no) ? $data['manager']->contact_no : 'N/A'; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Address</label>
                        <p><?php echo isset($data['manager']->address) ? $data['manager']->address : 'N/A'; ?></p>
                    </div>
                    <div class="info-item">
                        <label>NIC</label>
                        <p><?php echo isset($data['manager']->nic) ? $data['manager']->nic : 'N/A'; ?></p>
                    </div>
                </div>
            </section>

            <section>
                <h3>Employment Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Branch</label>
                        <p><?php echo isset($data['manager']->branch_name) ? $data['manager']->branch_name : 'N/A'; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Branch Address</label>
                        <p><?php echo isset($data['manager']->branch_address) ? $data['manager']->branch_address : 'N/A'; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Join Date</label>
                        <p><?php echo isset($data['manager']->join_date) ? date('F j, Y', strtotime($data['manager']->join_date)) : 'N/A'; ?></p>
                    </div>
                    <div class="info-item">
                        <label>Role</label>
                        <p>Branch Manager</p>
                    </div>
                </div>
            </section>

            <div class="profile-actions">
                <button onclick="openEditModal()" class="btn edit-btn">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editProfileModal')">&times;</span>
            <h2>Edit Profile</h2>
            <form action="<?php echo URLROOT; ?>/Profile/updateProfile" method="POST" id="editProfileForm">
                <div class="form-group">
                    <label for="contact_no">Contact Number</label>
                    <input type="text" id="contact_no" name="contact_no" value="<?php echo isset($data['manager']->contact_no) ? $data['manager']->contact_no : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($data['manager']->email) ? $data['manager']->email : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required><?php echo isset($data['manager']->address) ? $data['manager']->address : ''; ?></textarea>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn save-btn">Save Changes</button>
                    <button type="button" class="btn cancel-btn" onclick="closeModal('editProfileModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php 
// Clear any session errors after displaying them
if(isset($_SESSION['form_errors'])) {
    unset($_SESSION['form_errors']);
}
?>

<script>
function openEditModal() {
    document.getElementById('editProfileModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

// Add form submission handling
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    const contactNo = document.getElementById('contact_no').value;
    const email = document.getElementById('email').value;
    const address = document.getElementById('address').value;

    if (!contactNo || !email || !address) {
        e.preventDefault();
        alert('Please fill in all required fields');
    }
});

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }, 5000);
    });
});
</script>
