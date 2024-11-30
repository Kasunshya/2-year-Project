document.addEventListener('DOMContentLoaded', function () {
    // Add Branch Manager Modal
    const modal = document.getElementById('employeeModal');
    const addBtn = document.querySelector('.add-employee');
    const closeBtns = document.querySelectorAll('.close');
    const editForm = document.getElementById('editBranchManagerForm');

    addBtn.onclick = function () {
        modal.style.display = "block";
    }

    closeBtns.forEach(btn => {
        btn.onclick = function () {
            modal.style.display = "none";
            editModal.style.display = "none";
            deleteModal.style.display = "none";
        }
    });

    // Edit Branch Manager Modal
    const editModal = document.getElementById('editemployeeModal');

    window.editEmployee = function (id) {
        editModal.style.display = "block";
        const row = document.querySelector(`tr[data-id='${id}']`);
        const cells = row.getElementsByTagName('td');
        const userId = cells[1].dataset.userId;

        // Set form values
        document.getElementById('edit_branchmanager_id').value = id;
        document.getElementById('edit_user_id').value = userId;
        document.getElementById('edit_branch_id').value = cells[1].dataset.branchId;
        document.getElementById('edit_branchmanager_name').value = cells[2].textContent.trim();
        document.getElementById('edit_address').value = cells[3].textContent.trim();
        document.getElementById('edit_contact_number').value = cells[4].textContent.trim();
    }

    // Delete Branch Manager Modal
    const deleteModal = document.getElementById('deleteemployeeModal');

    window.deleteEmployee = function (id) {
        deleteModal.style.display = "block";
        document.getElementById('delete_branchmanager_id').value = id;
    }

    // Close modals when clicking outside
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
        if (event.target == deleteModal) {
            deleteModal.style.display = "none";
        }
    }

    // Edit form validation
    editForm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (validateEditForm()) {
            editForm.submit();
        }
    });
});

function validateEditForm() {
    let isValid = true;
    const form = document.querySelector('#editemployeeModal form');

    // Clear previous errors
    clearErrors();

    // Branch validation
    const branch = form.querySelector('#edit_branch_id');
    if (!branch.value) {
        showError(branch, 'Please select a branch');
        isValid = false;
    }

    // Name validation
    const name = form.querySelector('#edit_branchmanager_name');
    if (!name.value.trim()) {
        showError(name, 'Name is required');
        isValid = false;
    } else if (!/^[A-Za-z\s]{2,}$/.test(name.value.trim())) {
        showError(name, 'Name must contain only letters and spaces');
        isValid = false;
    }

    // Email validation
    const email = form.querySelector('#edit_email');
    if (!email.value.trim()) {
        showError(email, 'Email is required');
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
        showError(email, 'Please enter a valid email address');
        isValid = false;
    }

    // Contact number validation
    const contact = form.querySelector('#edit_contact_number');
    if (!contact.value.trim()) {
        showError(contact, 'Contact number is required');
        isValid = false;
    } else if (!/^[0-9]{10}$/.test(contact.value.trim())) {
        showError(contact, 'Contact number must be 10 digits');
        isValid = false;
    }

    // Address validation
    const address = form.querySelector('#edit_address');
    if (!address.value.trim()) {
        showError(address, 'Address is required');
        isValid = false;
    }

    return isValid;
}

function showError(input, message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    input.classList.add('invalid');
    input.parentNode.insertBefore(errorDiv, input.nextSibling);
}

function clearErrors() {
    document.querySelectorAll('.error-message').forEach(error => error.remove());
    document.querySelectorAll('.invalid').forEach(input => input.classList.remove('invalid'));
}