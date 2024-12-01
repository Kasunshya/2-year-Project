// Get the modal elements
var addModal = document.getElementById("customerModal");
var editModal = document.getElementById("editCustomerModal");
var deleteModal = document.getElementById("deleteCustomerModal");

// Get the button that opens the modal
var addBtn = document.querySelector(".add-new");

// Get the <span> element that closes the modal
var closeBtns = document.querySelectorAll(".close");

// When the user clicks the button, open the add customer modal
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
function validateForm(fullName, address, contactNo, email) {
    let isValid = true;
    let errorMessage = "";

    // Name validation
    if (!/^[a-zA-Z\s]+$/.test(fullName)) {
        errorMessage += "Name should only contain letters and spaces\n";
        isValid = false;
    }

    // Contact validation
    if (!/^\d{10}$/.test(contactNo)) {
        errorMessage += "Contact number should be exactly 10 digits\n";
        isValid = false;
    }

    // Email validation
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errorMessage += "Please enter a valid email address\n";
        isValid = false;
    }

    if (!isValid) {
        alert(errorMessage);
    }

    return isValid;
}

// Handle add customer form submission
document.querySelector('#customerModal form').onsubmit = function(e) {
    const fullName = document.getElementById('full_Name').value;
    const address = document.getElementById('address').value;
    const contactNo = document.getElementById('contact_No').value;
    const email = document.getElementById('email').value;

    if (!validateForm(fullName, address, contactNo, email)) {
        e.preventDefault();
        return false;
    }
};

// Handle edit customer form submission
document.querySelector('#editCustomerModal form').onsubmit = function(e) {
    const fullName = document.getElementById('edit_full_Name').value;
    const address = document.getElementById('edit_address').value;
    const contactNo = document.getElementById('edit_contact_No').value;
    const email = document.getElementById('edit_email').value;

    if (!validateForm(fullName, address, contactNo, email)) {
        e.preventDefault();
        return false;
    }
};

// Edit button functionality
function attachEditListeners() {
    document.querySelectorAll('.edit-btn').forEach(function(editBtn) {
        editBtn.onclick = function() {
            var customer_ID = this.getAttribute('data-id');
            var full_Name = this.getAttribute('data-fullName');
            var address = this.getAttribute('data-address');
            var contact_No = this.getAttribute('data-contactNo');
            var email = this.getAttribute('data-email');

            document.getElementById('edit_customer_ID').value = customer_ID;
            document.getElementById('edit_full_Name').value = full_Name;
            document.getElementById('edit_address').value = address;
            document.getElementById('edit_contact_No').value = contact_No;
            document.getElementById('edit_email').value = email;

            editModal.style.display = "block";
        }
    });
}

// Delete button functionality
function attachDeleteListeners() {
    document.querySelectorAll('.delete-btn').forEach(function(deleteBtn) {
        deleteBtn.onclick = function() {
            var customer_ID = this.getAttribute('data-id');
            document.getElementById('confirmDelete').setAttribute('data-id', customer_ID);
            deleteModal.style.display = "block";
        }
    });
}

// Handle delete confirmation
document.getElementById('confirmDelete').onclick = function() {
    var customer_ID = this.getAttribute('data-id');
    window.location.href = 'customerManagement.php?delete_customer_ID=' + encodeURIComponent(customer_ID);
};

// Search functionality
document.querySelector('.search-btn').onclick = function(event) {
    event.preventDefault();
    var searchTerm = document.querySelector('.search-bar input').value.toLowerCase();
    var rows = document.querySelectorAll('table tbody tr');
    rows.forEach(function(row) {
        var customerName = row.cells[1].textContent.toLowerCase();
        row.style.display = customerName.includes(searchTerm) ? '' : 'none';
    });
}

// Attach event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    attachEditListeners();
    attachDeleteListeners();
});