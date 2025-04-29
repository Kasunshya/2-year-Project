<?php require APPROOT.'/views/inc/components/cverticalbar.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="base-url" content="<?php echo URLROOT; ?>">
</head>
<body>
    <div class="cart-container">
        <h2>Shopping Cart</h2>
        <?php if (!empty($data['cart'])): ?>
            <div class="cart-items">
                <?php foreach ($data['cart'] as $item): ?>
                    <div class="cart-item" data-product-id="<?php echo $item['productId']; ?>" data-price="<?php echo $item['price']; ?>">
                        <span class="item-name"><?php echo $item['name']; ?></span>
                        <div class="quantity-selector">
                            <button class="cart-button decrement-btn">-</button>
                            <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1">
                            <button class="cart-button increment-btn">+</button>
                        </div>
                        <span class="item-price">LKR<?php echo number_format($item['price'], 2); ?></span>
                        <span class="item-subtotal">LKR<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                        <button class="remove-btn"><i class="fas fa-trash"></i></button>
                    </div>
                <?php endforeach; ?>
                
                <div class="cart-summary">
                    <div class="discount-section">
                        <input type="number" id="discount-input" min="0" max="100" placeholder="Discount %">
                        <button onclick="applyDiscount()" class="apply-discount-btn">Apply Discount</button>
                    </div>
                    <div class="cart-total">
                        <h3>Subtotal: LKR<span id="subtotal-amount"><?php echo number_format($data['total'], 2); ?></span></h3>
                        <h3>Discount: LKR<span id="discount-amount">0.00</span></h3>
                        <h3>Total: LKR<span id="total-amount"><?php echo number_format($data['total'], 2); ?></span></h3>
                    </div>
                    <div class="checkout-actions">
                        <a href="<?php echo URLROOT; ?>/Cashier/servicedesk" class="continue-shopping">Continue Shopping</a>
                        <button onclick="proceedToCheckout()" class="checkout-btn">Proceed to Checkout</button>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p class="empty-cart">Your cart is empty</p>
            <a href="<?php echo URLROOT; ?>/Cashier/servicedesk" class="continue-shopping">Continue Shopping</a>
        <?php endif; ?>
    </div>

    <script>
    document.querySelectorAll('.cart-item').forEach(item => {
        const productId = parseInt(item.dataset.productId);
        const price = parseFloat(item.dataset.price);
        const quantityInput = item.querySelector('.quantity-input');
        const subtotalSpan = item.querySelector('.item-subtotal');
        
        function updateQuantity(newQuantity) {
            if (newQuantity < 1) return;
            
            fetch(`${document.querySelector('meta[name="base-url"]').content}/Cashier/updateCartQuantity`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    productId: productId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    
                    const subtotal = price * newQuantity;
                    subtotalSpan.textContent = `LKR${subtotal.toFixed(2)}`;
                    
                    
                    document.getElementById('total-amount').textContent = data.newTotal.toFixed(2);
                }
            });
        }

        item.querySelector('.decrement-btn').addEventListener('click', () => {
            const newQuantity = parseInt(quantityInput.value) - 1;
            if (newQuantity >= 1) {
                quantityInput.value = newQuantity;
                updateQuantity(newQuantity);
            }
        });

        item.querySelector('.increment-btn').addEventListener('click', () => {
            const newQuantity = parseInt(quantityInput.value) + 1;
            quantityInput.value = newQuantity;
            updateQuantity(newQuantity);
        });

        quantityInput.addEventListener('change', () => {
            let newQuantity = parseInt(quantityInput.value);
            if (newQuantity < 1) newQuantity = 1;
            quantityInput.value = newQuantity;
            updateQuantity(newQuantity);
        });

        item.querySelector('.remove-btn').addEventListener('click', () => {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to remove this item?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${document.querySelector('meta[name="base-url"]').content}/Cashier/removeFromCart`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ productId: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.cartEmpty) {
                                location.reload();
                            } else {
                                item.remove();
                                document.getElementById('total-amount').textContent = data.newTotal.toFixed(2);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed',
                                    text: 'Item has been removed from cart',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        }
                    });
                }
            });
        });
    });

    function applyDiscount() {
        const discountPercent = parseFloat(document.getElementById('discount-input').value) || 0;
        if (discountPercent < 0 || discountPercent > 100) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Discount',
                text: 'Discount must be between 0 and 100'
            });
            return;
        }
        
        const subtotal = parseFloat(document.getElementById('subtotal-amount').textContent.replace(/,/g, ''));
        const discountAmount = (subtotal * discountPercent / 100);
        const newTotal = subtotal - discountAmount;
        
        document.getElementById('discount-amount').textContent = discountAmount.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('total-amount').textContent = newTotal.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        
        
        fetch(`${document.querySelector('meta[name="base-url"]').content}/Cashier/applyDiscount`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ discount: discountAmount })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Discount Applied',
                    text: `${discountPercent}% discount has been applied`,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }

    function proceedToCheckout() {
        window.location.href = `${document.querySelector('meta[name="base-url"]').content}/Cashier/checkout`;
    }
    </script>
</body>
</html>
