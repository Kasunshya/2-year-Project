<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service desk</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/Cashiercss/servicedesk.css">
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
        </div>
        <div class="logout">
            <a href="#" class="btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    
    </aside>

    <header>
      <div class="header-container">
        <h7>Service Desk</h7> 
        </div>
      </div>
    </header>
    <div class="search-container">
      <input type="text" placeholder="Search..." class="search-input">
      <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
    <!-- Main Content -->
<div class="main-content">
    <!-- Product Grid -->
    <h1 class="product-header">Bread</h1>
            <div class="product-grid">
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d1.jpg" alt="Hazelnut Cake">
                    <h3>Hazelnut Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>

                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d2.jpeg" alt="Rose Pink Cake">
                    <h3>Rose Pink Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d3.jpeg" alt="Ice Cream Cake">
                    <h3>Ice Cream Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d4.jpeg" alt="Rainbow Cake">
                    <h3>Rainbow Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d5.jpeg"alt="Red Velvet Cake">
                    <h3>Red Velvet Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d6.jpeg" alt="Chocolate Cake">
                    <h3>Chocolate Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
            </div><br>
            <div>
            <h1 class="product-header">Cake</h1>
                <!-- Product Grid -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d1.jpg" alt="Hazelnut Cake">
                    <h3>Hazelnut Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d2.jpeg" alt="Rose Pink Cake">
                    <h3>Rose Pink Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d3.jpeg" alt="Ice Cream Cake">
                    <h3>Ice Cream Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d4.jpeg" alt="Rainbow Cake">
                    <h3>Rainbow Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d5.jpeg" alt="Red Velvet Cake">
                    <h3>Red Velvet Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d6.jpeg" alt="Chocolate Cake">
                    <h3>Chocolate Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <h1 class="product-header">Waffels</h1>
                <!-- Product Grid -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d1.jpg" alt="Hazelnut Cake">
                    <h3>Hazelnut Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d2.jpeg" alt="Rose Pink Cake">
                    <h3>Rose Pink Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d3.jpeg" alt="Ice Cream Cake">
                    <h3>Ice Cream Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d4.jpeg" alt="Rainbow Cake">
                    <h3>Rainbow Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d5.jpeg" alt="Red Velvet Cake">
                    <h3>Red Velvet Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d6.jpeg" alt="Chocolate Cake">
                    <h3>Chocolate Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <h1 class="product-header">Pancake</h1>
                <!-- Product Grid -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d1.jpg" alt="Hazelnut Cake">
                    <h3>Hazelnut Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                    
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d2.jpeg" alt="Rose Pink Cake">
                    <h3>Rose Pink Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d3.jpeg" alt="Ice Cream Cake">
                    <h3>Ice Cream Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d4.jpeg" alt="Rainbow Cake">
                    <h3>Rainbow Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d5.jpeg" alt="Red Velvet Cake">
                    <h3>Red Velvet Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="product-card">
                    <img src="<?php echo URLROOT;?>/img/CashierImg/d6.jpeg" alt="Chocolate Cake">
                    <h3>Chocolate Cake</h3>
                    <p>LKR 9550.00</p>
                    <button class="minus-btn"><i class="fas fa-minus"></i></button>
                    <button>Add</button>
                    <button class="plus-btn"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
