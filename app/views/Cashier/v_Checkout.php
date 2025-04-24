<?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .payment-method-btn.paypal {
            background-color: #0070ba;
            color: white;
        }
        .payment-method-btn.paypal:hover {
            background-color: #003087;
        }
        #paypalProcessingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 1000;
            color: white;
            display: none;
        }
        #paypalProcessingOverlay .spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #0070ba;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="summary-details">
                <p>Subtotal: LKR<span id="subtotal"><?php echo number_format($data['subtotal'], 2); ?></span></p>
                <p>Discount: LKR<span id="discount"><?php echo number_format($data['discount'] ?? 0, 2); ?></span></p>
                <p>Total: LKR<span id="total"><?php echo number_format($data['total'], 2); ?></span></p>
            </div>
        </div>

        <div class="payment-section">
            <h3>Select Payment Method</h3>
            <div class="payment-methods">
                <button class="payment-method-btn" onclick="selectPaymentMethod('cash')">
                    <i class="fas fa-money-bill-wave"></i>
                    Cash
                </button>
                <button class="payment-method-btn" onclick="selectPaymentMethod('card')">
                    <i class="fas fa-credit-card"></i>
                    Card
                </button>
                <button class="payment-method-btn paypal" onclick="selectPaymentMethod('paypal')">
                    <i class="fab fa-paypal"></i>
                    PayPal
                </button>
            </div>

            <!-- Cash Payment Form -->
            <form id="cashPaymentForm" class="payment-form" style="display:none;">
                <div class="form-group">
                    <label>Amount Tendered:</label>
                    <input type="number" id="cashAmount" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Change:</label>
                    <span id="changeAmount">LKR0.00</span>
                </div>
                <button type="submit" class="process-btn">Process Payment</button>
            </form>

            <!-- Card Payment Form -->
            <form id="cardPaymentForm" class="payment-form" style="display:none;">
                <div class="form-group">
                    <label>Card Number:</label>
                    <input type="text" id="cardNumber" maxlength="16" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Expiry Date:</label>
                        <input type="text" id="expiryDate" placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label>CVV:</label>
                        <input type="text" id="cvv" maxlength="3" required>
                    </div>
                </div>
                <button type="submit" class="process-btn">Process Payment</button>
            </form>

            <!-- PayPal Payment Form -->
            <form id="paypalPaymentForm" class="payment-form" style="display:none;">
                <div class="form-group paypal-info">
                    <p>You will be redirected to PayPal to complete your payment securely.</p>
                    <p>Total to pay: LKR<span id="paypalAmount"><?php echo number_format($data['total'], 2); ?></span></p>
                </div>
                <button type="submit" class="process-btn">Pay with PayPal</button>
            </form>
        </div>
    </div>

    <!-- PayPal Processing Overlay -->
    <div id="paypalProcessingOverlay">
        <div class="spinner"></div>
        <p>Processing your PayPal payment...</p>
        <p>Please do not close this window.</p>
    </div>

    <script>
        function selectPaymentMethod(method) {
            document.getElementById('cashPaymentForm').style.display = 'none';
            document.getElementById('cardPaymentForm').style.display = 'none';
            document.getElementById('paypalPaymentForm').style.display = 'none';
            
            document.getElementById(method + 'PaymentForm').style.display = 'block';
        }

        // Calculate change for cash payment
        document.getElementById('cashAmount').addEventListener('input', function() {
            const total = parseFloat(document.getElementById('total').textContent);
            const tendered = parseFloat(this.value) || 0;
            const change = tendered - total;
            document.getElementById('changeAmount').textContent = 'LKR' + Math.max(0, change).toFixed(2);
        });

        // Handle form submissions
        document.getElementById('cashPaymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            processPayment('cash');
        });

        document.getElementById('cardPaymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            processPayment('card');
        });

        document.getElementById('paypalPaymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            processPayment('paypal');
        });

        function processPayment(method) {
            // Show loading indicator
            const processBtns = document.querySelectorAll('.process-btn');
            processBtns.forEach(btn => {
                btn.disabled = true;
                btn.textContent = 'Processing...';
            });
            
            const formData = new FormData();
            formData.append('payment_method', method);
            
            const total = parseFloat(document.getElementById('total').textContent);
            
            if (method === 'cash') {
                const amountTendered = parseFloat(document.getElementById('cashAmount').value);
                
                if (isNaN(amountTendered) || amountTendered < total) {
                    alert('Please enter a valid amount that covers the total');
                    processBtns.forEach(btn => {
                        btn.disabled = false;
                        btn.textContent = 'Process Payment';
                    });
                    return;
                }
                
                formData.append('amount_tendered', amountTendered);
            } else if (method === 'card') {
                // Validate card details
                const cardNumber = document.getElementById('cardNumber').value;
                const expiryDate = document.getElementById('expiryDate').value;
                const cvv = document.getElementById('cvv').value;
                
                // Basic validation
                if (!/^\d{16}$/.test(cardNumber)) {
                    alert('Please enter a valid 16-digit card number');
                    processBtns.forEach(btn => {
                        btn.disabled = false;
                        btn.textContent = 'Process Payment';
                    });
                    return;
                }
                if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
                    alert('Please enter a valid expiry date (MM/YY)');
                    processBtns.forEach(btn => {
                        btn.disabled = false;
                        btn.textContent = 'Process Payment';
                    });
                    return;
                }
                if (!/^\d{3}$/.test(cvv)) {
                    alert('Please enter a valid 3-digit CVV');
                    processBtns.forEach(btn => {
                        btn.disabled = false;
                        btn.textContent = 'Process Payment';
                    });
                    return;
                }
                
                // For card payments, amount tendered equals total
                formData.append('amount_tendered', total);
            } else if (method === 'paypal') {
                // For PayPal, show overlay and initiate PayPal process
                document.getElementById('paypalProcessingOverlay').style.display = 'flex';
                formData.append('amount', total);
                
                fetch('<?php echo URLROOT; ?>/Cashier/initiatePayPalPayment', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.approvalUrl) {
                        // Store the PayPal order ID in session
                        localStorage.setItem('paypal_order_id', data.orderId);
                        // Redirect to PayPal
                        window.location.href = data.approvalUrl;
                    } else {
                        document.getElementById('paypalProcessingOverlay').style.display = 'none';
                        alert(data.message || 'Failed to initiate PayPal payment');
                        processBtns.forEach(btn => {
                            btn.disabled = false;
                            btn.textContent = 'Pay with PayPal';
                        });
                    }
                })
                .catch(error => {
                    document.getElementById('paypalProcessingOverlay').style.display = 'none';
                    console.error('PayPal Error:', error);
                    alert('Failed to initiate PayPal payment. Please try again.');
                    processBtns.forEach(btn => {
                        btn.disabled = false;
                        btn.textContent = 'Pay with PayPal';
                    });
                });
                
                return; // Early return for PayPal as it redirects
            }
            
            // Add customer_id (using a valid ID from the database)
            formData.append('customer_id', 1);

            // Make AJAX request for cash & card methods
            fetch('<?php echo URLROOT; ?>/Cashier/processPayment', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Payment response:', data);
                if (data.success) {
                    window.location.href = '<?php echo URLROOT; ?>/Cashier/generateBill';
                } else {
                    alert(data.message || 'Payment failed. Please try again.');
                    processBtns.forEach(btn => {
                        btn.disabled = false;
                        btn.textContent = 'Process Payment';
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Payment processing failed. Please try again.');
                processBtns.forEach(btn => {
                    btn.disabled = false;
                    btn.textContent = 'Process Payment';
                });
            });
        }
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Debug employee and branch info with more detail
        const employeeId = <?php echo isset($_SESSION["employee_id"]) ? $_SESSION["employee_id"] : "null"; ?>;
        const branchId = <?php 
          if (isset($_SESSION["branch_id"])) {
              if (is_numeric($_SESSION["branch_id"])) {
                  echo $_SESSION["branch_id"];
              } else {
                  echo "'" . $_SESSION["branch_id"] . "'";
              }
          } else {
              echo "null";
          }
        ?>;
        const cashierId = <?php echo isset($_SESSION["cashier_id"]) ? $_SESSION["cashier_id"] : "null"; ?>;
        
        console.log('Employee ID:', employeeId);
        console.log('Branch ID:', branchId);
        console.log('Cashier ID:', cashierId);
        
        // Add hidden fields with corrected values
        const paymentForms = document.querySelectorAll('.payment-form');
        if (paymentForms.length) {
            paymentForms.forEach(form => {
                // Add employee_id field
                const employeeIdField = document.createElement('input');
                employeeIdField.type = 'hidden';
                employeeIdField.name = 'employee_id';
                employeeIdField.value = employeeId || 6; // Default to 6 if not set
                form.appendChild(employeeIdField);
                
                // Add cashier_id field if available
                if (cashierId !== null) {
                    const cashierIdField = document.createElement('input');
                    cashierIdField.type = 'hidden';
                    cashierIdField.name = 'cashier_id';
                    cashierIdField.value = cashierId;
                    form.appendChild(cashierIdField);
                }
                
                // Add branch_id field - use the one from session or default
                const branchIdField = document.createElement('input');
                branchIdField.type = 'hidden';
                branchIdField.name = 'branch_id';
                branchIdField.value = branchId || 1; // Default to 1 if not set
                form.appendChild(branchIdField);
                
                console.log('Added hidden fields - employee_id:', employeeIdField.value, 
                            'cashier_id:', cashierId, 'branch_id:', branchIdField.value);
            });
        }
        
        // Check if we're coming back from PayPal
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('paypal_success') && localStorage.getItem('paypal_order_id')) {
            const overlay = document.getElementById('paypalProcessingOverlay');
            overlay.style.display = 'flex';
            
            // Complete the PayPal payment
            const formData = new FormData();
            formData.append('payment_method', 'paypal');
            formData.append('paypal_order_id', localStorage.getItem('paypal_order_id'));
            formData.append('customer_id', 1);
            formData.append('amount_tendered', parseFloat(document.getElementById('total').textContent));
            
            fetch('<?php echo URLROOT; ?>/Cashier/completePayPalPayment', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.removeItem('paypal_order_id');
                    window.location.href = '<?php echo URLROOT; ?>/Cashier/generateBill';
                } else {
                    overlay.style.display = 'none';
                    alert(data.message || 'Failed to complete PayPal payment');
                }
            })
            .catch(error => {
                overlay.style.display = 'none';
                console.error('Error:', error);
                alert('Failed to complete PayPal payment. Please try again.');
            });
        }
      });
    </script>
</body>
</html>
