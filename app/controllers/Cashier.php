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
    $totalOrders = $this->CashierModel->getTotalOrderCount();
    $totalRevenue = $this->CashierModel->calculateTotalRevenue();
    $bestSellers = $this->CashierModel->getBestSellingProducts();
    $salesAnalytics = $this->CashierModel->getSalesAnalytics();
    $recentOrders = $this->CashierModel->getRecentOrders();
    
    $data = [
        'totalOrders' => $totalOrders->total_orders,
        'totalRevenue' => $totalRevenue ?? 0.00,
        'bestSellers' => $bestSellers,
        'salesAnalytics' => $salesAnalytics,
        'recentOrders' => $recentOrders
    ];

    $this->view('Cashier/v_CashierDashboard', $data);
}

// Add this to your Cashier.php controller
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
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo json_encode(['success' => false, 'message' => 'Cart is empty']);
                return;
            }

            $cart = $_SESSION['cart'];
            $paymentMethod = $_POST['payment_method'];
            $subtotal = array_reduce($cart, function($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0);

            $discountAmount = isset($_SESSION['discount']) ? floatval($_SESSION['discount']) : 0;
            $total = $subtotal - $discountAmount;
            
            // Handle different payment methods
            if ($paymentMethod === 'cash') {
                $amountTendered = isset($_POST['amount_tendered']) ? floatval($_POST['amount_tendered']) : 0;
                $change = max(0, $amountTendered - $total);
            } else if ($paymentMethod === 'card') {
                $amountTendered = $total; // For card payments, amount tendered equals total
                $change = 0;
            }

            // Create order data
            $orderData = [
                'customer_id' => $_SESSION['user_id'] ?? 1,
                'total' => $total,
                'discount_amount' => $discountAmount,
                'payment_method' => $paymentMethod === 'cash' ? 'Cash' : 'Credit Card',
                'order_type' => 'Physical',
                'employee_id' => $_SESSION['employee_id'] ?? null,
                'branch_id' => $_SESSION['branch_id'] ?? null,
                'amount_tendered' => $amountTendered,
                'change_amount' => $change
            ];

            $orderId = $this->CashierModel->createOrder($orderData);

            if (!$orderId) {
                echo json_encode(['success' => false, 'message' => 'Failed to create order']);
                return;
            }

            // Save order details
            foreach ($cart as $item) {
                $this->CashierModel->addOrderDetail([
                    'order_id' => $orderId,
                    'product_id' => $item['productId'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
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
                'date' => date('Y-m-d H:i:s')
            ];

            // Clear cart after successful order
            unset($_SESSION['cart']);
            unset($_SESSION['discount']);

            echo json_encode(['success' => true]);
        }
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

}