
  // Function to search products
 function searchProducts() {
  let searchInput = document.getElementById('searchInput').value.toLowerCase();
  let rows = document.querySelectorAll('#productTable tbody tr');
  rows.forEach(row => {
      let product = row.cells[0].innerText.toLowerCase();
      if (product.includes(searchInput)) {
          row.style.display = '';
      } else {
          row.style.display = 'none';
      }
  });
}

// Function to change quantity
function changeQuantity(button, amount) {
  let input = button.parentElement.querySelector('.quantity-input');
  let currentQuantity = parseInt(input.value);
  currentQuantity += amount;
  if (currentQuantity >= 0) {
      input.value = currentQuantity;
  }
}
// Function to add product to order
function addToOrder(button) {
let row = button.closest('tr');
let productName = row.cells[0].innerText; // Product Name
let price = parseFloat(row.cells[3].innerText); // Price
let quantity = parseInt(row.querySelector('.quantity-input').value); // Quantity

if (quantity > 0) {
    // Check if the product already exists in the order
    let existingOrderItem = order.find(item => item.name === productName);
    if (existingOrderItem) {
        // Update the quantity of the existing product
        existingOrderItem.quantity += quantity;
    } else {
        // Add new product to the order
        order.push({
            name: productName,
            price: price,
            quantity: quantity
        });
    }
    // Reset the quantity input for the product row
    row.querySelector('.quantity-input').value = 0;
    // Update the order list UI
    updateOrderList();
} else {
    alert("Please select a valid quantity.");
}
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
        <span>${item.name} (${item.quantity} x $${item.price.toFixed(2)})</span>
        <span>$${itemTotal.toFixed(2)}</span>
        <button  style="padding: 5px 10px; font-size: 14px; margin-left: 10px; cursor: pointer; border: none; border-radius: 5px; background-color: #4CAF50; color: white;"  onclick="editItem(${index})">Edit</button>  <!-- Edit button -->
        <button  style="padding: 5px 10px; font-size: 14px; margin-left: 10px; cursor: pointer; border: none; border-radius: 5px; background-color: #f44336; color: white;"  onclick="removeItem(${index})">Remove</button>  <!-- Remove button -->
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
let newQuantity = prompt("Enter new quantity for " + order[index].name + ":", order[index].quantity);

// Ensure the input is a valid number
if (newQuantity !== null && !isNaN(newQuantity) && newQuantity >= 0) {
    newQuantity = parseInt(newQuantity);

    // Update the order with the new quantity
    if (newQuantity === 0) {
        // If quantity is 0, remove the item from the order
        order.splice(index, 1);
    } else {
        // Otherwise, update the quantity
        order[index].quantity = newQuantity;
    }

    // Update the UI to reflect the changes
    updateOrderList();
} else {
    Swal.fire({
icon: 'warning',
title: 'Invalid Quantity',
text: 'Please select a valid quantity.',
confirmButtonText: 'OK'
});    }
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

/*Function to handle checkout
function checkout() {
let discountedTotal = order.reduce((sum, item) => sum + (item.price * item.quantity), 0) * (1 - discount / 100);
alert(`Total after discount: $${discountedTotal.toFixed(2)}`);
document.getElementById('paymentModal').style.display = 'block';
}*/
/*
function checkout() {
let discountedTotal = order.reduce((sum, item) => sum + (item.price * item.quantity), 0) * (1 - discount / 100);

if (order.length > 0) {
    // Prepare order data
    let orderData = {
        orderId: 'ORD-' + new Date().getTime(), // Unique order ID
        discount: discount,
        discountedTotal: discountedTotal,
        items: order,
    };

    // Send data to the server
    fetch('save_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(orderData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Order placed successfully! Order ID: ${data.orderId}`);
            document.getElementById('paymentModal').style.display = 'block';
            newOrder(); // Reset the order
        } else {
            alert('Failed to place order.');
        }
    })
    .catch(error => console.error('Error:', error));
} else {
    alert('No items in the order!');
}
}
*/
// Function to handle checkout
function checkout() {
if (order.length > 0) {
    let discountedTotal = order.reduce((sum, item) => sum + (item.price * item.quantity), 0) * (1 - discount / 100);

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

order.forEach(item => {
    let itemTotal = item.price * item.quantity;
    totalAmount += itemTotal;

    let listItem = document.createElement('li');
    listItem.innerHTML = `
        ${item.name} (${item.quantity} x $${item.price.toFixed(2)}) 
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

// Update total
document.getElementById('billTotal').innerText = `Total Amount to Pay: $${discountedTotal.toFixed(2)}`;

// Show the bill summary modal
document.getElementById('billSummaryModal').style.display = 'block';
}
// Function to show payment options
function showPaymentOptions() {
// Close the Bill Summary Modal
document.getElementById('billSummaryModal').style.display = 'none';

// Open the Payment Options Modal
document.getElementById('paymentModal').style.display = 'block';
}

// Function to close the bill summary modal
function closeBillModal() {
document.getElementById('billSummaryModal').style.display = 'none';
}

// Function to show payment options
function selectPaymentMethod(method) {
if (method === 'card') {
    document.getElementById('cardPaymentSection').style.display = 'block';
    document.getElementById('cashInputContainer').style.display = 'none';
} else if (method === 'cash') {
    document.getElementById('cashInputContainer').style.display = 'block';
    document.getElementById('cardPaymentSection').style.display = 'none';
}

document.getElementById('paymentModal').style.display = 'block';
}

// Function to process cash payment
function processCashPayment() {
let cashInput = parseFloat(document.getElementById('cashInput').value);
let totalAmount = order.reduce((sum, item) => sum + (item.price * item.quantity), 0) * (1 - discount / 100);
if (cashInput >= totalAmount) {
    let change = cashInput - totalAmount;
    alert(`Payment successful! Change: $${change.toFixed(2)}`);
    closeModal();
    newOrder();
} else {
    alert("Insufficient cash provided.");
}
}

// Function to process card payment
function processCardPayment() {
let cardNumber = document.getElementById('cardNumber').value;
let expiryDate = document.getElementById('expiryDate').value;
let cvv = document.getElementById('cvv').value;

if (cardNumber && expiryDate && cvv) {
    alert('Card payment processed successfully!');
    closeModal();
    newOrder();
} else {
    alert('Please fill out all card details.');
}
}

// Function to close the payment modal
function closeModal() {
document.getElementById('paymentModal').style.display = 'none';
}

// Function to start a new order
function newOrder() {
if (confirm("Are you sure you want to start a new order?")) {
    order = [];
    discount = 0;
    document.getElementById('discountSelect').value = "0";
    document.getElementById('customDiscountInput').value = "";
    updateOrderList();
}
}
/* Function to start a new order
function newOrder() {
if (confirm("Are you sure you want to start a new order?")) {
    order = [];
    discount = 0;
    document.getElementById('discountSelect').value = "0";
    document.getElementById('customDiscountInput').value = "";
    updateOrderList();
}
}*/

/*Show the appropriate payment method section (Card or Cash)
function selectPaymentMethod(method) {
    if (method === 'card') {
        document.getElementById('cardPaymentSection').style.display = 'block';
        document.getElementById('cashInputContainer').style.display = 'none';
    } else if (method === 'cash') {
        document.getElementById('cashInputContainer').style.display = 'block';
        document.getElementById('cardPaymentSection').style.display = 'none';
    }
    // Show the payment modal
    document.getElementById('paymentModal').style.display = 'block';
}

// Function to process card payment
function processCardPayment() {
    let cardNumber = document.getElementById('cardNumber').value;
    let expiryDate = document.getElementById('expiryDate').value;
    let cvv = document.getElementById('cvv').value;

    if (cardNumber && expiryDate && cvv) {
        alert('Card payment processed successfully!');
        // Here, you can integrate with a real payment gateway.
        closeModal();
    } else {
        alert('Please fill out all card details.');
    }
}

// Function to process cash payment
function processCashPayment() {
let cashInput = parseFloat(document.getElementById('cashInput').value);
let totalAmount = order.reduce((sum, item) => sum + (item.price * item.quantity), 0) * (1 - discount / 100);
if (cashInput >= totalAmount) {
    let change = cashInput - totalAmount;
    alert(`Payment successful! Change: $${change.toFixed(2)}`);
    document.getElementById('paymentModal').style.display = 'none';
    newOrder();
} else {
    alert("Insufficient cash provided.");
}
}

// Function to close the modal
function closeModal() {
    document.getElementById('paymentModal').style.display = 'none';
}*/
// Function to fetch product data from the server
function fetchProducts() {
fetch('fetch_products.php') // URL to your PHP file
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        let productTableBody = document.querySelector('#productTable tbody');
        productTableBody.innerHTML = ''; // Clear existing data

        // Loop through the data and create table rows
        data.forEach(product => {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.name}</td>
                <td>${product.category}</td>
                <td>${product.availability}</td>
                <td>${product.price}</td>
                <td>
                    <div class="quantity-control">
                        <button class="quantity-btn" onclick="changeQuantity(this, -1)">-</button>
                        <input type="text" class="quantity-input" value="0" readonly>
                        <button class="quantity-btn" onclick="changeQuantity(this, 1)">+</button>
                    </div>
                </td>
                <td><button class="add-to-order-btn" onclick="addToOrder(this)">Add</button></td>
            `;
            productTableBody.appendChild(row); // Add the row to the table
        });
    })
    .catch(error => console.error('Error fetching products:', error));  // Handle any errors
}

// Call fetchProducts() when the page loads
document.addEventListener('DOMContentLoaded', fetchProducts);
function generatePDF() {
const { jsPDF } = window.jspdf;
const doc = new jsPDF();

// Add title to the PDF
doc.setFontSize(18);
doc.text("Order Details", 14, 20);

// Set text styling (Optional)
doc.setFont("times", "normal"); // Set the font to "Times"
doc.setTextColor(0, 0, 255); // Set the text color to blue

// Add order details to the PDF
doc.setFontSize(12);
let yPosition = 30;  // Starting position for the list

let totalAmount = 0;

// Add each item in the order list
order.forEach(item => {
    let itemTotal = item.price * item.quantity;
    totalAmount += itemTotal;

    // Add item to PDF
    doc.text(`${item.name} (${item.quantity} x $${item.price.toFixed(2)})`, 14, yPosition);
    doc.text(`$${itemTotal.toFixed(2)}`, 120, yPosition);
    yPosition += 10;
});

// Apply the discount to the total
let discountedTotal = totalAmount * (1 - discount / 100);

// Add discount details
doc.setTextColor(0, 0, 0); // Reset text color to black
doc.text(`Discount Applied: ${discount}%`, 14, yPosition);
yPosition += 10;

// Add discounted total
doc.setTextColor(0, 128, 0); // Green color for the discounted total
doc.text(`Total after Discount: $${discountedTotal.toFixed(2)}`, 14, yPosition);

// If a custom discount was applied, display it separately
let customDiscount = parseFloat(document.getElementById('customDiscountInput').value);
if (customDiscount) {
    doc.text(`Custom Discount: $${(totalAmount - discountedTotal).toFixed(2)}`, 14, yPosition + 10);
}

// Save the PDF (this will trigger the download)
doc.save("order-details.pdf");
}
