// Get the modal elements
var addModal = document.getElementById("customerModal");
var editModal = document.getElementById("editCustomerModal");
var deleteModal = document.getElementById("deleteCustomerModal");

// Get the button that opens the modal
var addBtn = document.querySelector(".add-customer");

// Get the <span> element that closes the modal
var closeBtns = document.querySelectorAll(".close");

// When the user clicks the button, open the add user modal
addBtn.onclick = function() {
    addModal.style.display = "block";
}

// When the user clicks on close, close the modals
closeBtns.forEach(function(btn) {
    btn.onclick = function() {
        addModal.style.display = "none";
        editModal.style.display = "none";
        deleteModal.style.display = "none";
    }
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == addModal || event.target == editModal || event.target == deleteModal) {
        addModal.style.display = "none";
        editModal.style.display = "none";
        deleteModal.style.display = "none";
    }
}

// Form validation function
function validateForm(fullName, address, contactNo, userRole) {
    let isValid = true;
    let errorMessage = "";

    // Name validation (only letters and spaces)
    if (!/^[a-zA-Z\s]+$/.test(fullName)) {
        errorMessage += "Full name should only contain letters and spaces\n";
        isValid = false;
    }

    // Address validation (minimum length)
    if (address.trim().length < 5) {
        errorMessage += "Address should be at least 5 characters long\n";
        isValid = false;
    }

    // Contact number validation (10 digits)
    if (!/^\d{10}$/.test(contactNo)) {
        errorMessage += "Contact number should be exactly 10 digits\n";
        isValid = false;
    }

    // User role validation (specific roles only)
    const validRoles = ['admin', 'manager', 'employee', 'cashier'];
    if (!validRoles.includes(userRole.toLowerCase())) {
        errorMessage += "Invalid user role. Please select a valid role\n";
        isValid = false;
    }

    if (!isValid) {
        alert(errorMessage);
    }
    return isValid;
}

// Handle form submissions
document.querySelector('#customerModal form').onsubmit = function(e) {
    const fullName = document.getElementById('full_name').value;
    const address = document.getElementById('address').value;
    const contactNo = document.getElementById('contact_no').value;
    const userRole = document.getElementById('user_role').value;

    if (!validateForm(fullName, address, contactNo, userRole)) {
        e.preventDefault();
        return false;
    }
};

document.querySelector('#editCustomerModal form').onsubmit = function(e) {
    const fullName = document.getElementById('edit_full_name').value;
    const address = document.getElementById('edit_address').value;
    const contactNo = document.getElementById('edit_contact_no').value;
    const userRole = document.getElementById('edit_user_role').value;

    if (!validateForm(fullName, address, contactNo, userRole)) {
        e.preventDefault();
        return false;
    }
};

// Edit button functionality
function attachEditListeners() {
    document.querySelectorAll('.edit-btn').forEach(function(editBtn) {
        editBtn.onclick = function() {
            var employeeId = this.getAttribute('data-id');
            var fullName = this.getAttribute('data-name');
            var address = this.getAttribute('data-address');
            var contactNo = this.getAttribute('data-contact');
            var userRole = this.getAttribute('data-role');

            document.getElementById('edit_employee_id').value = employeeId;
            document.getElementById('edit_full_name').value = fullName;
            document.getElementById('edit_address').value = address;
            document.getElementById('edit_contact_no').value = contactNo;
            document.getElementById('edit_user_role').value = userRole;

            editModal.style.display = "block";
        }
    });
}

// Delete button functionality
function attachDeleteListeners() {
    document.querySelectorAll('.delete-btn').forEach(function(deleteBtn) {
        deleteBtn.onclick = function() {
            var employeeId = this.getAttribute('data-id');
            document.getElementById('confirmDelete').setAttribute('data-id', employeeId);
            deleteModal.style.display = "block";
        }
    });
}

// Handle delete confirmation
document.getElementById('confirmDelete').onclick = function() {
    var employeeId = this.getAttribute('data-id');
    window.location.href = 'UserManagement.php?delete_employee_id=' + encodeURIComponent(employeeId);
};

// Search functionality
document.querySelector('.search-btn').onclick = function(event) {
    event.preventDefault();
    var searchTerm = document.querySelector('.search-bar input').value.toLowerCase();
    var rows = document.querySelectorAll('table tbody tr');
    rows.forEach(function(row) {
        var userName = row.cells[1].textContent.toLowerCase();
        row.style.display = userName.includes(searchTerm) ? '' : 'none';
    });
}

// Attach event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    attachEditListeners();
    attachDeleteListeners();
});
