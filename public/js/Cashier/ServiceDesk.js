// Initialize variables
let order = [];
let discount = 0;


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

// Update quantity based on button clicks
function updateQuantity(button, change) {
    const quantitySelector = button.closest('.quantity-selector'); // Find the nearest quantity selector
    const quantityInput = quantitySelector.querySelector('.quantity-input'); // Get the input field
    let currentQuantity = parseInt(quantityInput.value, 10) || 0;

    // Apply the change
    currentQuantity += change;

    // Ensure the quantity does not drop below 1
    if (currentQuantity < 1) {
        currentQuantity = 1;
        alert("Quantity cannot be less than 1.");
    }

    // Update the input field's value
    quantityInput.value = currentQuantity;

    // Optionally update the order data or backend
    const productName = quantitySelector.getAttribute('data-product');
    console.log(`Product: ${productName}, Quantity: ${currentQuantity}`);
}

// Validate and correct input quantity on typing
function validateQuantity(input) {
    let currentValue = parseInt(input.value, 10);

    // Ensure it's a valid number and at least 1
    if (isNaN(currentValue) || currentValue < 1) {
        input.value = 1; // Reset to 1 if invalid
        alert("Quantity must be at least 1.");
        return;
    }

    // Optionally update backend with valid quantity
    const productName = input.getAttribute('data-product');
    console.log(`Product: ${productName}, Quantity: ${input.value}`);
}

// Add product to order section
function addToOrder(button) {
    const row = button.closest('tr');
    const productName = row.cells[0].textContent.trim();
    const price = parseFloat(row.cells[3].textContent.trim());
    const quantityInput = row.querySelector('input[type="number"]');
    const quantity = parseInt(quantityInput.value);

    if (!productName || isNaN(price) || isNaN(quantity) || quantity <= 0) {
        alert("Invalid product or quantity.");
        return;
    }
// Check if the product already exists in the order
const existingItem = order.find(item => item.productName === productName);
if (existingItem) {
    // Update the quantity if the product already exists
    existingItem.quantity += quantity;
} else {
    // Add new product to the order array
    order.push({ productName, price, quantity });
}

// Refresh the order list UI
updateOrderList();
}
// Function to update the order list UI with edit options
function updateOrderList() {
    let orderList = document.getElementById('orderList');
    orderList.innerHTML = ''; // Clear the current list
    let total = 0;

    order.forEach((item, index) => {
        let itemTotal = item.price * item.quantity;
        total += itemTotal;

        let listItem = document.createElement('li');
        listItem.innerHTML = `
            <span>${item.productName} (${item.quantity} x $${item.price.toFixed(2)})</span>
            <span>$${itemTotal.toFixed(2)}</span>
            <button style="padding: 5px 10px; font-size: 14px; margin-left: 10px; cursor: pointer; border: none; border-radius: 5px; background-color: #4CAF50; color: white;" onclick="editItem(${index})">Edit</button>
            <button style="padding: 5px 10px; font-size: 14px; margin-left: 10px; cursor: pointer; border: none; border-radius: 5px; background-color: #f44336; color: white;" onclick="removeItem(${index})">Remove</button>
        `;
        orderList.appendChild(listItem);
    });

    // Add total to the list
    let totalItem = document.createElement('li');
    totalItem.innerHTML = `<strong>Total: $${total.toFixed(2)}</strong>`;
    orderList.appendChild(totalItem);
}

// Function to remove an item from the order
function removeItem(index) {
    if (confirm("Are you sure you want to remove this item from the order?")) {
        order.splice(index, 1);  // Remove the item
        updateOrderList();  // Re-update the order list
    }
}

// Function to edit the quantity of an item in the order
function editItem(index) {
    let newQuantity = prompt("Enter new quantity for " + order[index].productName + ":", order[index].quantity);

    // Ensure the input is a valid number
    if (newQuantity !== null && !isNaN(newQuantity) && newQuantity > 0) {
        order[index].quantity = parseInt(newQuantity);
        updateOrderList(); // Update the UI to reflect the changes
    } else if (newQuantity === "0") {
        removeItem(index); // Remove item if quantity is set to 0
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Invalid Quantity',
            text: 'Please select a valid quantity greater than 0.',
            confirmButtonText: 'OK'
        });
    }
}
// Function to apply discount
function applyDiscount() {
    let discountSelect = document.getElementById('discountSelect');
    discount = parseFloat(discountSelect.value) || 0;
    updateOrderList();
}

// Function to apply custom discount
function applyCustomDiscount() {
    let customDiscountInput = document.getElementById('customDiscountInput');
    discount = parseFloat(customDiscountInput.value) || 0;
    updateOrderList();
}

// Function to handle checkout
function checkout() {
    if (order.length > 0) {
        let totalBeforeDiscount = order.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        let discountedTotal = totalBeforeDiscount * (1 - discount / 100);

        // Display the bill summary
        showBillSummary(discountedTotal);
    } else {
        alert('No items in the order!');
    }
}
// Function to show the bill summary
function showBillSummary(discountedTotal) {
    let billSummaryList = document.getElementById('billSummaryList');
    billSummaryList.innerHTML = ''; // Clear existing bill summary

    let totalAmount = 0;

    // Display each item in the order
    order.forEach(item => {
        let itemTotal = item.price * item.quantity;
        totalAmount += itemTotal;

        let listItem = document.createElement('li');
        listItem.innerHTML = `
            ${item.productName} (${item.quantity} x $${item.price.toFixed(2)}) 
            - <strong>$${itemTotal.toFixed(2)}</strong>
        `;
        billSummaryList.appendChild(listItem);
    });

    // Add discount information
    let discountItem = document.createElement('li');
    discountItem.innerHTML = `Discount Applied: <strong>${discount}%</strong>`;
    billSummaryList.appendChild(discountItem);

    // Show total amount after discount
    let totalItem = document.createElement('li');
    totalItem.innerHTML = `<strong>Total: $${discountedTotal.toFixed(2)}</strong>`;
    billSummaryList.appendChild(totalItem);

    // Update total in the modal
    document.getElementById('billTotal').innerText = `Total Amount to Pay: $${discountedTotal.toFixed(2)}`;

    // Show the bill summary modal
    document.getElementById('billSummaryModal').style.display = 'block';
}

// Function to close the bill summary modal
function closeBillModal() {
    document.getElementById('billSummaryModal').style.display = 'none';
    document.getElementById('paymentModal').style.display = 'none';

}

// Function to handle new order
function newOrder() {
    if (confirm("Are you sure you want to start a new order? This will clear the current order.")) {
        // Clear the order array and reset discount
        order = [];
        discount = 0;

        // Reset discount dropdown and custom discount input
        document.getElementById('discountSelect').value = 0;
        document.getElementById('customDiscountInput').value = '';

        // Reset all quantity inputs in the product table to 1
        const table = document.getElementById('productTable');
        const quantityInputs = table.querySelectorAll('input[type="number"]');
        quantityInputs.forEach(input => {
            input.value = 1;
        });

        // Update the UI to reflect the cleared order
        updateOrderList();
    }
}
// Show payment modal with cash and card options
function showPaymentOptions() {
    document.getElementById('billSummaryModal').style.display = 'none'; // Hide bill summary modal
    document.getElementById('paymentModal').style.display = 'block';   // Show payment modal
}

// Show cash payment section
function showCashPayment() {
    document.getElementById('cashPaymentSection').style.display = 'block';
    document.getElementById('cardPaymentSection').style.display = 'none';
}

// Show card payment section
function showCardPayment() {
    document.getElementById('cashPaymentSection').style.display = 'none';
    document.getElementById('cardPaymentSection').style.display = 'block';
    
}
function processCashPayment() {
    const cashInput = parseFloat(document.getElementById('cashInput').value);
    const totalAmount = parseFloat(document.getElementById('billTotal').innerText.replace('Total Amount to Pay: $', ''));

    if (isNaN(cashInput) || cashInput <= 0) {
        alert('Please enter a valid cash amount.');
        return;
    }

    if (cashInput < totalAmount) {
        alert('Insufficient cash. Please provide the correct amount.');
        return;
    }

    const change = cashInput - totalAmount;
    alert(`Payment successful! Change: $${change.toFixed(2)}`);
    
    // Store payment info in the order object for the bill summary
    order.paymentInfo = {
        paymentMethod: 'Cash',
        amountPaid: cashInput,
        change: change
    };

    finalizeTransaction();
}


// Process card payment
function processCardPayment() {
    const cardNumber = document.getElementById('cardNumber').value.trim();
    const expiryDate = document.getElementById('expiryDate').value.trim();
    const cvv = document.getElementById('cvv').value.trim();

    if (!/^\d{16}$/.test(cardNumber)) {
        alert('Invalid card number. Please enter a 16-digit number.');
        return;
    }

    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiryDate)) {
        alert('Invalid expiry date. Please use MM/YY format.');
        return;
    }

    if (!/^\d{3}$/.test(cvv)) {
        alert('Invalid CVV. Please enter a 3-digit number.');
        return;
    }

    alert('Payment successful! Thank you for your purchase.');
    finalizeTransaction();
}

// Finalize the transaction
function finalizeTransaction() {
    document.getElementById('printBillBtn').style.display = 'block'; // Enable "Print Bill" button
    document.getElementById('cashPaymentSection').style.display = 'none';
    document.getElementById('cardPaymentSection').style.display = 'none';
}

function completeTransaction() {
    closePaymentModal(); // Close the payment modal
    newOrder();          // Start a new order
    alert('Transaction complete. Ready for the next order!');
}

// Initialize event listeners for payment modal
document.addEventListener('DOMContentLoaded', function () {
    const cashInputContainer = document.getElementById('cashInputContainer');
    const cardPaymentSection = document.getElementById('cardPaymentSection');

    // Show or hide sections based on selected payment method
    document.querySelectorAll('.payment-btn').forEach(button => {
        button.addEventListener('click', function () {
            const method = this.getAttribute('onclick').includes('cash') ? 'cash' : 'card';
            cashInputContainer.style.display = method === 'cash' ? 'block' : 'none';
            cardPaymentSection.style.display = method === 'card' ? 'block' : 'none';
        });
    });
});
function generateBill() {
    if (order.length === 0) {
        alert("No items in the order to generate a bill.");
        return;
    }

    let totalBeforeDiscount = order.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    let discountedTotal = totalBeforeDiscount * (1 - discount / 100);

    const paymentInfo = order.paymentInfo || {}; // Default to an empty object if no payment info

    // Get the current date and time
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleDateString();
    const formattedTime = currentDate.toLocaleTimeString();

    let billContent = `
        <html>
        <head>
            <title>Bill Summary</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    background-color: #f9f9f9;
                    color: #333;
                }
                h1 {
                    text-align: center;
                    color: #783b31;
                    font-size: 32px;
                }
                .header {
                    text-align: center;
                    font-size: 18px;
                    color: #777;
                }
                .header p {
                    margin: 5px;
                    font-size: 16px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }
                table, th, td {
                    border: 1px solid #ddd;
                }
                th, td {
                    padding: 12px;
                    text-align: left;
                    font-size: 14px;
                }
                th {
                    background-color: #783b31;
                    color: white;
                }
                td {
                    background-color: #f9f9f9;
                }
                .total {
                    font-weight: bold;
                    text-align: right;
                    font-size: 16px;
                    margin-top: 20px;
                    padding-top: 10px;
                    border-top: 2px solid #ddd;
                }
                .thank-you {
                    text-align: center;
                    margin-top: 30px;
                    font-size: 16px;
                    color: #777;
                }
                .footer {
                    text-align: center;
                    margin-top: 50px;
                    font-size: 14px;
                    color: #999;
                }
            </style>
        </head>
        <body>
            <h1>Frostine Bakery</h1>
            <div class="header">
                <p>Date: ${formattedDate}</p>
                <p>Time: ${formattedTime}</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price per Item</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
    `;

    // Add items to the bill table
    order.forEach(item => {
        let itemTotal = item.price * item.quantity;
        billContent += `
            <tr>
                <td>${item.productName}</td>
                <td>${item.quantity}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td>$${itemTotal.toFixed(2)}</td>
            </tr>
        `;
    });

    billContent += `
                </tbody>
            </table>
            <p class="total">Subtotal: $${totalBeforeDiscount.toFixed(2)}</p>
            <p class="total">Discount Applied: ${discount}%</p>
            <p class="total">Total Amount: $${discountedTotal.toFixed(2)}</p>
    `;

    if (paymentInfo.paymentMethod === 'Cash') {
        billContent += `
            <p class="total">Amount Paid: $${paymentInfo.amountPaid.toFixed(2)}</p>
            <p class="total">Change: $${paymentInfo.change.toFixed(2)}</p>
        `;
    }

    billContent += `
            <div class="thank-you">
                <p>Thank you for your purchase!</p>
            </div>
            <div class="footer">
                <p>&copy; 2025 Frostine Bakery | All rights reserved</p>
            </div>
        </body>
        </html>
    `;

    // Open a new window with the bill content
    const newWindow = window.open('', '_blank');
    newWindow.document.write(billContent);
    newWindow.document.close();
    newWindow.print(); // Automatically open the print dialog
}


// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Initialize search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', searchProducts);
    }
});
// Show payment modal
function openPaymentModal() {
    document.getElementById('paymentModal').style.display = 'flex';
}

// Close payment modal
function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
    showPaymentOptions(); // Reset the modal to the default state
}


