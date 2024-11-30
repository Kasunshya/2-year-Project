<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Employee Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/transactions.css">
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
            <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </aside>

    <!-- Header Banner -->
    <header> Daily Transactions</header>
    <!-- Main Content -->
    <div class="main-content">
      <table class="transaction-table">
          <thead>
              <tr>
                  <th>Order Id</th>
                  <th>Date</th>
                  <th>Total Sales</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>#458796321</td>
                  <td>07 March 2024, 12:30</td>
                  <td>LKR 5000.00</td>
              </tr>
              <tr>
                  <td>#458796321</td>
                  <td>07 March 2024, 12:30</td>
                  <td>LKR 5000.00</td>
              </tr>
              <tr>
                  <td>#458796321</td>
                  <td>07 March 2024, 12:30</td>
                  <td>LKR 5000.00</td>
              </tr>
          </tbody>
      </table>
  </div>

  <!-- Summary Box -->
  <div class="summary-box">
      
      <h3>Summary Box</h3>
      <p>Total Sales: <strong>LKR 15000.00</strong></p>
      <p>No of Transactions: <strong>3</strong></p>
      <button class="invoice-btn">Print Invoice</button>
      
  </div>
</div>
</body>
</html>