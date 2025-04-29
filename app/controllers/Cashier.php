<?php 
class Cashier extends Controller {
  
    public function __construct() {
        $this->CashierModel = $this->model('M_Cashier');
    }
    public function payment() {
      $this->view('Cashier/v_Payment');
  }
  public function transaction(){
        error_log('Session data: ' . print_r($_SESSION, true));
        
        if (!isset($_SESSION['employee_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'cashier') {
            $_SESSION['employee_id'] = 1;
            error_log('Set default employee_id: ' . $_SESSION['employee_id']);
        }
        
        $transactions = $this->CashierModel->getDailyTransactions();
        $summary = $this->CashierModel->getDailySummary();
        
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
        $products = $this->CashierModel->getProducts();
        $this->view('Cashier/v_Servicedesk', ['products' => $products]);
    } catch (Exception $e) {
        $this->view('Cashier/v_Servicedesk', ['products' => []]);
    }
  }

public function cashierdashboard(){
    if (isset($_SESSION['user_id'])) {
        $cashierInfo = $this->CashierModel->getCashierByUserId($_SESSION['user_id']);
        if ($cashierInfo) {
            $_SESSION['employee_id'] = $cashierInfo->employee_id ?? null;
            $_SESSION['branch_id'] = $cashierInfo->branch_id ?? null;
            
            error_log("Set session variables - employee_id: " . $_SESSION['employee_id'] . 
                      ", branch_id: " . $_SESSION['branch_id']);
        }
    }
    
    $totalOrders = $this->CashierModel->getTotalOrderCount();
    $todayOrders = $this->CashierModel->getTodayOrderCount();
    $totalRevenue = $this->CashierModel->calculateTotalRevenue();
    $todaysRevenue = $this->CashierModel->calculateTodaysRevenue();
    $avgOrderValue = $this->CashierModel->calculateAverageOrderValue();
    $bestSellers = $this->CashierModel->getBestSellingProducts();
    $salesAnalytics = $this->CashierModel->getSalesAnalytics();
    $recentOrders = $this->CashierModel->getRecentOrders();
    
    $data = [
        'totalOrders' => $totalOrders->total_orders,
        'todayOrders' => $todayOrders->today_orders,
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
            if (ob_get_level()) ob_clean();
            
            error_log("Session data during payment: " . print_r($_SESSION, true));
            
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo json_encode(['success' => false, 'message' => 'Cart is empty']);
                return;
            }

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

            $branch_id = $_SESSION['branch_id'] ?? 1;
            
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

            $orderData = [
                'customer_id' => 1,
                'total' => $total,
                'discount_amount' => $discountAmount,
                'payment_method' => $paymentMethod === 'cash' ? 'Cash' : 'Credit Card',
                'order_type' => 'Physical',
                'employee_id' => $_SESSION['employee_id'] ?? 6,
                'branch_id' => $branch_id,
                'amount_tendered' => $amountTendered,
                'change_amount' => $change
            ];

            error_log("Creating order with actual employee_id: " . $_SESSION['employee_id'] . 
                     ", branch_id: " . $_SESSION['branch_id']);

            try {
                $orderId = $this->CashierModel->createOrder($orderData);

                if (!$orderId) {
                    echo json_encode(['success' => false, 'message' => 'Failed to create order. Please try again.']);
                    return;
                }

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
        exit;
    }

    public function generateBill() {
        if (!isset($_SESSION['last_order'])) {
            redirect('Cashier/servicedesk');
            return;
        }

        $orderData = $_SESSION['last_order'];
        
        error_log('Bill Data: ' . print_r($orderData, true));
        
        $this->view('Cashier/v_Bill', $orderData);
        
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
            if (ob_get_level()) ob_clean();
            
            $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
            
            if ($amount <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid amount']);
                return;
            }
            
            require_once APPROOT . '/libraries/PayPalAPI.php';
            $paypal = new PayPalAPI();
            
            $returnUrl = URLROOT . '/Cashier/checkout?paypal_success=true';
            $cancelUrl = URLROOT . '/Cashier/checkout?paypal_cancel=true';
            
            $response = $paypal->createOrder(
                $amount,
                'USD',
                $returnUrl,
                $cancelUrl
            );
            
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    public function completePayPalPayment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (ob_get_level()) ob_clean();
            
            if (!isset($_POST['paypal_order_id'])) {
                echo json_encode(['success' => false, 'message' => 'PayPal order ID is missing']);
                return;
            }
            
            $paypalOrderId = $_POST['paypal_order_id'];
            
            require_once APPROOT . '/libraries/PayPalAPI.php';
            $paypal = new PayPalAPI();
            
            $captureResponse = $paypal->capturePayment($paypalOrderId);
            
            if (!$captureResponse['success']) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Failed to capture PayPal payment: ' . $captureResponse['message']
                ]);
                return;
            }
            
            $total = isset($_POST['amount_tendered']) ? floatval($_POST['amount_tendered']) : 0;
            $discountAmount = isset($_SESSION['discount']) ? floatval($_SESSION['discount']) : 0;
            
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo json_encode(['success' => false, 'message' => 'Cart is empty']);
                return;
            }
            
            if (!isset($_SESSION['employee_id']) || !isset($_SESSION['branch_id'])) {
                echo json_encode(['success' => false, 'message' => 'Session expired. Please login again.']);
                return;
            }
            
            $branch_id = $_SESSION['branch_id'] ?? 1;
            
            $orderData = [
                'customer_id' => 1,
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
                $orderId = $this->CashierModel->createOrder($orderData);
                
                if (!$orderId) {
                    echo json_encode(['success' => false, 'message' => 'Failed to create order. Please try again.']);
                    return;
                }
                
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