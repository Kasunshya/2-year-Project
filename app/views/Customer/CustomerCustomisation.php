<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Customization</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #c98d83;
            --secondary: #783b31;
            --bg: #f2f1ec;
            --white: #ffffff;
            --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --black: #333333;
        }
        * {
            font-family: 'Vidaloka', serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-transform: capitalize;
        }
        body {
            background-color: var(--bg);
            color: var(--secondary);
        }
        header {
            background-color: var(--primary-color);
            padding: 2rem;
            text-align: center;
            color: var(--white);
            font-size: 2.5rem;
            text-transform: uppercase;
        }
        /* Navigation Bar */
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
        section {
            padding: 3rem 7%;
        }
        .customization-form {
            background: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
        }
        .customization-form h2 {
            color: var(--primary-color);
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group textarea {
            resize: none;
            height: 100px;
        }
        .btn {
            background: var(--primary-color);
            color: var(--white);
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .btn:hover {
            background: var(--secondary);
        }
        .summary-section {
            margin-top: 3rem;
        }
        .summary-section h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }
        .summary {
            background: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
        }
        .summary p {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        .toppings-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .price-summary {
            margin: 2rem 0;
            padding: 1rem;
            background: #f8f8f8;
            border-radius: 5px;
        }

        .price-summary .total {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-color);
            border-top: 1px solid #ddd;
            margin-top: 1rem;
            padding-top: 1rem;
        }

        .delivery-options {
            display: flex;
            gap: 2rem;
            margin-top: 0.5rem;
        }

        .delivery-options label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        #deliveryAddressGroup textarea {
            width: 100%;
            min-height: 100px;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        small {
            color: #666;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: block;
        }

        .toppings-container {
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
        }

        .toppings-column {
            flex: 1;
            background: #f9f9f9;
            padding: 1rem;
            border-radius: 8px;
        }

        .toppings-column h4 {
            color: var(--secondary);
            margin-bottom: 1rem;
            text-align: center;
        }

        .toppings-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.8rem;
        }

        .topping-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .topping-item:hover {
            background: #f0f0f0;
        }

        .delivery-container {
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
        }

        .delivery-option {
            flex: 1;
            cursor: pointer;
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .delivery-option:hover {
            background: #f0f0f0;
        }

        .delivery-content {
            margin-left: 1.5rem;
        }

        .delivery-content h4 {
            color: var (--secondary);
            margin-bottom: 0.5rem;
        }

        .delivery-content p {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 0.3rem;
        }

        .delivery-content small {
            color: #666;
        }

        .messages {
            margin-bottom: 20px;
        }
        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body >


<!-- Navigation Bar -->
<div class="navbar">
        <a href="#" class="logo">FROSTINE</a>
        <ul>
            <li><a href="<?php echo URLROOT ?>/customer/customerhomepage">Home</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerhomepage#about">About</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerproducts">Products</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customercustomisation">Customization</a></li>
            <li><a href="<?php echo URLROOT ?>/customer/customerprofile">Profile</a></li>
        </ul>
    </div>

<header>Customization</header>

<section>
    <div class="customization-form">
        <h2>Customize Your Cake</h2>
        <div class="messages">
            <?php flash('customization_error'); ?>
            <?php flash('customization_success'); ?>
        </div>
        <?php flash('customization_message'); ?>
        <form action="<?php echo URLROOT; ?>/customer/submitCustomization" method="POST">
            <!-- Cake Flavor -->
            <div class="form-group">
                <label for="flavor">Cake Flavor* (Prices shown are for 1kg/2.2lb cake)</label>
                <select id="flavor" name="flavor" required>
                    <option value="">Select a cake flavor</option>
                    <option value="Vanilla" data-price="3500">Classic Vanilla (LKR 3500)</option>
                    <option value="Chocolate" data-price="4000">Rich Chocolate (LKR 4000)</option>
                    <option value="Red Velvet" data-price="4500">Red Velvet (LKR 4500)</option>
                    <option value="Black Forest" data-price="4800">Black Forest (LKR 4800)</option>
                    <option value="Butterscotch" data-price="4300">Butterscotch (LKR 4300)</option>
                </select>
            </div>

            <!-- Cake Size -->
            <div class="form-group">
                <label for="size">Cake Size*</label>
                <select id="size" name="size" required>
                    <option value="">Select cake size</option>
                    <option value="1pound" data-multiplier="1">1 Pound (6-8 servings)</option>
                    <option value="2pound" data-multiplier="1.8">2 Pound (12-15 servings)</option>
                    <option value="3pound" data-multiplier="2.5">3 Pound (18-24 servings)</option>
                    <option value="4pound" data-multiplier="3.2">4 Pound (25-30 servings)</option>
                </select>
            </div>

            <!-- Cake Toppings -->
            <div class="form-group">
                <label>Cake Toppings & Decorations</label>
                <div class="toppings-container">
                    <div class="toppings-column">
                        <h4>Regular Toppings (LKR 500 each)</h4>
                        <div class="toppings-grid">
                            <label class="topping-item">
                                <input type="checkbox" name="toppings[]" value="Fresh Fruits">
                                <span>Fresh Fruits</span>
                            </label>
                            <label class="topping-item">
                                <input type="checkbox" name="toppings[]" value="Chocolate Chips">
                                <span>Chocolate Chips</span>
                            </label>
                            <label class="topping-item">
                                <input type="checkbox" name="toppings[]" value="Mixed Nuts">
                                <span>Mixed Nuts</span>
                            </label>
                            <label class="topping-item">
                                <input type="checkbox" name="toppings[]" value="Sprinkles">
                                <span>Sprinkles</span>
                            </label>
                        </div>
                    </div>
                    <div class="toppings-column">
                        <h4>Premium Toppings (LKR 800 each)</h4>
                        <div class="toppings-grid">
                            <label class="topping-item">
                                <input type="checkbox" name="premium_toppings[]" value="Edible Flowers">
                                <span>Edible Flowers</span>
                            </label>
                            <label class="topping-item">
                                <input type="checkbox" name="premium_toppings[]" value="Fondant Decorations">
                                <span>Fondant Decorations</span>
                            </label>
                            <label class="topping-item">
                                <input type="checkbox" name="premium_toppings[]" value="Chocolate Garnish">
                                <span>Chocolate Garnish</span>
                            </label>
                            <label class="topping-item">
                                <input type="checkbox" name="premium_toppings[]" value="Gold Leaf">
                                <span>Gold Leaf</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom Message -->
            <div class="form-group">
                <label for="message">Cake Message</label>
                <textarea id="message" name="message" maxlength="50" 
                    placeholder="Enter the message you want on your cake (Maximum 50 characters)"></textarea>
            </div>

            <!-- Delivery Options -->
            <div class="form-group">
                <label>Delivery Option*</label>
                <div class="delivery-container">
                    <label class="delivery-option">
                        <input type="radio" name="delivery_option" value="pickup" required>
                        <div class="delivery-content">
                            <h4>Store Pickup</h4>
                            <p>Free of charge</p>
                            <small>Pick up from our store location</small>
                        </div>
                    </label>
                    <label class="delivery-option">
                        <input type="radio" name="delivery_option" value="delivery">
                        <div class="delivery-content">
                            <h4>Home Delivery</h4>
                            <p>LKR 500</p>
                            <small>Delivery within Colombo area</small>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Branch Selection -->
            <div class="form-group" id="branchSelectGroup" style="display: none;">
                <label for="branch_id">Select Pickup Branch*</label>
                <select id="branch_id" name="branch_id">
                    <option value="">Select a branch</option>
                    <?php if(isset($data['branches']) && is_array($data['branches'])) : ?>
                        <?php foreach($data['branches'] as $branch) : ?>
                            <option value="<?php echo $branch->branch_id; ?>">
                                <?php echo htmlspecialchars($branch->branch_name); ?> - 
                                <?php echo htmlspecialchars($branch->branch_address); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <small>Please select the branch you'd like to pick up your order from</small>
            </div>

            <!-- Delivery Address (shown only when delivery is selected) -->
            <div class="form-group" id="deliveryAddressGroup" style="display: none;">
                <label for="delivery_address">Delivery Address*</label>
                <textarea id="delivery_address" name="delivery_address" 
                    placeholder="Enter your complete delivery address"></textarea>
            </div>

            <!-- Delivery/Pickup Date -->
            <div class="form-group">
                <label for="deliveryDate">Required Date*</label>
                <input type="date" id="deliveryDate" name="delivery_date" required 
                    min="<?php echo date('Y-m-d', strtotime('+2 days')); ?>">
                <small>* Please order at least 2 days in advance</small>
            </div>

            <!-- Price Summary -->
            <div class="price-summary">
                <p>Base Price: <span id="basePrice">LKR 0.00</span></p>
                <p>Size Adjustment: <span id="sizePrice">LKR 0.00</span></p>
                <p>Toppings: <span id="toppingsPrice">LKR 0.00</span></p>
                <p>Delivery Fee: <span id="deliveryPrice">LKR 0.00</span></p>
                <p class="total">Total Price: <span id="totalPrice">LKR 0.00</span></p>
            </div>

            <input type="hidden" name="total_price" id="hiddenTotalPrice">
            <button type="submit" class="btn">Place Cake Order</button>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get existing elements from your current code
    const form = document.querySelector('form');
    const flavorSelect = document.getElementById('flavor');
    const sizeSelect = document.getElementById('size');
    const toppingsCheckboxes = document.getElementsByName('toppings[]');
    const premiumToppingsCheckboxes = document.getElementsByName('premium_toppings[]');
    const deliveryOptions = document.getElementsByName('delivery_option');
    const deliveryAddressGroup = document.getElementById('deliveryAddressGroup');
    const deliveryAddress = document.getElementById('delivery_address');
    const totalPriceInput = document.getElementById('hiddenTotalPrice');
    
    // Add reference to branch selection group
    const branchSelectGroup = document.getElementById('branchSelectGroup');
    const branchSelect = document.getElementById('branch_id');

    // Calculate total immediately when page loads
    calculateTotal();

    // Show/hide delivery address based on delivery option
    deliveryOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'delivery') {
                // Show delivery address, hide branch selection
                deliveryAddressGroup.style.display = 'block';
                branchSelectGroup.style.display = 'none';
                deliveryAddress.required = true;
                branchSelect.required = false;
            } else if (this.value === 'pickup') {
                // Show branch selection, hide delivery address
                deliveryAddressGroup.style.display = 'none';
                branchSelectGroup.style.display = 'block';
                deliveryAddress.required = false;
                branchSelect.required = true;
            }
            calculateTotal();
        });
    });

    function calculateTotal() {
        // Base price from selected flavor
        let basePrice = parseFloat(flavorSelect.options[flavorSelect.selectedIndex]?.dataset.price || 0);
        
        // Size multiplier
        let sizeMultiplier = parseFloat(sizeSelect.options[sizeSelect.selectedIndex]?.dataset.multiplier || 1);
        
        // Regular toppings (500 each)
        let toppingsPrice = [...toppingsCheckboxes]
            .filter(cb => cb.checked)
            .length * 500;
        
        // Premium toppings (800 each)
        let premiumToppingsPrice = [...premiumToppingsCheckboxes]
            .filter(cb => cb.checked)
            .length * 800;
        
        // Delivery fee
        let deliveryFee = document.querySelector('input[name="delivery_option"]:checked')?.value === 'delivery' ? 500 : 0;

        // Calculate size adjustment
        let sizeAdjustment = basePrice * (sizeMultiplier - 1);
        
        // Calculate total
        let total = basePrice + sizeAdjustment + toppingsPrice + premiumToppingsPrice + deliveryFee;

        // Update display values
        document.getElementById('basePrice').textContent = `LKR ${basePrice.toFixed(2)}`;
        document.getElementById('sizePrice').textContent = `LKR ${sizeAdjustment.toFixed(2)}`;
        document.getElementById('toppingsPrice').textContent = `LKR ${(toppingsPrice + premiumToppingsPrice).toFixed(2)}`;
        document.getElementById('deliveryPrice').textContent = `LKR ${deliveryFee.toFixed(2)}`;
        document.getElementById('totalPrice').textContent = `LKR ${total.toFixed(2)}`;
        
        // Set hidden input value
        totalPriceInput.value = total;
    }

    // Add event listeners for all form elements
    [flavorSelect, sizeSelect].forEach(element => {
        element.addEventListener('change', calculateTotal);
    });

    [...toppingsCheckboxes, ...premiumToppingsCheckboxes].forEach(checkbox => {
        checkbox.addEventListener('change', calculateTotal);
    });

    // Form validation
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!flavorSelect.value || !sizeSelect.value || !document.querySelector('input[name="delivery_option"]:checked')) {
            alert('Please fill in all required fields');
            return;
        }

        const selectedDeliveryOption = document.querySelector('input[name="delivery_option"]:checked').value;
        
        if (selectedDeliveryOption === 'delivery' && !deliveryAddress.value) {
            alert('Please enter your delivery address');
            return;
        }
        
        if (selectedDeliveryOption === 'pickup' && !branchSelect.value) {
            alert('Please select a pickup branch');
            return;
        }

        // If validation passes, submit the form
        this.submit();
    });
});
</script>

</body>
</html>
