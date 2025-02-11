<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service desk</title>
    <?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/servicedesk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header>
      <div class="header-container">
        <h7><i class="fas fa-boxes">&nbsp</i>Service Desk</h7> 
        </div>
      </div>
    </header>
    
    <div class="main-content">
      <div class="search-container">
          <input type="text" id="searchInput" placeholder="Search products...">
      </div>

      <table class="product-table" id="productTable">
          <thead>
              <tr>
                  <th>Product</th>
                  <th>Category</th>
                  <th>Availability</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
          <?php if (!empty($data['products'])): ?>
        <?php foreach ($data['products'] as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product->product_name); ?></td>
                <td><?php echo htmlspecialchars($product->category); ?></td>
                <td><?php echo htmlspecialchars($product->availability); ?></td>
                <td><?php echo number_format($product->price, 2); ?></td>
                <td><!--input type="number" value="1" min="1" data-product="<!?php echo $product->product_name; ?>"-->
                <div class="quantity-selector" data-product="<?php echo $product->product_name; ?>">
        <button class="decrement-btn" onclick="updateQuantity(this, -1)">-</button>
        <input 
            type="number" 
            class="quantity-input" 
            value="1" 
            min="1" 
            oninput="validateQuantity(this)" 
            data-product="<?php echo $product->product_name; ?>">
        <button class="increment-btn" onclick="updateQuantity(this, 1)">+</button>
    </div>
    </td>
                <td>
                <button class="add-btn" onclick="addToOrder(this)">Add</button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No products available.</td>
        </tr>
    <?php endif; ?>
          </tbody>
      </table>

      <div class="order-section">
          <h3>Order</h3>
          <ul class="order-list" id="orderList"></ul>
          <div class="discount-container">
              <label for="discountSelect">Discount:</label>
              <select id="discountSelect" onchange="applyDiscount()">
                  <option value="0">None</option>
                  <option value="10">10%</option>
                  <option value="20">20%</option>
              </select>
              <input type="number" id="customDiscountInput" placeholder="Custom Discount" oninput="applyCustomDiscount()">
          </div>

          <div class="order-actions">
              <button class="checkout-btn" onclick="checkout()">Checkout</button>
              <button class="new-order-btn" onclick="newOrder()">New Order</button>
              <!--button class="checkout-btn" onclick="generateBill()">Generate Bill</button-->

          </div>
      </div>
      <!--a href="order_details.php" class="view-orders-btn">View Orders</a-->
      
      <div class="modal" id="billSummaryModal">
        <div class="modal-content">
            <h3>Bill Summary</h3>
            <ul id="billSummaryList"></ul>
            <p id="billTotal" style="font-weight: bold;"></p>
    
            <button class="payment-btn" onclick="showPaymentOptions()">Next</button>
            <button class="close-btn" onclick="closeBillModal()">Close</button>
        </div>
    </div>
    
<!-- Modal for Payment -->
<div class="modal" id="paymentModal">
    <div class="modal-content">
        <h3>Payment</h3>
        <div class="payment-options">
            <button class="payment-btn" onclick="showCashPayment()">Pay by Cash</button>
            <button class="payment-btn" onclick="showCardPayment()">Pay by Card</button>
        </div>

        <!-- Cash Payment Section -->
        <div id="cashPaymentSection" style="display: none;">
            <label for="cashInput">Enter Cash Amount:</label>
            <input type="number" id="cashInput" min="0" step="0.01" placeholder="Enter cash amount">
            <button class="payment-btn" onclick="processCashPayment()">Process Cash Payment</button>
        </div>

        <!-- Card Payment Section -->
        <div id="cardPaymentSection" style="display: none;">
            <label for="cardNumber">Card Number:</label>
            <input type="text" id="cardNumber" maxlength="16" placeholder="1234 5678 9101 1121">
            <label for="expiryDate">Expiry Date (MM/YY):</label>
            <input type="text" id="expiryDate" placeholder="MM/YY">
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" maxlength="3" placeholder="123">
            <button class="payment-btn" onclick="processCardPayment()">Process Card Payment</button>
        </div>

        <button class="close-btn" onclick="closeBillModal()">Close</button>
        <button id="printBillBtn" style="display: none;" class="payment-btn" onclick="generateBill()">Print Bill</button>
    </div>
</div>

      
  </div>
  <!--script src="<!-?php echo URLROOT; ?>/public/js/Cashier/SeviceDesk.js"></script-->
  <script src="<?php echo URLROOT; ?>/public/js/Cashier/ServiceDesk.js"></script>

</body>
