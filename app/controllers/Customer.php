<?php
class Customer extends Controller {
    private $customerModel;
    private $chatModel;

    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->customerModel = $this->model('M_Customer');
        $this->chatModel = $this->model('M_Chat');
        
        // Debug which method is being called
        error_log('Customer controller method called: ' . $_SERVER['REQUEST_URI']);
    }

    public function index() {
        try {
            // Get posted feedbacks
            $postedFeedbacks = $this->customerModel->getPostedFeedbacks();
            error_log("Found " . count($postedFeedbacks) . " feedbacks in index method");
            
            // Get other data
            $products = $this->customerModel->getLatestProducts(6);
            $categories = $this->customerModel->getAllCategories();
            $promotions = $this->customerModel->getActivePromotions();
            
            $data = [
                'title' => 'Welcome to Frostine Bakery',
                'products' => $products,
                'categories' => $categories,
                'promotions' => $promotions,
                'postedFeedbacks' => $postedFeedbacks
            ];
            
            // Ensure correct case in view path
            $this->view('Customer/CustomerHomepage', $data);
        } catch (Exception $e) {
            error_log("Error in index: " . $e->getMessage());
        }
    }

    public function customerhomepage() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['customer_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        try {
            // Get customer data and latest products
            $customerData = $this->customerModel->getActiveCustomerByUserId($_SESSION['user_id']);
            $products = $this->customerModel->getLatestProducts(6); // Changed variable name for consistency
            $categories = $this->customerModel->getAllCategories();
            $promotions = $this->customerModel->getActivePromotions();
            $postedFeedbacks = $this->customerModel->getPostedFeedbacks();

            error_log('Customer Data: ' . print_r($customerData, true));
            error_log('Products Data: ' . print_r($products, true));
            
            if (!$customerData) {
                session_destroy();
                header('Location: ' . URLROOT . '/users/login');
                exit();
            }

            $data = [
                'title' => 'Frostine Bakery - Home',
                'customer' => $customerData,
                'products' => $products, // Changed key name to match view
                'promotions' => $promotions,
                'categories' => $categories,
                'postedFeedbacks' => $postedFeedbacks
            ];
            
            // Debug the data array
            error_log('View Data: ' . print_r($data, true));
            
            $this->view('Customer/CustomerHomepage', $data);
        } catch (Exception $e) {
            error_log('Error in customerhomepage: ' . $e->getMessage());
            header('Location: ' . URLROOT . '/error');
            exit();
        }
    }

    public function customerproducts() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['customer_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        try {
            // Get filter parameters
            $category = isset($_GET['category']) ? $_GET['category'] : null;
            $minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : null;
            $maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : null;

            // Get filtered products and categories
            if ($category) {
                // Get products by category name instead of ID
                $products = $this->customerModel->getProductsByCategory($category);
            } else {
                $products = $this->customerModel->getFilteredProducts($category, $minPrice, $maxPrice);
            }
            
            $categories = $this->customerModel->getAllCategories();

            // Debug logging
            error_log("Filter params - Category: $category, Min: $minPrice, Max: $maxPrice");
            error_log("Found " . count($products) . " products after filtering");

            $data = [
                'title' => 'Our Products',
                'products' => $products,
                'categories' => $categories,
                'selectedCategory' => $category,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice
            ];

            $this->view('customer/customerproducts', $data);
        } catch (Exception $e) {
            error_log("Error in customerproducts: " . $e->getMessage());
            header('Location: ' . URLROOT . '/error');
            exit();
        }
    }

    public function submitEnquiry() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customer/customerhomepage');
            return;
        }

        $data = [
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'email_address' => trim($_POST['email_address']),
            'phone_number' => trim($_POST['phone_number']),
            'message' => trim($_POST['message'])
        ];

        // Debug log to check data
        error_log('Enquiry data: ' . print_r($data, true));

        if ($this->customerModel->submitEnquiry($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false]);
            return;
        }

        try {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $productId = $_POST['product_id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $image = $_POST['image'];

            // If product exists in cart, increment quantity
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity']++;
            } else {
                // Add new product to cart with product_id included
                $_SESSION['cart'][$productId] = [
                    'product_id' => $productId, // Add this line
                    'name' => $name,
                    'price' => $price,
                    'quantity' => 1,
                    'image' => $image
                ];
            }

            $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
            
            echo json_encode([
                'success' => true,
                'cartCount' => $cartCount,
                'message' => 'Product added to cart'
            ]);
        } catch (Exception $e) {
            error_log("Error adding to cart: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error adding product to cart'
            ]);
        }
    }

    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false]);
            return;
        }

        $data = json_decode(file_get_contents('php://input'));
        $productId = $data->product_id;
        $action = $data->action;

        if (isset($_SESSION['cart'][$productId])) {
            if ($action === 'increase') {
                $_SESSION['cart'][$productId]['quantity']++;
            } else if ($action === 'decrease') {
                $_SESSION['cart'][$productId]['quantity']--;
                if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
                    unset($_SESSION['cart'][$productId]);
                }
            }
        }

        echo json_encode(['success' => true]);
    }

    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false]);
            return;
        }

        $data = json_decode(file_get_contents('php://input'));
        $productId = $data->product_id;

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        echo json_encode(['success' => true]);
    }

    public function customercart() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['customer_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        try {
            // Get cart items from session
            $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
            
            // Get active promotions
            $promotions = $this->customerModel->getActivePromotions();
            
            // Calculate subtotal
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            // Calculate applicable discount
            $discount = 0;
            $appliedPromotion = null;
            foreach ($promotions as $promotion) {
                if ($subtotal >= 5000 && $promotion->discount_percentage == 20) {
                    $discount = $subtotal * ($promotion->discount_percentage / 100);
                    $appliedPromotion = $promotion;
                    break;
                } elseif ($subtotal >= 2500 && $promotion->discount_percentage == 5) {
                    $discount = $subtotal * ($promotion->discount_percentage / 100);
                    $appliedPromotion = $promotion;
                    break;
                }
            }

            // Calculate final total
            $total = $subtotal - $discount;

            $data = [
                'title' => 'Shopping Cart',
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'appliedPromotion' => $appliedPromotion
            ];

            $this->view('customer/customercart', $data);
        } catch (Exception $e) {
            error_log("Error in customercart: " . $e->getMessage());
            header('Location: ' . URLROOT . '/error');
            exit();
        }
    }

    public function updateCartQuantity() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customer/customercart');
            return;
        }

        $productId = $_POST['product_id'];
        $action = $_POST['action'];

        if (isset($_SESSION['cart'][$productId])) {
            switch ($action) {
                case 'increase':
                    $_SESSION['cart'][$productId]['quantity']++;
                    break;
                case 'decrease':
                    if ($_SESSION['cart'][$productId]['quantity'] > 1) {

                        $_SESSION['cart'][$productId]--;
                    }
                    break;
                case 'remove':
                    unset($_SESSION['cart'][$productId]);
                    break;
            }
        }

        // Redirect back to cart
        redirect('customer/customercart');
    }

    public function clearCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            unset($_SESSION['cart']);
        }
        redirect('customer/customercart');
    }

    public function customercheckout() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['customer_id'])) {
            redirect('users/login');
            return;
        }

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Store checkout data in session
                $_SESSION['checkout_data'] = [
                    'subtotal' => $_POST['subtotal'],
                    'discount' => $_POST['discount'],
                    'total' => $_POST['total'],
                    'cart_items' => json_decode($_POST['cart_items'], true),
                    'promotion_title' => $_POST['promotion_title'] ?? '',
                    'promotion_discount' => $_POST['promotion_discount'] ?? 0
                ];
            }

            if (!isset($_SESSION['checkout_data'])) {
                redirect('customer/customercart');
                return;
            }

            // Get branches for pickup locations
            $branches = $this->customerModel->getAllBranches();
            
            if ($branches === false) {
                throw new Exception("Unable to fetch branch data");
            }

            $data = [
                'title' => 'Checkout',
                'cartItems' => $_SESSION['checkout_data']['cart_items'],
                'subtotal' => $_SESSION['checkout_data']['subtotal'],
                'discount' => $_SESSION['checkout_data']['discount'],
                'total' => $_SESSION['checkout_data']['total'],
                'promotion_title' => $_SESSION['checkout_data']['promotion_title'],
                'promotion_discount' => $_SESSION['checkout_data']['promotion_discount'],
                'branches' => $branches
            ];

            $this->view('customer/customercheckout', $data);
        } catch (Exception $e) {
            error_log("Error in checkout: " . $e->getMessage());
            flash('payment_error', 'An error occurred. Please try again.');
            redirect('customer/customercart');
        }
    }

    public function processCheckout() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['customer_id'])) {
            redirect('users/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customer/customercart');
            return;
        }

        try {
            // Store checkout data in session
            $_SESSION['checkout_data'] = [
                'subtotal' => $_POST['subtotal'],
                'discount' => $_POST['discount'],
                'total' => $_POST['total'],
                'cart_items' => json_decode($_POST['cart_items'], true),
                'promotion_title' => $_POST['promotion_title'] ?? '',
                'promotion_discount' => $_POST['promotion_discount'] ?? 0
            ];

            // Redirect to checkout page
            redirect('customer/customercheckout');
        } catch (Exception $e) {
            error_log("Error processing checkout: " . $e->getMessage());
            redirect('customer/customercart');
        }
    }

    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customer/customercheckout');
            return;
        }

        try {
            // Debug log
            error_log('Processing payment - POST data: ' . print_r($_POST, true));
            error_log('Cart data: ' . print_r($_SESSION['cart'], true));

            // Validate required fields
            $requiredFields = ['delivery_type', 'contact_number', 'total'];
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    throw new Exception("Missing required field: {$field}");
                }
            }

            $cartItems = json_decode($_POST['cart_items'], true);
            
            // Add product_id to cart items if missing
            foreach ($cartItems as $key => $item) {
                if (!isset($item['product_id'])) {
                    $cartItems[$key]['product_id'] = $key; // Set product_id from array key
                }
            }

            // Calculate delivery charge based on delivery type
            $deliveryCharge = ($_POST['delivery_type'] === 'delivery') ? 500.00 : 0.00;
            $subtotal = floatval($_POST['subtotal']); // Use subtotal not total here
            $discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;
            $orderTotal = $subtotal + $deliveryCharge - $discount;

            // Begin transaction
            $this->customerModel->beginTransaction();

            // Prepare order data with updated cart items
            $orderData = [
                'customer_id' => $_SESSION['customer_id'],
                'cart_items' => $cartItems,
                'subtotal' => $subtotal,
                'total' => $orderTotal,
                'discount' => $discount,
                'delivery_type' => $_POST['delivery_type'],
                'contact_number' => $_POST['contact_number'],
                'delivery_address' => $_POST['delivery_type'] === 'delivery' ? $_POST['delivery_address'] : null,
                'district' => $_POST['delivery_type'] === 'delivery' ? $_POST['delivery_district'] : null,
                'branch_id' => $_POST['delivery_type'] === 'pickup' ? $_POST['branch'] : null,
                'payment_method' => 'Credit Card',
                'payment_status' => 'Paid',
                'delivery_charge' => $deliveryCharge
            ];

            // Create the complete order
            $orderId = $this->customerModel->createCompleteOrder($orderData);

            if (!$orderId) {
                throw new Exception('Failed to create order');
            }

            // If successful, commit transaction and clear cart
            $this->customerModel->commit();
            unset($_SESSION['cart']);
            unset($_SESSION['checkout_data']);

            // Store order ID for feedback page
            $_SESSION['last_order_id'] = $orderId;

            // Redirect to feedback page
            redirect('customer/customerfeedback');

        } catch (Exception $e) {
            $this->customerModel->rollBack();
            error_log("Error processing payment: " . $e->getMessage());
            flash('payment_error', 'An error occurred while processing your payment. Please try again.');
            redirect('customer/customercheckout');
        }
    }

    public function customerfeedback() {
        // Debug log
        error_log('Entering customerfeedback method');
        error_log('SESSION data: ' . print_r($_SESSION, true));

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['last_order_id'])) {
            error_log('Missing required session data');
            redirect('customer/customercart');
            return;
        }

        try {
            $orderId = $_SESSION['last_order_id'];
            error_log('Fetching order details for ID: ' . $orderId);
            
            $orderDetails = $this->customerModel->getOrderDetails($orderId);

            if (!$orderDetails) {
                throw new Exception("Order details not found");
            }

            $data = [
                'title' => 'Order Confirmation',
                'orderDetails' => $orderDetails
            ];

            // Clear session data after successful retrieval
            unset($_SESSION['last_order_id']);
            unset($_SESSION['order_success']);

            $this->view('customer/customerfeedback', $data);
        } catch (Exception $e) {
            error_log("Error in customerfeedback: " . $e->getMessage());
            redirect('customer/customercart');
        }
    }

    public function submitFeedback() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        try {
            // Debug log incoming data
            error_log("Feedback submission data: " . print_r($_POST, true));

            // Validate required fields
            if (empty($_POST['feedback_text']) || empty($_POST['order_id']) || empty($_POST['customer_id'])) {
                throw new Exception('Missing required fields');
            }

            // Validate order_id and customer_id are numeric
            if (!is_numeric($_POST['order_id']) || !is_numeric($_POST['customer_id'])) {
                throw new Exception('Invalid order or customer ID');
            }

            $feedbackData = [
                'order_id' => (int)$_POST['order_id'],
                'customer_id' => (int)$_POST['customer_id'],
                'feedback_text' => trim($_POST['feedback_text'])
            ];

            // Save feedback using the model
            $result = $this->customerModel->saveFeedback($feedbackData);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Thank you for your feedback!']);
            } else {
                throw new Exception('Failed to save feedback');
            }
        } catch (Exception $e) {
            error_log("Error submitting feedback: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function customercustomisation() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['customer_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        try {
            // Get all active branches for the pickup option
            $branches = $this->customerModel->getAllBranches();
            
            $data = [
                'title' => 'Cake Customization',
                'branches' => $branches
            ];

            $this->view('customer/customercustomisation', $data);
        } catch (Exception $e) {
            error_log("Error in customercustomisation: " . $e->getMessage());
            header('Location: ' . URLROOT . '/error');
            exit();
        }
    }

    public function submitCustomization() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customer/customercustomisation');
            return;
        }

        try {
            // Process form data
            $toppings = isset($_POST['toppings']) ? implode(', ', $_POST['toppings']) : null;
            $premium_toppings = isset($_POST['premium_toppings']) ? implode(', ', $_POST['premium_toppings']) : null;
            
            error_log("Processing customization with data: " . print_r($_POST, true));

            $data = [
                'customer_id' => $_SESSION['customer_id'],
                'flavor' => trim($_POST['flavor']),
                'size' => trim($_POST['size']),
                'toppings' => $toppings,
                'premium_toppings' => $premium_toppings,
                'message' => trim($_POST['message']),
                'delivery_option' => trim($_POST['delivery_option']),
                'delivery_address' => $_POST['delivery_option'] === 'delivery' ? trim($_POST['delivery_address']) : null,
                'delivery_date' => trim($_POST['delivery_date']),
                'total_price' => trim($_POST['total_price']),
                'branch_id' => $_POST['delivery_option'] === 'pickup' ? trim($_POST['branch_id']) : null,
                'order_status' => 'Pending'
            ];

            // Validate required fields
            if (empty($data['flavor']) || empty($data['size']) || empty($data['delivery_option'])) {
                flash('customization_error', 'Please fill in all required fields');
                redirect('customer/customercustomisation');
                return;
            }

            if ($this->customerModel->createCakeCustomization($data)) {
                flash('customization_success', 'Your cake customization order has been submitted successfully!');
            } else {
                flash('customization_error', 'Sorry, there was a problem submitting your order. Please try again.');
            }

            redirect('customer/customercustomisation');

        } catch (Exception $e) {
            error_log("Error in submitCustomization: " . $e->getMessage());
            flash('customization_error', 'An error occurred. Please try again.');
            redirect('customer/customercustomisation');
        }
    }

    public function customerprofile() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['customer_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        try {
            // Get customer data
            $customerData = $this->customerModel->getCustomerById($_SESSION['customer_id']);
            
            // Get recent 5 orders
            $orderHistory = $this->customerModel->getRecentOrders($_SESSION['customer_id'], 5);

            $data = [
                'title' => 'Customer Profile',
                'customerData' => $customerData,
                'orderHistory' => $orderHistory
            ];

            $this->view('customer/customerprofile', $data);
        } catch (Exception $e) {
            error_log("Error in customerprofile: " . $e->getMessage());
            header('Location: ' . URLROOT . '/error');
            exit();
        }
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customer/customerprofile');
            return;
        }

        try {
            $data = [
                'customer_id' => $_SESSION['customer_id'],
                'name' => trim($_POST['name']),
                'contact' => trim($_POST['contact']),
                'address' => trim($_POST['address'])
            ];

            // Add validation here if needed
            if (empty($data['name']) || empty($data['contact']) || empty($data['address'])) {
                flash('profile_error', 'Please fill in all fields');
                redirect('customer/customerprofile');
                return;
            }

            if ($this->customerModel->updateCustomer($data)) {
                flash('profile_success', 'Profile updated successfully');
            } else {
                flash('profile_error', 'Error updating profile');
            }

            redirect('customer/customerprofile');
        } catch (Exception $e) {
            error_log("Error updating profile: " . $e->getMessage());
            flash('profile_error', 'Error updating profile');
            redirect('customer/customerprofile');
        }
    }

    public function debugFeedback() {
        // For debugging purposes only
        $postedFeedbacks = $this->customerModel->getPostedFeedbacks();
        echo '<pre>';
        print_r($postedFeedbacks);
        echo '</pre>';
        
        echo '<h3>Database Check:</h3>';
        $this->customerModel->checkFeedbackTable();
        exit;
    }

    public function testFeedbacks() {
        $postedFeedbacks = $this->customerModel->getPostedFeedbacks();
        echo "<h2>Posted Feedbacks Test</h2>";
        echo "<pre>";
        print_r($postedFeedbacks);
        echo "</pre>";
        
        echo "<h3>Rendering homepage with these feedbacks:</h3>";
        $data = ['postedFeedbacks' => $postedFeedbacks];
        $this->view('Customer/CustomerHomepage', $data);
        exit;
    }
}
?>