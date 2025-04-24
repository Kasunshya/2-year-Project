<?php 
class Cashier extends Controller {
  
    public function __construct() {
        $this->CashierModel = $this->model('M_Cashier');
    }
    public function payment() {
      $this->view('Cashier/v_Payment');
  }
  public function transaction(){
        // Debug logs
        error_log('Session data: ' . print_r($_SESSION, true));
        
        // Set default employee_id if not set
        if (!isset($_SESSION['employee_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'cashier') {
            $_SESSION['employee_id'] = 1; // Default value for testing
            error_log('Set default employee_id: ' . $_SESSION['employee_id']);
        }
        
        $transactions = $this->CashierModel->getDailyTransactions();
        $summary = $this->CashierModel->getDailySummary();
        
        // Debug logs
        error_log('Transactions: ' . print_r($transactions, true));
        error_log('Summary: ' . print_r($summary, true));
        
        $data = [
            'transactions' => $transactions,
            'summary' => $summary
        ];
        
        $this->view('Cashier/v_Transaction', $data);
    }
  public function reports(){
    $this->view('Cashier/v_reports');
  }
  public function servicedesk(){
    try {
        $products = $this->CashierModel->getProducts(); // Fetch products from the model
        $this->view('Cashier/v_Servicedesk', ['products' => $products]);
    } catch (Exception $e) {
        // Silently handle errors
        $this->view('Cashier/v_Servicedesk', ['products' => []]);
    }
  }

public function cashierdashboard(){
    // Get cashier information if available
    if (isset($_SESSION['user_id'])) {
        $cashierInfo = $this->CashierModel->getCashierByUserId($_SESSION['user_id']);
        if ($cashierInfo) {
            // Set session variables for later use
            $_SESSION['employee_id'] = $cashierInfo->employee_id ?? null;
            $_SESSION['branch_id'] = $cashierInfo->branch_id ?? null;
            
            // Log the session setup
            error_log("Set session variables - employee_id: " . $_SESSION['employee_id'] . 
                      ", branch_id: " . $_SESSION['branch_id']);
        }
    }
    
    // Get metrics specific to this cashier and branch
    $totalOrders = $this->CashierModel->getTotalOrderCount();
    $todayOrders = $this->CashierModel->getTodayOrderCount(); // Get today's order count
    $totalRevenue = $this->CashierModel->calculateTotalRevenue(); // Fixed: added $this
    $todaysRevenue = $this->CashierModel->calculateTodaysRevenue();
    $avgOrderValue = $this->CashierModel->calculateAverageOrderValue();
    $bestSellers = $this->CashierModel->getBestSellingProducts();
    $salesAnalytics = $this->CashierModel->getSalesAnalytics();
    $recentOrders = $this->CashierModel->getRecentOrders();
    
    $data = [
        'totalOrders' => $totalOrders->total_orders,
        'todayOrders' => $todayOrders->today_orders, // Add today's order count to data
        'totalRevenue' => $totalRevenue,
        'todaysRevenue' => $todaysRevenue,
        'averageOrderValue' => $avgOrderValue,
        'bestSellers' => $bestSellers,
        'salesAnalytics' => $salesAnalytics,
        'recentOrders' => $recentOrders
    ];

    $this->view('Cashier/v_CashierDashboard', $data);
}

public function search() {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
      $searchTerm = trim($_POST['search']);
      $products = $this->CashierModel->searchProducts($searchTerm);
      $this->view('Cashier/v_Servicedesk', ['products' => $products]);
  } else {
      $this->servicedesk();
  }
}

    public function searchProducts($term) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $searchTerm = trim($term);
            $products = $this->CashierModel->searchProducts($searchTerm);
            echo json_encode($products);
        }
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'));
            
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['productId'] === $input->productId) {
                    $item['quantity'] += $input->quantity;
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $_SESSION['cart'][] = [
                    'productId' => $input->productId,
                    'name' => $input->name,
                    'price' => $input->price,
                    'quantity' => $input->quantity
                ];
            }
            
            echo json_encode([
                'success' => true,
                'cartCount' => count($_SESSION['cart'])
            ]);
        }
    }

    public function updateCartQuantity() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'));
            
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['productId'] === $input->productId) {
                        $item['quantity'] = $input->quantity;
                        break;
                    }
                }
                
                // Calculate new total
                $total = array_reduce($_SESSION['cart'], function($sum, $item) {
                    return $sum + ($item['price'] * $item['quantity']);
                }, 0);
                
                echo json_encode([
                    'success' => true,
                    'newTotal' => $total
                ]);
                return;
            }
        }
        echo json_encode(['success' => false]);
    }

    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'));
            
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['productId'] === $input->productId) {
                        unset($_SESSION['cart'][$key]);
                        break;
                    }
                }
                
                $total = array_reduce($_SESSION['cart'], function($sum, $item) {
                    return $sum + ($item['price'] * $item['quantity']);
                }, 0);
                
                echo json_encode([
                    'success' => true,
                    'newTotal' => $total,
                    'cartEmpty' => empty($_SESSION['cart'])
                ]);
                return;
            }
        }
        echo json_encode(['success' => false]);
    }

    public function viewCart() {
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        $this->view('Cashier/v_Cart', [
            'cart' => $_SESSION['cart'] ?? [],
            'total' => $total
        ]);
    }

    public function checkout() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            redirect('Cashier/viewCart');
            return;
        }

        $subtotal = array_reduce($_SESSION['cart'], function($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;
        $total = $subtotal - $discount;

        $this->view('Cashier/v_Checkout', [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ]);
    }

    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Clear any potential output buffer to prevent HTML in response
            if (ob_get_level()) ob_clean();
            
            // Debug actual session data
            error_log("Session data during payment: " . print_r($_SESSION, true));
            
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo json_encode(['success' => false, 'message' => 'Cart is empty']);
                return;
            }

            // Check if employee_id is set - redirect to login if not
            if (!isset($_SESSION['employee_id']) || !isset($_SESSION['branch_id'])) {
                echo json_encode(['success' => false, 'message' => 'Session expired. Please login again.']);
                return;
            }

            $cart = $_SESSION['cart'];
            $paymentMethod = $_POST['payment_method'];
            $subtotal = array_reduce($cart, function($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0);

            $discountAmount = isset($_SESSION['discount']) ? floatval($_SESSION['discount']) : 0;
            $total = $subtotal - $discountAmount;
            
            $amountTendered = ($paymentMethod === 'cash') ? 
                floatval($_POST['amount_tendered']) : $total;
            $change = ($paymentMethod === 'cash') ? 
                max(0, $amountTendered - $total) : 0;

            // Get branch_id from cashier record if possible
            $branch_id = $_SESSION['branch_id'] ?? 1;
            
            // If cashier_id is available, ensure we use the correct branch_id
            if (isset($_SESSION['cashier_id'])) {
                try {
                    $this->db = new Database();
                    $this->db->query("SELECT branch_id FROM cashier WHERE cashier_id = :cashier_id");
                    $this->db->bind(':cashier_id', $_SESSION['cashier_id']);
                    $result = $this->db->single();
                    
                    if ($result && $result->branch_id) {
                        $branch_id = $result->branch_id;
                        error_log("Using branch_id " . $branch_id . " from cashier table for cashier_id " . $_SESSION['cashier_id']);
                    }
                } catch (Exception $e) {
                    error_log("Error fetching branch_id from cashier table: " . $e->getMessage());
                }
            }

            // Use actual session values with verified branch_id
            $orderData = [
                'customer_id' => 1, // This is still hardcoded as we're using a generic customer
                'total' => $total,
                'discount_amount' => $discountAmount,
                'payment_method' => $paymentMethod === 'cash' ? 'Cash' : 'Credit Card',
                'order_type' => 'Physical',
                'employee_id' => $_SESSION['employee_id'] ?? 6,
                'branch_id' => $branch_id,
                'amount_tendered' => $amountTendered,
                'change_amount' => $change
            ];

            // Log actual values being used
            error_log("Creating order with actual employee_id: " . $_SESSION['employee_id'] . 
                     ", branch_id: " . $_SESSION['branch_id']);

            try {
                $orderId = $this->CashierModel->createOrder($orderData);

                if (!$orderId) {
                    echo json_encode(['success' => false, 'message' => 'Failed to create order. Please try again.']);
                    return;
                }

                // Process order details and update stock
                $detailsSuccess = true;
                $stockUpdateSuccess = true;
                foreach ($cart as $item) {
                    $result = $this->CashierModel->addOrderDetail([
                        'order_id' => $orderId,
                        'product_id' => $item['productId'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ]);
                    
                    if (!$result) {
                        $detailsSuccess = false;
                        error_log("Failed to add order detail for product ID: " . $item['productId']);
                    }
                    
                    // Update branch stock after adding order detail
                    $stockResult = $this->CashierModel->updateBranchStock(
                        $branch_id, 
                        $item['productId'], 
                        $item['quantity']
                    );
                    
                    if (!$stockResult) {
                        $stockUpdateSuccess = false;
                        error_log("Failed to update stock for product ID: " . $item['productId']);
                    }
                }

                // Store complete order data in session
                $_SESSION['last_order'] = [
                    'order_id' => $orderId,
                    'items' => $cart,
                    'subtotal' => $subtotal,
                    'discount' => $discountAmount,
                    'total' => $total,
                    'payment_method' => $paymentMethod === 'cash' ? 'Cash' : 'Credit Card',
                    'amount_tendered' => $amountTendered,
                    'change' => $change,
                    'date' => date('Y-m-d H:i:s'),
                    'stock_updated' => $stockUpdateSuccess
                ];

                // Clear cart after successful order
                unset($_SESSION['cart']);
                unset($_SESSION['discount']);

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true, 
                    'detailsComplete' => $detailsSuccess,
                    'stockUpdated' => $stockUpdateSuccess,
                    'message' => 'Order created successfully' . 
                                (!$stockUpdateSuccess ? ' (Warning: Some inventory updates failed)' : '')
                ]);
            } catch (Exception $e) {
                error_log("Order processing error: " . $e->getMessage());
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error processing order: ' . $e->getMessage()]);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
        exit; // Prevent further output
    }

    public function generateBill() {
        // Check if we have order data in session
        if (!isset($_SESSION['last_order'])) {
            redirect('Cashier/servicedesk');
            return;
        }

        $orderData = $_SESSION['last_order'];
        
        // Debug log
        error_log('Bill Data: ' . print_r($orderData, true));
        
        $this->view('Cashier/v_Bill', $orderData);
        
        // Only clear session after successfully displaying bill
        unset($_SESSION['last_order']);
    }

    public function applyDiscount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'));
            $_SESSION['discount'] = floatval($input->discount);
            echo json_encode(['success' => true]);
        }
    }

    public function index() {
        redirect('Cashier/cashierdashboard');
    }

    public function orderSuccess() {
        // Create a complete order data structure for the success view
        $orderData = [
            'order_id' => 'N/A',
            'items' => [],
            'subtotal' => 0,
            'discount' => 0,
            'total' => 0,
            'payment_method' => 'N/A',
            'amount_tendered' => 0,
            'change' => 0,
            'success' => true,
            'message' => 'Payment processed successfully!'
        ];
        
        $this->view('Cashier/v_Bill', $orderData);
    }

    public function getCartCount() {
        header('Content-Type: application/json');
        $count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
        echo json_encode(['count' => $count]);
        exit;
    }

    public function initiatePayPalPayment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Clear output buffer
            if (ob_get_level()) ob_clean();
            
            // Get the amount from the form
            $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
            
            if ($amount <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid amount']);
                return;
            }
            
            // Load PayPal API library
            require_once APPROOT . '/libraries/PayPalAPI.php';
            $paypal = new PayPalAPI();
            
            // Set return URLs
            $returnUrl = URLROOT . '/Cashier/checkout?paypal_success=true';
            $cancelUrl = URLROOT . '/Cashier/checkout?paypal_cancel=true';
            
            // Create PayPal order
            $response = $paypal->createOrder(
                $amount,
                'USD',
                $returnUrl,
                $cancelUrl
            );
            
            // Return the response to the client
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    public function completePayPalPayment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Clear output buffer
            if (ob_get_level()) ob_clean();
            
            // Get PayPal order ID from the request
            if (!isset($_POST['paypal_order_id'])) {
                echo json_encode(['success' => false, 'message' => 'PayPal order ID is missing']);
                return;
            }
            
            $paypalOrderId = $_POST['paypal_order_id'];
            
            // Load PayPal API library
            require_once APPROOT . '/libraries/PayPalAPI.php';
            $paypal = new PayPalAPI();
            
            // Capture the payment
            $captureResponse = $paypal->capturePayment($paypalOrderId);
            
            if (!$captureResponse['success']) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Failed to capture PayPal payment: ' . $captureResponse['message']
                ]);
                return;
            }
            
            // If capture successful, create the order in our system
            $total = isset($_POST['amount_tendered']) ? floatval($_POST['amount_tendered']) : 0;
            $discountAmount = isset($_SESSION['discount']) ? floatval($_SESSION['discount']) : 0;
            
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo json_encode(['success' => false, 'message' => 'Cart is empty']);
                return;
            }
            
            // Check session data
            if (!isset($_SESSION['employee_id']) || !isset($_SESSION['branch_id'])) {
                echo json_encode(['success' => false, 'message' => 'Session expired. Please login again.']);
                return;
            }
            
            $branch_id = $_SESSION['branch_id'] ?? 1;
            
            // Create order data
            $orderData = [
                'customer_id' => 1, // Default customer ID
                'total' => $total,
                'discount_amount' => $discountAmount,
                'payment_method' => 'PayPal',
                'order_type' => 'Online',
                'employee_id' => $_SESSION['employee_id'] ?? 6,
                'branch_id' => $branch_id,
                'amount_tendered' => $total,
                'change_amount' => 0,
                'transaction_id' => $captureResponse['transactionId']
            ];
            
            try {
                // Create the order in our database
                $orderId = $this->CashierModel->createOrder($orderData);
                
                if (!$orderId) {
                    echo json_encode(['success' => false, 'message' => 'Failed to create order. Please try again.']);
                    return;
                }
                
                // Process order details and update stock
                $detailsSuccess = true;
                $stockUpdateSuccess = true;
                foreach ($_SESSION['cart'] as $item) {
                    $result = $this->CashierModel->addOrderDetail([
                        'order_id' => $orderId,
                        'product_id' => $item['productId'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ]);
                    
                    if (!$result) {
                        $detailsSuccess = false;
                        error_log("Failed to add order detail for product ID: " . $item['productId']);
                    }
                    
                    // Update branch stock
                    $stockResult = $this->CashierModel->updateBranchStock(
                        $branch_id, 
                        $item['productId'], 
                        $item['quantity']
                    );
                    
                    if (!$stockResult) {
                        $stockUpdateSuccess = false;
                        error_log("Failed to update stock for product ID: " . $item['productId']);
                    }
                }
                
                // Store order data in session
                $_SESSION['last_order'] = [
                    'order_id' => $orderId,
                    'items' => $_SESSION['cart'],
                    'subtotal' => array_reduce($_SESSION['cart'], function($sum, $item) {
                        return $sum + ($item['price'] * $item['quantity']);
                    }, 0),
                    'discount' => $discountAmount,
                    'total' => $total,
                    'payment_method' => 'PayPal',
                    'paypal_transaction_id' => $captureResponse['transactionId'],
                    'amount_tendered' => $total,
                    'change' => 0,
                    'date' => date('Y-m-d H:i:s'),
                    'stock_updated' => $stockUpdateSuccess
                ];
                
                // Clear cart after successful order
                unset($_SESSION['cart']);
                unset($_SESSION['discount']);
                
                echo json_encode([
                    'success' => true,
                    'detailsComplete' => $detailsSuccess,
                    'stockUpdated' => $stockUpdateSuccess,
                    'message' => 'PayPal payment successful'
                ]);
            } catch (Exception $e) {
                error_log("PayPal order processing error: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Error processing order: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
        exit;
    }
}