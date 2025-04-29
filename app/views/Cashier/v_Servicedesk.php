<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Desk</title>
    <?php
    
    if (!isset($products) && isset($data) && is_array($data) && isset($data['products'])) {
        $products = $data['products'];
    }
    
    require APPROOT.'/views/inc/components/cverticalbar.php';
    ?>
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/servicedesk.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/stock-badges.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Add SweetAlert2 library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="base-url" content="<?php echo URLROOT; ?>">
    <style>
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            display: block;
            margin: 0 auto;
        }
        .product-name {
            font-weight: bold;
            margin-top: 5px;
            text-align: center;
        }
        .product-cell {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
        }
    </style>
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
          <th>Branch Stock</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (isset($products) && (is_array($products) || is_object($products)) && count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
              <?php 
                
                $stockQuantity = isset($product->branch_quantity) ? $product->branch_quantity : $product->available_quantity;
                $outOfStock = $stockQuantity <= 0;
                
                
                error_log("Product: " . $product->product_name . ", Image path: " . ($product->image_path ?? 'No image'));
              ?>
              <tr data-product-id="<?php echo $product->product_id; ?>" class="<?php echo $outOfStock ? 'out-of-stock' : ''; ?>">
                <td>
                    <?php if(isset($product->image_path) && !empty($product->image_path)): ?>
                        <img src="<?php echo URLROOT; ?>/public/img/products/<?php echo $product->image_path; ?>" alt="<?php echo htmlspecialchars($product->product_name); ?>" class="product-image">
                    <?php else: ?>
                        <img src="<?php echo URLROOT; ?>/public/img/products/placeholder.jpg" alt="No Image" class="product-image">
                    <?php endif; ?>
                    <div class="product-name"><?php echo htmlspecialchars($product->product_name); ?></div>
                </td>
                <td><?php echo htmlspecialchars($product->category_name); ?></td>
                <td class="stock-cell">
                  <span class="stock-badge <?php echo $outOfStock ? 'out-of-stock' : 'in-stock'; ?>">
                    <?php echo $stockQuantity; ?>
                  </span>
                </td>
                <td>LKR <?php echo number_format($product->price, 2); ?></td>
                <td>
                  <div class="quantity-selector">
                    <button class="decrement-btn" <?php echo $outOfStock ? 'disabled' : ''; ?>>-</button>
                    <input type="number" class="quantity-input" value="1" min="1" max="<?php echo $stockQuantity; ?>" <?php echo $outOfStock ? 'disabled' : ''; ?>>
                    <button class="increment-btn" <?php echo $outOfStock ? 'disabled' : ''; ?>>+</button>
                  </div>
                </td>
                <td>
                  <button class="add-btn" 
                    onclick="addToCart(<?php echo $product->product_id; ?>, '<?php echo addslashes($product->product_name); ?>', <?php echo $product->price; ?>)" 
                    <?php echo $outOfStock ? 'disabled' : ''; ?>>
                    <?php echo $outOfStock ? 'Out of Stock' : 'Add'; ?>
                  </button>
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
  </div>

  <script>
    function addToCart(productId, name, price) {
        const row = document.querySelector(`tr[data-product-id="${productId}"]`);
        const quantityInput = row.querySelector('.quantity-input');
        const quantity = parseInt(quantityInput.value);
        const maxQuantity = parseInt(quantityInput.getAttribute('max'));

        
        if (maxQuantity <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Out of Stock',
                text: 'Sorry, this product is out of stock at your branch.'
            });
            return;
        }

        
        if (quantity > maxQuantity) {
            Swal.fire({
                icon: 'warning',
                title: 'Limited Stock',
                text: `Sorry, only ${maxQuantity} items available in your branch.`
            });
            quantityInput.value = maxQuantity;
            return;
        }

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
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Added to cart!',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }

    
    document.querySelectorAll('.quantity-selector').forEach(selector => {
        const decrementBtn = selector.querySelector('.decrement-btn');
        const incrementBtn = selector.querySelector('.increment-btn');
        const input = selector.querySelector('.quantity-input');
        const maxQuantity = parseInt(input.getAttribute('max')) || 0;

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
                Swal.fire({
                    icon: 'info',
                    title: 'Maximum Quantity Reached',
                    text: 'Maximum available quantity reached!'
                });
            }
        });

        
        input.addEventListener('change', () => {
            let value = parseInt(input.value);
            if (value < 1) input.value = 1;
            if (value > maxQuantity) {
                input.value = maxQuantity;
                Swal.fire({
                    icon: 'info',
                    title: 'Maximum Quantity Reached',
                    text: 'Maximum available quantity reached!'
                });
            }
        });
    });

    
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

    
    window.addEventListener('load', function() {
        
        fetch(`${document.querySelector('meta[name="base-url"]').content}/Cashier/getCartCount`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if(data.count !== undefined) {
                document.getElementById('cart-count').textContent = data.count;
            }
        })
        .catch(error => {
            console.error('Error fetching cart count:', error);
        });
    });
  </script>
</body>
</html>