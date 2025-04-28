<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fix the path to point to the vendor directory at the project root
require_once __DIR__ . '/../../vendor/autoload.php';

class HeadM extends Controller
{
    private $cashierModel;
    private $headManagerModel;
    private $employeeModel;
    private $branchModel;
    private $notificationModel;

    public function __construct()
    {
        if (!isLoggedIn() || $_SESSION['user_role'] !== 'headmanager') {
            redirect('users/login');
        }
        $this->cashierModel = $this->model('M_Cashier');
        $this->headManagerModel = $this->model('M_HeadM');
        $this->employeeModel = $this->model('M_Employee');
        $this->branchModel = $this->model('M_Branch');
        $this->notificationModel = $this->model('M_Notification');
    }

    public function supplierManagement()
    {
        $this->view('HeadM/SupplierManagement');
    }

    public function branchManager() {
        // Get the search query from the GET request
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $branchId = isset($_GET['branch_id']) ? $_GET['branch_id'] : '';

        // Fetch branch managers based on the search query

        $branchManagers = $this->headManagerModel->getAllBranchManagers( $search ,$branchId);
        $branches = $this->headManagerModel->getAllBranches();

        $data = [
            'branchManagers' => $branchManagers,
            'branches' => $branches
        ];

        $this->view('HeadM/BranchManagers', $data);
    }

    public function addBranchManager()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'branch_id' => trim($_POST['branch_id']),
                'branchmanager_name' => trim($_POST['branchmanager_name']),
                'address' => trim($_POST['address']),
                'email' => trim($_POST['email']),
                'contact_number' => trim($_POST['contact_number']),
                'password' => trim($_POST['password'])
            ];

            if ($this->headManagerModel->addBranchManager($data)) {
                echo "<script>alert('Branch Manager added successfully!');</script>";
                $this->redirect('HeadM/branchManager');
            } else {
                echo "<script>alert('Something went wrong!');</script>";
            }
        }
    }

    public function editBranchManager()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'branchmanager_id' => $_POST['branchmanager_id'],
                'user_id' => $_POST['user_id'],
                'branch_id' => $_POST['branch_id'],
                'branchmanager_name' => $_POST['branchmanager_name'],
                'address' => $_POST['address'],
                'email' => $_POST['email'],
                'contact_number' => $_POST['contact_number'],
                'password' => $_POST['password']
            ];

            if ($this->headManagerModel->updateBranchManager($data)) {
                $this->redirect('HeadM/branchManager');
            }
        }
        // If not POST request, redirect to branch manager page
        $this->redirect('HeadM/branchManager');
    }
    
    public function deleteBranchManager()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'branchmanager_id' => $_POST['branchmanager_id']
            ];
            if ($this->headManagerModel->deleteBranchManager($data)) {
                echo "<script>alert('Branch Manager deleted successfully!');</script>";
                $this->redirect('HeadM/branchManager');
            } else {
                echo "<script>alert('Something went wrong!');</script>";
            }
        }
    }

    private function redirect($url)
    {
        header('Location: ' . URLROOT . '/' . $url);
        exit();
    }

    public function dashboard()
    {
        // Base metrics
        $totalCashiers = $this->headManagerModel->getTotalCashiers();
        $totalCustomers = $this->headManagerModel->getTotalCustomers();
        $totalBranchManagers = $this->headManagerModel->getTotalBranchManagers();
        $totalProducts = $this->headManagerModel->getTotalProducts();
        $totalOrders = $this->headManagerModel->getTotalOrders();
        $totalRevenue = $this->headManagerModel->getTotalRevenue();
        
        // Sales analytics for chart
        $salesAnalytics = $this->headManagerModel->getSalesAnalytics();
        
        // Best selling products
        $bestSellers = $this->headManagerModel->getBestSellingProducts();
        
        // Recent orders
        $recentOrders = $this->headManagerModel->getRecentOrders();
        
        // Calendar data - orders by date
        $orderDates = $this->headManagerModel->getOrderDates();
        
        // Branch performance
        $branchPerformance = $this->headManagerModel->getBranchPerformance();
        
        // Add this new section to fetch latest feedback
        $latestFeedbacks = $this->headManagerModel->getLatestFeedbacks();
    
        $data = [
            'totalCashiers' => $totalCashiers,
            'totalCustomers' => $totalCustomers,
            'totalBranchManagers' => $totalBranchManagers,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'salesAnalytics' => $salesAnalytics,
            'bestSellers' => $bestSellers,
            'recentOrders' => $recentOrders,
            'orderDates' => $orderDates,
            'branchPerformance' => $branchPerformance,
            'latestFeedbacks' => $latestFeedbacks // Add this line
        ];
        
        $this->view('HeadM/Dashboard', $data);
    }

    public function inventoryManagement()
    {
        // Get search parameters from the GET request
        $productName = isset($_GET['product_name']) ? trim($_GET['product_name']) : '';
        $branchId = isset($_GET['branch_id']) ? trim($_GET['branch_id']) : '';

        // Fetch inventory data based on the search parameters
        $inventoryData = $this->headManagerModel->getInventoryData($productName, $branchId);

        // Fetch all branches for the branch dropdown
        $branches = $this->headManagerModel->getAllBranches();

        $data = [
            'inventoryData' => $inventoryData,
            'branches' => $branches,
            'product_name' => $productName,
            'branch_id' => $branchId
        ];

        $this->view('HeadM/InventoryManagement', $data);
    }

    public function cashierManagement()
    {
        // Get search parameters from the GET request
        $nameEmail = isset($_GET['name_email']) ? trim($_GET['name_email']) : '';
        $branchId = isset($_GET['branch_id']) ? trim($_GET['branch_id']) : '';

        // Fetch cashiers based on the search parameters
        $cashiers = $this->headManagerModel->getCashiers($nameEmail, $branchId);

        // Fetch all branches for the branch dropdown
        $branches = $this->headManagerModel->getAllBranches();

        $data = [
            'cashiers' => $cashiers,
            'branches' => $branches,
            'name_email' => $nameEmail,
            'branch_id' => $branchId
        ];

        $this->view('HeadM/CashierManagement', $data);
    }

    public function productManagement() {
        $productName = isset($_GET['product_name']) ? trim($_GET['product_name']) : '';
        $categoryId = isset($_GET['category_id']) ? trim($_GET['category_id']) : '';
        $minPrice = isset($_GET['min_price']) ? trim($_GET['min_price']) : '';
        $maxPrice = isset($_GET['max_price']) ? trim($_GET['max_price']) : '';

        $products = $this->headManagerModel->searchProducts($productName, $categoryId, $minPrice, $maxPrice);
        $categories = $this->headManagerModel->getAllCategories();

        $data = [
            'products' => $products,
            'categories' => $categories
        ];

        $this->view('HeadM/ProductManagement', $data);
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_name' => trim($_POST['product_name']),
                'price' => trim($_POST['price']),
                'description' => trim($_POST['description']),
                'category_id' => trim($_POST['category_id']),
                'available_quantity' => trim($_POST['available_quantity'])
            ];

            if ($this->headManagerModel->addProduct($data)) {
                flash('product_message', 'Product added successfully');
                redirect('HeadM/productManagement');
            } else {
                flash('product_message', 'Something went wrong', 'alert alert-danger');
                redirect('HeadM/productManagement');
            }
        } else {
            redirect('HeadM/productManagement');
        }
    }

    public function editProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_id' => trim($_POST['product_id']),
                'product_name' => trim($_POST['product_name']),
                'price' => trim($_POST['price']),
                'description' => trim($_POST['description']),
                'category_id' => trim($_POST['category_id']),
                'available_quantity' => trim($_POST['available_quantity'])
            ];

            if ($this->headManagerModel->editProduct($data)) {
                flash('product_message', 'Product updated successfully');
                redirect('HeadM/productManagement');
            } else {
                flash('product_message', 'Something went wrong', 'alert alert-danger');
                redirect('HeadM/productManagement');
            }
        } else {
            redirect('HeadM/productManagement');
        }
    }

    public function getProductById($productId) {
        $product = $this->headManagerModel->getProductById($productId);
        echo json_encode($product);
    }

    public function deleteProduct($productId) {
        if ($this->headManagerModel->deleteProductById($productId)) {
            flash('product_message', 'Product deleted successfully');
            redirect('HeadM/productManagement');
        } else {
            flash('product_message', 'Something went wrong', 'alert alert-danger');
            redirect('HeadM/productManagement');
        }
    }

    public function customization()
    {
        // Get the search term from the GET request
        $customerName = isset($_GET['customer_name']) ? trim($_GET['customer_name']) : '';

        // Fetch customizations based on the search term
        $customizations = $this->headManagerModel->getCustomizations($customerName);

        $data = [
            'customizations' => $customizations,
            'customer_name' => $customerName
        ];

        $this->view('HeadM/Customization', $data);
    }

    public function viewOrder()
    {
        // Get search and filter parameters from the GET request
        $filters = [
            'customer_name' => isset($_GET['customer_name']) ? trim($_GET['customer_name']) : '',
            'payment_method' => isset($_GET['payment_method']) ? trim($_GET['payment_method']) : '',
            'order_type' => isset($_GET['order_type']) ? trim($_GET['order_type']) : '',
            'branch_id' => isset($_GET['branch_id']) ? trim($_GET['branch_id']) : '',
            'date' => isset($_GET['date']) ? trim($_GET['date']) : '',
            'month' => isset($_GET['month']) ? trim($_GET['month']) : '',
            'year' => isset($_GET['year']) ? trim($_GET['year']) : ''
        ];

        // Fetch orders based on the filters
        $orders = $this->headManagerModel->getOrders($filters);

        // Fetch all branches for the branch dropdown
        $branches = $this->headManagerModel->getAllBranches();

        $data = [
            'orders' => $orders,
            'branches' => $branches,
            'filters' => $filters
        ];

        $this->view('HeadM/ViewOrder', $data);
    }

    public function preOrder()
    {
        // Get search term from GET request
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Get filtered results
        $data['preOrders'] = $this->headManagerModel->getPreOrders($search);
        
        // Load view with data
        $this->view('HeadM/PreOrder', $data);
    }

    public function dailyBranchOrder()
    {
        // Get the selected branch ID from the GET request
        $branchId = isset($_GET['branch_id']) ? trim($_GET['branch_id']) : '';

        // Fetch branch orders based on the selected branch
        $orders = $this->headManagerModel->getDailyBranchOrders($branchId);

        // Fetch all branches for the dropdown
        $branches = $this->headManagerModel->getAllBranches();

        $data = [
            'orders' => $orders,
            'branches' => $branches,
            'branch_id' => $branchId
        ];

        $this->view('HeadM/DailyBranchOrder', $data);
    }

    public function feedback()
    {
        $searchTerm = isset($_GET['order_id']) ? $_GET['order_id'] : '';
        $feedbacks = $this->headManagerModel->getFeedbacks($searchTerm);
        
        $data = [
            'title' => 'Feedback Management',
            'feedbacks' => $feedbacks
        ];
        
        $this->view('HeadM/Feedback', $data);
    }

    public function downloadCV($employee_id) {
        // Fetch employee details using the model
        $employee = $this->headManagerModel->getEmployeeById($employee_id);
    
        if ($employee && !empty($employee->cv_upload)) {
            $filePath = UPLOADROOT . '/' . $employee->cv_upload;
    
            if (file_exists($filePath)) {
                // Serve the file for download
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($employee->cv_upload) . '"');
                header('Content-Length: ' . filesize($filePath));
                readfile($filePath);
                exit;
            }
        }
    
        // Redirect back if the CV file doesn't exist or there's an error
        flash('cv_error', 'CV file not found', 'alert alert-danger');
        redirect('HeadM/branchManager');
    }

    public function branches() {
        // Fetch all branches
        $branches = $this->headManagerModel->getAllBranches();
    
        $data = [
            'branches' => $branches
        ];
    
        $this->view('HeadM/Branches', $data);
    }

    public function branch($branch_id) {
    // Fetch branch details
    $branch = $this->headManagerModel->getBranchById($branch_id);
    
    if (!$branch) {
        redirect('headm/branches');
        return;
    }

    // Fetch branch manager and cashiers
    $branchManager = $this->headManagerModel->getBranchManagerByBranchId($branch_id);
    $cashiers = $this->headManagerModel->getCashiersByBranchId($branch_id);

    // Initialize filters array and reportType
    $filters = [];
    $reportType = '';
    
    // Determine report type and set appropriate filters
    if (isset($_GET['date']) && !empty($_GET['date'])) {
        $filters['date'] = $_GET['date'];
        $reportType = 'daily';
    } elseif (isset($_GET['month']) && !empty($_GET['month']) && isset($_GET['year']) && !empty($_GET['year'])) {
        $filters['month'] = $_GET['month'];
        $filters['year'] = $_GET['year'];
        $reportType = 'monthly';
    } elseif (isset($_GET['year']) && !empty($_GET['year'])) {
        $filters['year'] = $_GET['year'];
        $reportType = 'yearly';
    }

    // Fetch sales data with filters
    $salesData = $this->headManagerModel->getSalesByBranch($branch_id, $filters);
    
    // Calculate total sales with the same filters
    $totalSalesObj = $this->headManagerModel->getTotalSalesByBranch($branch_id, $filters);
    $totalSales = 0;
    if ($totalSalesObj && isset($totalSalesObj->total_sales)) {
        $totalSales = $totalSalesObj->total_sales;
    }

    // Prepare report title for the PDF based on filter type
    $reportTitle = 'All Time Report';
    if ($reportType === 'daily' && isset($filters['date'])) {
        $reportTitle = 'Daily Report: ' . date('d F Y', strtotime($filters['date']));
    } elseif ($reportType === 'monthly' && isset($filters['month']) && isset($filters['year'])) {
        $reportTitle = 'Monthly Report: ' . date('F Y', mktime(0, 0, 0, $filters['month'], 1, $filters['year']));
    } elseif ($reportType === 'yearly' && isset($filters['year'])) {
        $reportTitle = 'Yearly Report: ' . $filters['year'];
    }

    $data = [
        'branch' => $branch,
        'branchManager' => $branchManager,
        'cashiers' => $cashiers,
        'salesData' => $salesData,
        'totalSales' => $totalSales,
        'filters' => $filters,
        'reportType' => $reportType,
        'reportTitle' => $reportTitle
    ];

    $this->view('HeadM/Branch', $data);
}

    public function sendEnquiryReply() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data
            $enquiry_id = $_POST['enquiry_id'];
            $reply_message = $_POST['reply_message'];
            
            // Get enquiry details from database
            $enquiry = $this->headManagerModel->getEnquiryById($enquiry_id);
            
            if (!$enquiry) {
                echo json_encode(['status' => 'error', 'message' => 'Enquiry not found']);
                return;
            }
            
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);
            
            try {
                // Server settings - using the same config as password reset
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '2022is042@stu.ucsc.cmb.ac.lk'; 
                $mail->Password = 'wgcj mhtk gbwc eviv'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                
                // Recipients
                $mail->setFrom('2022is042@stu.ucsc.cmb.ac.lk', 'Frostine Bakery');
                $mail->addAddress($enquiry->email_address); 
                
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Response to Your Bakery Enquiry';
                $mail->Body = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; }
                            .container { max-width: 600px; margin: 0 auto; }
                            .header { background-color: #f5f5f5; padding: 15px; text-align: center; }
                            .content { padding: 20px; }
                            .footer { font-size: 12px; text-align: center; margin-top: 30px; color: #777; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>Frostine Bakery</h2>
                            </div>
                            <div class='content'>
                                <p>Dear {$enquiry->first_name},</p>
                                <p>Thank you for your enquiry (#$enquiry_id). Below is our response:</p>
                                <p>" . nl2br(htmlspecialchars($reply_message)) . "</p>
                                <p>If you have any further questions, please don't hesitate to contact us.</p>
                            </div>
                            <div class='footer'>
                                <p>Best regards,<br>Frostine Bakery Management Team</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
                
                $mail->AltBody = "Dear {$enquiry->first_name},\n\nThank you for your enquiry (#$enquiry_id). Below is our response:\n\n$reply_message\n\nBest regards,\nFrostine Bakery Management Team";
                
                $mail->send();
                echo json_encode(['status' => 'success', 'message' => 'Reply sent successfully']);
                
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }

    public function updateCustomizationStatus() {
        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get JSON data from request body
            $data = json_decode(file_get_contents('php://input'));
            
            if (isset($data->customization_id) && isset($data->status)) {
                // Get the customization info (to get customer email)
                $customization = $this->headManagerModel->getCustomizationById($data->customization_id);
                
                if (!$customization) {
                    echo json_encode(['success' => false, 'message' => 'Customization order not found']);
                    return;
                }
                
                // Update status in database
                $result = $this->headManagerModel->updateCustomizationStatus($data->customization_id, $data->status);
                
                if ($result) {
                    // Send email based on status
                    $emailSent = $this->sendCustomizationStatusEmail($customization, $data->status);
                    
                    if ($emailSent) {
                        echo json_encode(['success' => true, 'message' => 'Status updated and email sent successfully']);
                    } else {
                        echo json_encode(['success' => true, 'message' => 'Status updated but email could not be sent']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update status']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid data received']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
    }

    private function sendCustomizationStatusEmail($customization, $status) {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        
        try {
            // Server settings - using the same config as in the sendEnquiryReply method
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '2022is042@stu.ucsc.cmb.ac.lk'; 
            $mail->Password = 'wgcj mhtk gbwc eviv'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            // Recipients
            $mail->setFrom('2022is042@stu.ucsc.cmb.ac.lk', 'Frostine Bakery');
            $mail->addAddress($customization->customer_email); 
            
            // Content
            $mail->isHTML(true);
            
            if ($status == 'approved') {
                $mail->Subject = 'Your Customization Order has been Approved';
                $mail->Body = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; }
                            .container { max-width: 600px; margin: 0 auto; }
                            .header { background-color: #f5f5f5; padding: 15px; text-align: center; }
                            .content { padding: 20px; }
                            .footer { font-size: 12px; text-align: center; margin-top: 30px; color: #777; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>Frostine Bakery</h2>
                            </div>
                            <div class='content'>
                                <p>Dear {$customization->customer_name},</p>
                                <p>We are pleased to inform you that your customization order has been approved.</p>
                                <p>Please contact us for more details regarding payment and delivery.</p>
                                <p>Thank you for choosing Frostine Bakery!</p>
                            </div>
                            <div class='footer'>
                                <p>Best regards,<br>Frostine Bakery Management Team</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
                $mail->AltBody = "Dear {$customization->customer_name},\n\nWe are pleased to inform you that your customization order has been approved. Please contact us for more details regarding payment and delivery.\n\nThank you for choosing Frostine Bakery!\n\nBest regards,\nFrostine Bakery Management Team";
            } else {
                $mail->Subject = 'Your Customization Order Status Update';
                $mail->Body = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; }
                            .container { max-width: 600px; margin: 0 auto; }
                            .header { background-color: #f5f5f5; padding: 15px; text-align: center; }
                            .content { padding: 20px; }
                            .footer { font-size: 12px; text-align: center; margin-top: 30px; color: #777; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>Frostine Bakery</h2>
                            </div>
                            <div class='content'>
                                <p>Dear {$customization->customer_name},</p>
                                <p>We regret to inform you that your customization order cannot be processed at this time.</p>
                                <p>We apologize for any inconvenience this may cause.</p>
                                <p>Please feel free to contact us if you would like to discuss alternatives.</p>
                            </div>
                            <div class='footer'>
                                <p>Best regards,<br>Frostine Bakery Management Team</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
                $mail->AltBody = "Dear {$customization->customer_name},\n\nWe regret to inform you that your customization order cannot be processed at this time. We apologize for any inconvenience this may cause.\n\nPlease feel free to contact us if you would like to discuss alternatives.\n\nBest regards,\nFrostine Bakery Management Team";
            }
            
            $mail->send();
            return true;
            
        } catch (Exception $e) {
            // Log the error
            error_log('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function postFeedback() {
        // Check if it's an AJAX request with POST method
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get JSON data from request body
            $data = json_decode(file_get_contents('php://input'));
            
            if (isset($data->feedback_id)) {
                // Call model method to update feedback status
                $result = $this->headManagerModel->postFeedbackToHomepage($data->feedback_id);
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Feedback posted successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to post feedback']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid data received']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
    }

    public function unpostFeedback() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $feedback_id = isset($_POST['feedback_id']) ? $_POST['feedback_id'] : null;
            
            if ($feedback_id) {
                if ($this->headManagerModel->unpostFeedback($feedback_id)) {
                    echo json_encode(['status' => 'success', 'message' => 'Feedback removed from homepage']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to remove feedback']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid feedback ID']);
            }
            exit;
        }
    }

    public function updateOrderStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        try {
            $orderId = $_POST['order_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if (!$orderId || !$status) {
                throw new Exception('Missing required parameters');
            }

            // Update the order status
            $success = $this->headManagerModel->updateDailyOrderStatus($orderId, $status);
            
            if ($success) {
                // Get the branch ID for notification
                $order = $this->headManagerModel->getDailyOrderById($orderId);
                if ($order) {
                    // Create notification
                    $this->notificationModel->createNotification($order->branch_id, $orderId, $status);
                }
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Order status updated successfully'
                ]);
            } else {
                throw new Exception('Failed to update order status');
            }
        } catch (Exception $e) {
            error_log("Error in updateOrderStatus: " . $e->getMessage());
            echo json_encode([
                'success' => false, 
                'message' => 'Error updating order status: ' . $e->getMessage()
            ]);
        }
    }

    public function orders() {
        // Get all pending orders
        $pendingOrders = $this->branchModel->getPendingOrders();
        $data = [
            'title' => 'Branch Orders',
            'orders' => $pendingOrders
        ];
        $this->view('HeadM/v_Orders', $data);
    }
}

?>
