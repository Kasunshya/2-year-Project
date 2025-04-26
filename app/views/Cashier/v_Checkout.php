<?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #5d2e46;    /* Deep plum */
            --primary-main: #a26b98;    /* Medium berry */
            --primary-light: #e8d7e5;   /* Light lavender */
            --accent-gold: #f1c778;     /* Soft gold */
            --accent-cream: #f9f5f0;    /* Cream */
            --accent-cinnamon: #b06f42; /* Amber brown */
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        body {
            font-family: var(--font-family);
            background-color: var(--accent-cream);
            color: var(--primary-dark);
            margin: 0;
            padding: 0;
        }
        
        .checkout-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        h2, h3 {
            color: var(--primary-dark);
            border-bottom: 2px solid var(--primary-light);
            padding-bottom: 10px;
        }
        
        .order-summary {
            background-color: var(--primary-light);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .summary-details p {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
        }
        
        .payment-methods {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .payment-method-btn {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            background-color: var(--primary-main);
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: var(--font-family);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .payment-method-btn:hover {
            background-color: var(--primary-dark);
        }
        
        .payment-method-btn.paypal {
            background-color: #0070ba;
            color: white;
        }
        
        .payment-method-btn.paypal:hover {
            background-color: #003087;
        }
        
        .payment-form {
            background-color: var(--primary-light);
            padding: 20px;
            border-radius: 8px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--primary-dark);
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: var(--font-family);
        }
        
        .form-row {
            display: flex;
            gap: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .process-btn {
            background-color: var(--accent-gold);
            color: var(--primary-dark);
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            font-family: var(--font-family);
            width: 100%;
            margin-top: 10px;
        }
        
        .process-btn:hover {
            background-color: var(--accent-cinnamon);
            color: white;
        }
        
        #paypalProcessingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(93, 46, 70, 0.8); /* Using primary-dark with opacity */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 1000;
            color: white;
            display: none;
            font-family: var(--font-family);
        }
        
        #paypalProcessingOverlay .spinner {
            border: 5px solid var(--primary-light);
            border-top: 5px solid var(--accent-gold);
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
        
        #changeAmount {
            font-weight: bold;
            color: var(--accent-cinnamon);
            font-size: 1.1em;
        }
        
        .paypal-info {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="summary-details">
                <p>Subtotal: LKR<span id="subtotal"><?php echo number_format((float)$data['subtotal'], 2); ?></span></p>
                <p>Discount: LKR<span id="discount"><?php echo number_format((float)($data['discount'] ?? 0), 2); ?></span></p>
                <p>Total: LKR<span id="total"><?php echo number_format((float)$data['total'], 2); ?></span></p>
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
                    <p>Total to pay: LKR<span id="paypalAmount"><?php echo number_format((float)$data['total'], 2); ?></span></p>
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
            const total = parseFloat(document.getElementById('total').textContent.replace(/,/g, ''));
            const tendered = parseFloat(this.value) || 0;
            const change = tendered - total;
            document.getElementById('changeAmount').textContent = 'LKR' + Math.max(0, change).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
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
