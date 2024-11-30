// Get the modal elements
var addModal = document.getElementById("customerModal");
var editModal = document.getElementById("editCustomerModal");
var deleteModal = document.getElementById("deleteCustomerModal");

// Get the button that opens the modal
var addBtn = document.querySelector(".add-customer");

// Get the <span> element that closes the modal
var closeBtns = document.querySelectorAll(".close");

// When the user clicks the button, open the add product modal
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
function validateForm(productName, category, quantity, price) {
    let isValid = true;
    let errorMessage = "";

    // Product name validation (letters, numbers, and spaces)
    if (!/^[a-zA-Z0-9\s]+$/.test(productName)) {
        errorMessage += "Product name should only contain letters, numbers, and spaces\n";
        isValid = false;
    }

    // Category validation (only letters and spaces)
    if (!/^[a-zA-Z\s]+$/.test(category)) {
        errorMessage += "Category should only contain letters and spaces\n";
        isValid = false;
    }

    // Quantity validation (positive integers)
    if (!/^\d+$/.test(quantity) || quantity <= 0) {
        errorMessage += "Quantity must be a positive number\n";
        isValid = false;
    }

    // Price validation (positive numbers with up to 2 decimal places)
    if (!/^\d+(\.\d{1,2})?$/.test(price) || price <= 0) {
        errorMessage += "Price must be a positive number with up to 2 decimal places\n";
        isValid = false;
    }

    if (!isValid) {
        alert(errorMessage);
    }
    return isValid;
}

// Handle form submissions
document.querySelector('#customerModal form').onsubmit = function(e) {
    const productName = document.getElementById('product_name').value;
    const category = document.getElementById('category').value;
    const quantity = document.getElementById('quantity').value;
    const price = document.getElementById('price').value;

    if (!validateForm(productName, category, quantity, price)) {
        e.preventDefault();
        return false;
    }
};

document.querySelector('#editCustomerModal form').onsubmit = function(e) {
    const productName = document.getElementById('edit_product_name').value;
    const category = document.getElementById('edit_category').value;
    const quantity = document.getElementById('edit_quantity').value;
    const price = document.getElementById('edit_price').value;

    if (!validateForm(productName, category, quantity, price)) {
        e.preventDefault();
        return false;
    }
};

// Edit button functionality
function attachEditListeners() {
    document.querySelectorAll('.edit-btn').forEach(function(editBtn) {
        editBtn.onclick = function() {
            var productId = this.getAttribute('data-id');
            var productName = this.getAttribute('data-name');
            var category = this.getAttribute('data-category');
            var quantity = this.getAttribute('data-quantity');
            var price = this.getAttribute('data-price');

            document.getElementById('edit_product_id').value = productId;
            document.getElementById('edit_product_name').value = productName;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_quantity').value = quantity;
            document.getElementById('edit_price').value = price;

            editModal.style.display = "block";
        }
    });
}

// Delete button functionality
function attachDeleteListeners() {
    document.querySelectorAll('.delete-btn').forEach(function(deleteBtn) {
        deleteBtn.onclick = function() {
            var productId = this.getAttribute('data-id');
            document.getElementById('confirmDelete').setAttribute('data-id', productId);
            deleteModal.style.display = "block";
        }
    });
}

// Handle delete confirmation
document.getElementById('confirmDelete').onclick = function() {
    var productId = this.getAttribute('data-id');
    window.location.href = 'ProductManagement.php?delete_product_id=' + encodeURIComponent(productId);
};

// Search functionality
document.querySelector('.search-btn').onclick = function(event) {
    event.preventDefault();
    var searchTerm = document.querySelector('.search-bar input').value.toLowerCase();
    var rows = document.querySelectorAll('table tbody tr');
    rows.forEach(function(row) {
        var productName = row.cells[1].textContent.toLowerCase();
        row.style.display = productName.includes(searchTerm) ? '' : 'none';
    });
}

// Attach event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    attachEditListeners();
    attachDeleteListeners();
});
