document.addEventListener('DOMContentLoaded', function () {
    // Add Branch Manager Modal
    const modal = document.getElementById('employeeModal');
    const addBtn = document.querySelector('.add-employee');
    const closeBtns = document.querySelectorAll('.close');

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

        document.getElementById('edit_branchmanager_id').value = id;
        document.getElementById('edit_user_id').value = cells[1].dataset.userId;
        document.getElementById('edit_branch_id').value = cells[1].dataset.branchId;
        document.getElementById('edit_branchmanager_name').value = cells[2].textContent;
        document.getElementById('edit_address').value = cells[3].textContent;
        document.getElementById('edit_email').value = cells[4].textContent;
        document.getElementById('edit_contact_number').value = cells[5].textContent;
        document.getElementById('edit_password').value = cells[6].textContent;

        // Set the form action URL dynamically
        document.querySelector('#editemployeeModal form').action = `<?php echo URLROOT; ?>/HeadM/editBranchManager/${id}`;
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
});