<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Desk</title>
    <?php
    // Keep the workaround in case it's needed, but remove debugging
    if (!isset($products) && isset($data) && is_array($data) && isset($data['products'])) {
        $products = $data['products'];
    }
    
    require APPROOT.'/views/inc/components/cverticalbar.php';
    ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/servicedesk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="base-url" content="<?php echo URLROOT; ?>">
</head>
<body>
  <header>
    <div class="header-container">
      <div class="title-section">
        <h1><i class="fas fa-boxes">&nbsp;</i>Service Desk</h1>
      </div>
    </div>
  </header>

  <div class="main-content">
    <div class="search-container">
      <div class="search-box">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" placeholder="Search products...">
      </div>
      <div class="cart-summary">
        <a href="<?php echo URLROOT; ?>/Cashier/viewCart" class="cart-button">
          <i class="fas fa-shopping-cart"></i> Cart (<span id="cart-count">0</span>)
        </a>
      </div>
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
        <?php if (isset($products) && (is_array($products) || is_object($products)) && count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
            <tr data-product-id="<?php echo $product->product_id; ?>">
              <td><?php echo htmlspecialchars($product->product_name); ?></td>
              <td><?php echo htmlspecialchars($product->category_name); ?></td>
              <td><?php echo $product->available_quantity; ?></td>
              <td><?php echo number_format($product->price, 2); ?></td>
              <td>
                <div class="quantity-selector">
                  <button class="decrement-btn">-</button>
                  <input type="number" class="quantity-input" value="1" min="1" max="<?php echo $product->available_quantity; ?>">
                  <button class="increment-btn">+</button>
                </div>
              </td>
              <td><button class="add-btn" onclick="addToCart(<?php echo $product->product_id; ?>, '<?php echo $product->product_name; ?>', <?php echo $product->price; ?>)">Add</button></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
              <td colspan="6">No products available.</td>
            </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <script>
    function addToCart(productId, name, price) {
        const quantityInput = document.querySelector(`tr[data-product-id="${productId}"] .quantity-input`);
        const quantity = parseInt(quantityInput.value);
        
        fetch(`${document.querySelector('meta[name="base-url"]').content}/Cashier/addToCart`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                productId,
                name,
                price,
                quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                document.getElementById('cart-count').textContent = data.cartCount;
                alert('Added to cart!');
            }
        });
    }

    // Add quantity controls
    document.querySelectorAll('.quantity-selector').forEach(selector => {
        const decrementBtn = selector.querySelector('.decrement-btn');
        const incrementBtn = selector.querySelector('.increment-btn');
        const input = selector.querySelector('.quantity-input');
        const maxQuantity = parseInt(input.getAttribute('max'));

        decrementBtn.addEventListener('click', () => {
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        });

        incrementBtn.addEventListener('click', () => {
            let value = parseInt(input.value);
            if (value < maxQuantity) {
                input.value = value + 1;
            } else {
                alert('Maximum available quantity reached!');
            }
        });

        // Validate manual input
        input.addEventListener('change', () => {
            let value = parseInt(input.value);
            if (value < 1) input.value = 1;
            if (value > maxQuantity) {
                input.value = maxQuantity;
                alert('Maximum available quantity reached!');
            }
        });
    });

    // Add this before closing </body> tag
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#productTable tbody tr');
        
        rows.forEach(row => {
            const productName = row.cells[0].textContent.toLowerCase();
            const category = row.cells[1].textContent.toLowerCase();
            
            if (productName.includes(searchTerm) || category.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
  </script>
</body>
</html>