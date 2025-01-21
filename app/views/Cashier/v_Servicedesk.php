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
                <td><input type="number" value="1" min="1" data-product="<?php echo $product->product_name; ?>"></td>
                <td>
                <button onclick="addToOrder('<?php echo htmlspecialchars($product->product_name); ?>', <?php echo $product->price; ?>)">+</button>
                <button onclick="removeFromOrder('<?php echo htmlspecialchars($product->product_name); ?>')">-</button>
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
              <button class="checkout-btn" onclick="generatePDF()">Generate PDF</button>

          </div>
      </div>
      <a href="order_details.php" class="view-orders-btn">View Orders</a>
      
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
              <div class="payment-method">
                  <button class="payment-btn" onclick="selectPaymentMethod('card')">Pay by Card</button>
                  <button class="payment-btn" onclick="selectPaymentMethod('cash')">Pay by Cash</button>
              </div>
              <div class="cash-input-container" id="cashInputContainer">
                  <input type="number" class="cash-input" id="cashInput" placeholder="Enter Cash">
                  <button class="payment-btn" onclick="processCashPayment()">Process Cash</button>
              </div>
              <div id="cardPaymentSection" style="display: none; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 400px; margin: 20px auto;">
                <label for="cardNumber" style="font-size: 14px; color: #333; margin-bottom: 5px; display: block;">Card Number:</label>
                <input type="text" id="cardNumber" placeholder="Enter Card Number" style="padding: 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; width: 100%; margin-bottom: 15px; box-sizing: border-box;">
                
                <label for="expiryDate" style="font-size: 14px; color: #333; margin-bottom: 5px; display: block;">Expiry Date:</label>
                <input type="text" id="expiryDate" placeholder="MM/YY" style="padding: 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; width: 100%; margin-bottom: 15px; box-sizing: border-box;">
                
                <label for="cvv" style="font-size: 14px; color: #333; margin-bottom: 5px; display: block;">CVV:</label>
                <input type="text" id="cvv" placeholder="CVV" style="padding: 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; width: 100%; margin-bottom: 15px; box-sizing: border-box;">
                
                <button class="payment-btn" onclick="processCardPayment()" style="background-color: #3498db; color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; text-align: center; width: 100%; font-size: 16px; transition: background-color 0.3s;">Process Card Payment</button>
            </div>
            
          </div>
      </div>
  </div>
  <!--script src="<!-?php echo URLROOT; ?>/public/js/Cashier/SeviceDesk.js"></script-->
  <script src="<?php echo URLROOT; ?>/public/js/Cashier/ServiceDesk.js"></script>

</body>
