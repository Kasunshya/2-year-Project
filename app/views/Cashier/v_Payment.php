<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Employee Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/payment.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
 
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo-container">
            <img src="<?php echo URLROOT;?>/img/verticalnav/frostineLogo.png" alt="Logo" class="logo">
        </div>
        <nav>
        <ul>
                <li><a href="<?php echo URLROOT; ?>/Cashier/cashierdashboard"><i class="fas fa-home"></i></a></li>
                <li><a href="<?php echo URLROOT; ?>/Cashier/servicedesk"><i class="fas fa-boxes"></i></a></li>
                <li><a href="<?php echo URLROOT; ?>/Cashier/payment"><i class="fas fa-edit"></i></a></li>
                <li><a href="<?php echo URLROOT; ?>/Cashier/transaction"><i class="fas fa-chart-bar"></i></a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="<?php echo URLROOT; ?>/Login/logout" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </aside>

    <!-- Header Banner -->
    <header> Payment</header>
    <table class="cart-table">
      <thead>
          <tr>
              <th>Product id</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total</th>
              <th>Actions</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td>p1</td>
              <td>Vanilla Cake</td>
              <td>1</td>
              <td>LKR 2,000</td>
              <td>LKR 2,000</td>
              <td class="actions">
                  <i class="fas fa-plus-circle"></i>
                  <i class="fas fa-minus-circle"></i>
                  <i class="fas fa-trash"></i>
              </td>
          </tr>
          <tr>
              <td>p2</td>
              <td>Chocolate Muffins</td>
              <td>2</td>
              <td>LKR 500</td>
              <td>LKR 1,000</td>
              <td class="actions">
                  <i class="fas fa-plus-circle"></i>
                  <i class="fas fa-minus-circle"></i>
                  <i class="fas fa-trash"></i>
              </td>
          </tr>
          <tr>
          <td>p3</td>
              <td>Strawberry Cupcakes</td>
              <td>3</td>
              <td>LKR 400</td>
              <td>LKR 1,200</td>
              <td class="actions">
                  <i class="fas fa-plus-circle"></i>
                  <i class="fas fa-minus-circle"></i>
                  <i class="fas fa-trash"></i>
              </td>
          </tr>
      </tbody>
  </table>

  <div class="cart-summary" style="color: #783b31;">
      Grand Total: <span> LKR 4,200</span>
  </div>

  <button class="proceed-btn" style="text-align: center";>Proceed to Payment</button>
</div>
</body>
</html>