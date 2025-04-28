<?php
require_once '../app/models/M_SysAdminP.php';

class CustomerCheckout {
    public $branches;
    private $adminModel;
    
    public function __construct() {
        $this->adminModel = new M_SysAdminP();
        $this->branches = $this->adminModel->getAllBranches();
    }
}

// Create an instance to make branches available
$checkout = new CustomerCheckout();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #c98d83;
            --secondary: #783b31;
            --bg: #f2f1ec;
            --white: #ffffff;
            --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1);
        }

        * {
            font-family: 'Vidaloka', serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-transform: capitalize;
        }
        .profile-title {
            background-color: #c98d83;
            padding: 1.5rem;
            text-align: center;
            color: #ffffff;
            font-size: 2rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Poppins', sans-serif;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            header {
                font-size: 1.5rem;
                padding: 1.2rem;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
        body {
            background: var(--background-color) url('/images/banner-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--black);
        }
   }
        /* Navigation Bar */
        /* Add these styles in the <style> tag after the existing navbar styles */
.navbar {
    background-color: var(--white);
    box-shadow: var(--box-shadow);
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 1rem 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar .logo {
    color: var(--secondary);
    font-size: 1.8rem;
    font-weight: 600;
    text-decoration: none;
    letter-spacing: 2px;
}

.navbar ul {
    display: flex;
    list-style: none;
    gap: 2rem;
    margin: 0;
    padding: 0;
}

.navbar ul li {
    position: relative;
}

.navbar ul li a {
    color: var(--black);
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    transition: var(--transition);
    padding: 0.5rem 0;
}

.navbar ul li a:hover {
    color: var(--primary-color);
}

.navbar ul li a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--primary-color);
    transition: var(--transition);
}

.navbar ul li a:hover::after {
    width: 100%;
}

/* Add responsive navbar styles */
@media (max-width: 992px) {
    .navbar {
        padding: 1rem 2%;
    }

    .navbar .logo {
        font-size: 1.5rem;
    }

    .navbar ul {
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        padding: 1rem;
    }

    .navbar .logo {
        margin-bottom: 1rem;
    }

    .navbar ul {
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
    }

    .navbar ul li a {
        font-size: 0.9rem;
    }
}
        /* Payment Form */
        .container {
            max-width: 1200px;
            margin: 80px auto 50px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            padding: 20px;
        }

        .container h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: var(--secondary-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
            color: var(--secondary-color);
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .form-row {
            display: flex;
            gap: 10px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .checkout-btn {
            display: block;
            width: auto; /* Changed from 100% to auto */
            min-width: 200px; /* Added minimum width */
            padding: 10px 30px; /* Added horizontal padding */
            margin: 0 auto; /* Center the button */
            background: var(--primary-color);
            color: var(--white);
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .checkout-btn:hover {
            background:#783b31;
        }

        .secure-info {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--black);
        }

        .secure-info i {
            color: var(--primary-color);
        }

        select, textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        select:focus, textarea:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        #pickup-date {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .section-container {
            flex: 1;
            min-width: 400px;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.95);
        }

        .section-container h2 {
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .checkout-btn-container {
            width: 100%;
            text-align: center;
            padding: 20px 0;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            margin-top: 20px;
        }
        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--primary-color);
            color: var(--white);
        }
        
        .btn:hover {
            background: var(--secondary);
        }

        .btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .order-summary {
            padding: 15px 0;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: var(--secondary-color);
        }

        .summary-divider {
            border-top: 1px solid #ddd;
            margin: 15px 0;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-weight: bold;
        }

        .summary-item.discount {
            color: #2e7d32;
        }

        .summary-item.total {
            font-size: 1.2em;
            color: var(--secondary-color);
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }

        .delivery-notice {
            color: #e65100;
            font-size: 0.9rem;
        }

        .delivery-notice ul {
            margin-top: 8px;
        }

        .delivery-notice i {
            color: #f57c00;
            margin-right: 5px;
        }

        #delivery-district {
            margin-bottom: 15px;
        }

        input[type="tel"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        input[type="tel"]:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .form-group small {
            font-size: 0.8rem;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <?php require_once APPROOT . '/views/customer/RegisteredCustomerNav.php'; ?>

    <!-- Payment Form -->
    
    <div class="profile-title">Payment Details</div>
    <div class="container">
        <!-- Add this before the payment form -->
        <div class="section-container">
            <h2 style="color: #783b31; margin-bottom: 20px;">Order Summary</h2>
            <div class="order-summary">
                <?php foreach ($data['cartItems'] as $item): ?>
                    <div class="order-item">
                        <span><?php echo htmlspecialchars($item['name']); ?> x <?php echo $item['quantity']; ?></span>
                        <span>LKR <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                    </div>
                <?php endforeach; ?>
                
                <div class="summary-divider"></div>
                
                <div class="summary-item">
                    <span>Subtotal:</span>
                    <span>LKR <?php echo number_format($data['subtotal'], 2); ?></span>
                </div>
                
                <?php if ($data['discount'] > 0): ?>
                    <div class="summary-item discount">
                        <span>Discount (<?php echo $data['promotion_discount']; ?>% Off):</span>
                        <span>-LKR <?php echo number_format($data['discount'], 2); ?></span>
                    </div>
                <?php endif; ?>
                
                <div class="summary-item total">
                    <span>Total Amount:</span>
                    <span>LKR <?php echo number_format($data['total'], 2); ?></span>
                </div>
            </div>
        </div>

        <form method="POST" action="<?php echo URLROOT; ?>/customer/processPayment" class="checkout-form">
            <!-- Hidden fields for order data -->
            <input type="hidden" name="total" value="<?php echo $data['total']; ?>">
            <input type="hidden" name="subtotal" value="<?php echo $data['subtotal']; ?>">
            <input type="hidden" name="discount" value="<?php echo $data['discount']; ?>">
            <input type="hidden" name="cart_items" value='<?php echo htmlspecialchars(json_encode($data['cartItems'])); ?>'>
            <?php if (isset($data['promotion_title'])): ?>
                <input type="hidden" name="promotion_title" value="<?php echo htmlspecialchars($data['promotion_title']); ?>">
                <input type="hidden" name="promotion_discount" value="<?php echo htmlspecialchars($data['promotion_discount']); ?>">
            <?php endif; ?>

            <!-- Delivery Section -->
            <div class="section-container">
                <h2 style="color: #783b31; margin-bottom: 20px;">Delivery Details</h2>
                
                <div class="delivery-notice" style="margin-bottom: 20px; padding: 10px; background: #fff3e0; border-radius: 5px;">
                    <p><i class="fas fa-info-circle"></i> Important Notes:</p>
                    <ul style="list-style: none; padding-left: 20px; margin-top: 5px;">
                        <li>• All orders are for same-day delivery/pickup</li>
                        <li>• Delivery is available only within Western Province</li>
                        <li>• Orders placed after 6 PM will be processed the next day</li>
                    </ul>
                </div>
                
                <div class="form-group" style="color: #783b31;">
                    <label for="contact-number">Contact Number*</label>
                    <input type="tel" 
                           id="contact-number" 
                           name="contact_number" 
                           placeholder="Enter your contact number (e.g., 0771234567)" 
                           pattern="[0-9]{10}" 
                           required>
                </div>

                <div class="form-group" style="color: #783b31;">
                    <label for="delivery-type">Delivery Option</label>
                    <select id="delivery-type" name="delivery_type" onchange="toggleDeliveryAddress(); validateDeliveryArea();" required>
                        <option value="">Select Delivery Option</option>
                        <option value="delivery">Home Delivery</option>
                        <option value="pickup">Store Pickup</option>
                    </select>
                </div>

                <div id="delivery-address-section" style="display: none;">
                    <div class="form-group" style="color: #783b31;">
                        <label for="delivery-district">District</label>
                        <select id="delivery-district" name="delivery_district" onchange="validateDeliveryArea()" required>
                            <option value="">Select District</option>
                            <option value="colombo">Colombo</option>
                            <option value="gampaha">Gampaha</option>
                            <option value="kalutara">Kalutara</option>
                        </select>
                    </div>
                    <div class="form-group" style="color: #783b31;">
                        <label for="delivery-address">Delivery Address</label>
                        <textarea id="delivery-address" name="delivery_address" rows="3" 
                                  placeholder="Enter your complete delivery address" required></textarea>
                    </div>
                </div>

                <div id="pickup-section" style="display: none;">
                    <div class="form-group" style="color: #783b31;">
                        <label for="branch">Select Branch</label>
                        <select id="branch" name="branch">
                            <option value="">Select Branch</option>
                            <?php 
                            if (isset($data['branches']) && is_array($data['branches'])): 
                                foreach($data['branches'] as $branch): ?>
                                    <option value="<?php echo htmlspecialchars($branch->branch_id); ?>">
                                        <?php echo htmlspecialchars($branch->branch_name) . ' - ' . 
                                                 htmlspecialchars($branch->branch_address); ?>
                                    </option>
                            <?php 
                                endforeach;
                            endif; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Payment Section -->
            <div class="section-container">
                <h2 style="color: #783b31; margin-bottom: 20px;">Payment Details</h2>
                
                <div class="form-group" style="color: #783b31;">
                    <label for="cardholder-name">Cardholder Name</label>
                    <input type="text" id="cardholder-name" name="cardholder_name" 
                           placeholder="Enter Cardholder Name" required>
                </div>

                <div class="form-group" style="color: #783b31;">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" name="card_number" 
                           placeholder="Enter Card Number" required
                           maxlength="16" pattern="\d{16}"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           title="Please enter a valid 16-digit card number">
                </div>
                <div class="form-row">
                    <div class="form-group" style="color: #783b31;">
                        <label for="expiry-date">Expiration Date</label>
                        <input type="text" id="expiry-date" name="expiry_date" 
                               placeholder="MM/YY" required
                               pattern="(0[1-9]|1[0-2])\/([0-9]{2})"
                               maxlength="5"
                               title="Please enter a valid expiration date (MM/YY)">
                    </div>
                    <div class="form-group" style="color: #783b31;">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" 
                               placeholder="123" required
                               maxlength="3" pattern="\d{3}"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               title="Please enter a valid 3-digit CVV">
                    </div>
                </div>
            </div>

            <div class="checkout-btn-container">
                <button type="submit" class="btn" id="confirm-payment">
                    Confirm Payment
                    <i class="fas fa-lock" style="margin-left: 10px;"></i>
                </button>
            </div>
        </form>
        
        
    </div>

    <!-- Add this JavaScript before closing body tag -->
    <script>
        function toggleDeliveryAddress() {
            const deliveryType = document.getElementById('delivery-type').value;
            const deliveryAddressSection = document.getElementById('delivery-address-section');
            const pickupSection = document.getElementById('pickup-section');
            
            if (deliveryType === 'delivery') {
                deliveryAddressSection.style.display = 'block';
                pickupSection.style.display = 'none';
                document.getElementById('delivery-district').required = true;
                document.getElementById('delivery-address').required = true;
                document.getElementById('branch').required = false;
            } else if (deliveryType === 'pickup') {
                deliveryAddressSection.style.display = 'none';
                pickupSection.style.display = 'block';
                document.getElementById('delivery-district').required = false;
                document.getElementById('delivery-address').required = false;
                document.getElementById('branch').required = true;
            } else {
                deliveryAddressSection.style.display = 'none';
                pickupSection.style.display = 'none';
                document.getElementById('delivery-district').required = false;
                document.getElementById('delivery-address').required = false;
                document.getElementById('branch').required = false;
            }
        }

        function validateDeliveryArea() {
            const deliveryType = document.getElementById('delivery-type').value;
            const district = document.getElementById('delivery-district').value;
            const confirmBtn = document.getElementById('confirm-payment');
            
            if (deliveryType === 'delivery' && district) {
                const westernProvinceDistricts = ['colombo', 'gampaha', 'kalutara'];
                if (!westernProvinceDistricts.includes(district)) {
                    alert('We currently only deliver within Western Province (Colombo, Gampaha, and Kalutara districts).');
                    confirmBtn.disabled = true;
                    return false;
                }
            }
            confirmBtn.disabled = false;
            return true;
        }

        // Check if current time is after 6 PM
        const currentHour = new Date().getHours();
        if (currentHour >= 18) {
            alert('Orders placed after 6 PM will be processed the next business day.');
        }

        // Set minimum date to today
        const pickupDateInput = document.getElementById('pickup-date');
        const today = new Date().toISOString().split('T')[0];
        pickupDateInput.min = today;

        // Add this to your existing script section
        document.addEventListener('DOMContentLoaded', function() {
            // Card number validation
            const cardNumber = document.getElementById('card-number');
            cardNumber.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 16) {
                    this.value = this.value.slice(0, 16);
                }
            });

            // CVV validation
            const cvv = document.getElementById('cvv');
            cvv.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 3) {
                    this.value = this.value.slice(0, 3);
                }
            });

            // Expiry date validation
            const expiryDate = document.getElementById('expiry-date');
            expiryDate.addEventListener('input', function(e) {
                let value = this.value;
                
                // Remove all non-digits
                value = value.replace(/[^0-9]/g, '');
                
                // Add slash after month
                if (value.length >= 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2);
                }
                
                // Limit to MM/YY format
                if (value.length > 5) {
                    value = value.slice(0, 5);
                }
                
                this.value = value;
                
                // Validate month and year
                if (value.length === 5) {
                    const month = parseInt(value.slice(0, 2));
                    const year = parseInt(value.slice(3));
                    const currentDate = new Date();
                    const currentYear = currentDate.getFullYear() % 100;
                    const currentMonth = currentDate.getMonth() + 1;
                    
                    if (month < 1 || month > 12) {
                        alert('Please enter a valid month (01-12)');
                        this.value = '';
                        return;
                    }
                    
                    if (year < currentYear || (year === currentYear && month < currentMonth)) {
                        alert('Card expiration date must be in the future');
                        this.value = '';
                        return;
                    }
                }
            });

            // Add contact number validation
            document.getElementById('contact-number').addEventListener('input', function(e) {
                // Remove any non-numeric characters
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Limit to 10 digits
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });

            // Form submission validation
            document.querySelector('form').addEventListener('submit', function(e) {
                if (!validateDeliveryArea()) {
                    e.preventDefault();
                    return;
                }
                const cardNumber = document.getElementById('card-number').value;
                const cvv = document.getElementById('cvv').value;
                const expiryDate = document.getElementById('expiry-date').value;
                const contactNumber = document.getElementById('contact-number').value;

                if (cardNumber.length !== 16) {
                    alert('Card number must be 16 digits');
                    e.preventDefault();
                    return;
                }

                if (cvv.length !== 3) {
                    alert('CVV must be 3 digits');
                    e.preventDefault();
                    return;
                }

                if (!expiryDate.match(/^(0[1-9]|1[0-2])\/([0-9]{2})$/)) {
                    alert('Please enter a valid expiration date (MM/YY)');
                    e.preventDefault();
                    return;
                }

                if (contactNumber.length !== 10) {
                    alert('Please enter a valid 10-digit contact number');
                    e.preventDefault();
                    return;
                }
            });
        });
    </script>
</body>
</html>
