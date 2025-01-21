// Initialize order array globally
let order = [];

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', () => {
    // Initialize event listeners and other setup
    initializeSearchFunction();
});

// Search functionality
function searchProducts() {
    const searchInput = document.getElementById('searchInput');
    const filter = searchInput.value.toLowerCase();
    const table = document.getElementById('productTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');

    for (let row of rows) {
        const productName = row.cells[0].textContent || row.cells[0].innerText;
        const category = row.cells[1].textContent || row.cells[1].innerText;
        
        if (productName.toLowerCase().indexOf(filter) > -1 || 
            category.toLowerCase().indexOf(filter) > -1) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    }
}

// Initialize event listeners when document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', searchProducts);
    }
});
