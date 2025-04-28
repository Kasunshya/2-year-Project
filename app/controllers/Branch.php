<?php
class Branch extends Controller {
    private $branchModel;
    private $notificationModel;
    
    public function __construct() {
        $this->branchModel = $this->model('M_Branch');
        $this->notificationModel = $this->model('M_Notification');
        
        // Make sure user is logged in with correct role
        if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }
    }

    private function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_type']) 
               && $_SESSION['user_type'] === 'branch_manager';
    }

    public function stock() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found. Please contact administrator.');
        }

        $stocks = $this->branchModel->getBranchStock($branch->branch_id);

        $data = [
            'stocks' => $stocks ?? [],
            'branch' => $branch,
            'title' => 'Stock Management'
        ];
        
        $this->view('BranchM/v_stock', $data);
    }
    
    public function products() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found.');
        }

        $products = $this->branchModel->getAllProducts();
        $categories = $this->branchModel->getAllCategories();
        $branchStock = $this->branchModel->getBranchStock($branch->branch_id);

        $data = [
            'products' => $products,
            'categories' => $categories,
            'branchStock' => $branchStock,
            'branch' => $branch,
            'title' => 'Product Management'
        ];
        
        $this->view('BranchM/v_products', $data);
    }

    public function updateDailyStock() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('Branch/products');
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);

        $productId = $_POST['productId'] ?? null;
        $quantity = $_POST['quantity'] ?? 0;
        $expiryDate = $_POST['expiryDate'] ?? date('Y-m-d');

        if ($this->branchModel->updateDailyStock($branch->branch_id, $productId, $quantity, $expiryDate)) {
            flash('stock_message', 'Stock updated successfully');
        } else {
            flash('stock_message', 'Error updating stock', 'alert alert-danger');
        }
        
        redirect('Branch/products');
    }

    public function salesReport() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        $date = $_POST['date'] ?? date('Y-m-d');
        
        $transactions = $this->branchModel->getDailyTransactions($branch->branch_id, $date);
        $summary = $this->branchModel->getDailySalesSummary($branch->branch_id, $date);
        $topProducts = $this->branchModel->getTopSellingProducts($branch->branch_id, $date);

        $data = [
            'branch' => $branch,
            'date' => $date,
            'transactions' => $transactions,
            'summary' => $summary,
            'topProducts' => $topProducts,
            'title' => 'Daily Sales Report'
        ];
        
        $this->view('BranchM/v_salesReport', $data);
    }

    public function dateRangeReport() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        // Add input validation and default dates
        $startDate = isset($_POST['start_date']) && !empty($_POST['start_date']) 
            ? $_POST['start_date'] 
            : date('Y-m-d', strtotime('-7 days'));
        $endDate = isset($_POST['end_date']) && !empty($_POST['end_date']) 
            ? $_POST['end_date'] 
            : date('Y-m-d');

        // Validate date range
        if (strtotime($startDate) > strtotime($endDate)) {
            flash('report_error', 'Start date cannot be after end date', 'alert alert-danger');
            redirect('Branch/salesReport');
            return;
        }

        try {
            $transactions = $this->branchModel->getDateRangeTransactions($branch->branch_id, $startDate, $endDate);
            $summary = $this->branchModel->getDateRangeSummary($branch->branch_id, $startDate, $endDate);

            $data = [
                'branch' => $branch,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'transactions' => $transactions ?? [],
                'summary' => $summary ?? (object)['total_orders' => 0, 'total_sales' => 0],
                'title' => 'Date Range Sales Report'
            ];
            
            $this->view('BranchM/v_salesReport', $data);
        } catch (Exception $e) {
            error_log("Error in dateRangeReport: " . $e->getMessage());
            flash('report_error', 'Error generating report. Please try again.', 'alert alert-danger');
            redirect('Branch/salesReport');
        }
    }

    public function productPerformance() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        $startDate = isset($_POST['start_date']) && !empty($_POST['start_date']) 
            ? $_POST['start_date'] 
            : date('Y-m-d', strtotime('-30 days'));
        $endDate = isset($_POST['end_date']) && !empty($_POST['end_date']) 
            ? $_POST['end_date'] 
            : date('Y-m-d');

        try {
            $products = $this->branchModel->getProductPerformance($branch->branch_id, $startDate, $endDate);
            $categories = $this->branchModel->getCategoryPerformance($branch->branch_id, $startDate, $endDate);

            $data = [
                'branch' => $branch,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'products' => $products ?? [],
                'categories' => $categories ?? [],
                'title' => 'Product Performance Report'
            ];
            
            $this->view('BranchM/v_salesReport', $data);
        } catch (Exception $e) {
            error_log("Error in productPerformance: " . $e->getMessage());
            flash('report_error', 'Error generating product report', 'alert alert-danger');
            redirect('Branch/salesReport');
        }
    }

    public function stockReport() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        $stockAnalysis = $this->branchModel->getStockAnalysis($branch->branch_id);
        $stockMetrics = $this->branchModel->getStockMetrics($branch->branch_id);
        $nearingExpiry = $this->branchModel->getStockNearingExpiry($branch->branch_id);
        $lowStock = $this->branchModel->getLowStockProducts($branch->branch_id);
        
        // Safely get wastage logs, will return empty array if table doesn't exist
        $wastage = $this->branchModel->getWastageLogs($branch->branch_id);
        
        $categorizedStocks = [];
        if ($stockAnalysis) {
            foreach ($stockAnalysis as $stock) {
                if (!isset($categorizedStocks[$stock->category_name])) {
                    $categorizedStocks[$stock->category_name] = [];
                }
                $categorizedStocks[$stock->category_name][] = $stock;
            }
        }

        $data = [
            'branch' => $branch,
            'stockAnalysis' => $stockAnalysis,
            'categorizedStocks' => $categorizedStocks,
            'metrics' => $stockMetrics,
            'nearingExpiry' => $nearingExpiry,
            'lowStock' => $lowStock,
            'wastage' => $wastage,
            'title' => 'Stock Analysis Report'
        ];
        
        $this->view('BranchM/v_salesReport', $data);
    }

    public function stockAnalysis() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        $stockAnalysis = $this->branchModel->getStockAnalysis($branch->branch_id);
        $stockMetrics = $this->branchModel->getStockMetrics($branch->branch_id);
        
        $categorizedStocks = [];
        if ($stockAnalysis) {
            foreach ($stockAnalysis as $stock) {
                if (!isset($categorizedStocks[$stock->category_name])) {
                    $categorizedStocks[$stock->category_name] = [];
                }
                $categorizedStocks[$stock->category_name][] = $stock;
            }
        }

        $data = [
            'branch' => $branch,
            'stockAnalysis' => $stockAnalysis,
            'categorizedStocks' => $categorizedStocks,
            'metrics' => $stockMetrics,
            'title' => 'Stock Analysis Report'
        ];
        
        $this->view('BranchM/v_salesReport', $data);
    }

    public function branchSummary() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        $summary = $this->branchModel->getBranchSummary($branch->branch_id);
        $popularProducts = $this->branchModel->getPopularProducts($branch->branch_id);
        $salesDistribution = $this->branchModel->getSalesDistribution($branch->branch_id);

        $data = [
            'branch' => $branch,
            'summary' => $summary,
            'popularProducts' => $popularProducts,
            'salesDistribution' => $salesDistribution,
            'title' => 'Branch Summary'
        ];

        $this->view('BranchM/v_salesReport', $data);
    }

    public function dailyOrder() {
        if (!isLoggedIn()) {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        // Get today's date
        $today = date('Y-m-d');
        
        // Get all products for ordering
        $products = $this->branchModel->getAllProducts();
        
        // Get today's orders
        $todayOrders = $this->branchModel->getTodaysOrders($branch->branch_id, $today);

        $data = [
            'products' => $products,
            'orders' => $todayOrders  // Add this line
        ];
        
        $this->view('BranchM/v_DailyOrder', $data);
    }

    public function submitDailyOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('Branch/dailyOrder');
            return;
        }

        try {
            $userId = $_SESSION['user_id'];
            $branch = $this->branchModel->getBranchByManager($userId);
            
            if (!$branch) {
                throw new Exception('No branch association found');
            }

            // Create order description from quantities
            $quantities = $_POST['quantities'] ?? [];
            $products = $this->branchModel->getAllProducts();
            $description = '';
            
            foreach ($products as $product) {
                $qty = isset($quantities[$product->product_id]) ? (int)$quantities[$product->product_id] : 0;
                if ($qty > 0) {
                    $description .= $product->product_name . ': ' . $qty . ', ';
                }
            }
            
            $description = rtrim($description, ', ');
            
            if (empty($description)) {
                flash('order_message', 'Please enter at least one product quantity', 'alert alert-danger');
                redirect('Branch/dailyOrder');
                return;
            }

            $orderDate = $_POST['orderDate'] ?? date('Y-m-d');
            
            // Add the order to the database
            $orderId = $this->branchModel->addDailyBranchOrder($branch->branch_id, $description, $orderDate);
            
            if ($orderId) {
                flash('order_message', 'Daily order submitted successfully', 'alert alert-success');
            } else {
                throw new Exception('Error submitting order');
            }

        } catch (Exception $e) {
            flash('order_message', 'Error: ' . $e->getMessage(), 'alert alert-danger');
        }

        redirect('Branch/dailyOrder');
    }

    public function getUpdatedOrders() {
        try {
            if (!isLoggedIn()) {
                redirect('Login/indexx');
                return;
            }

            $userId = $_SESSION['user_id'];
            $branch = $this->branchModel->getBranchByManager($userId);
            
            if (!$branch) {
                die('Error: Branch not found');
            }

            $today = date('Y-m-d');
            $orders = $this->branchModel->getTodaysOrders($branch->branch_id, $today);
            
            // Set header for auto-refresh
            header("Refresh: 5"); 
            
            $data = [
                'orders' => $orders
            ];
            
            // Load only the orders table partial view
            $this->view('BranchM/partials/orders_table', $data);
            
        } catch (Exception $e) {
            error_log('Error in getUpdatedOrders: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error fetching orders</div>';
        }
    }

    public function dashboard() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            error_log("Dashboard access failed: No branch found for user ID: " . $userId);
            die('Error: Branch manager not associated with any branch. Please contact support.');
        }

        // Get today's date and this week's date range
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $weekStart = date('Y-m-d', strtotime('-6 days'));

        // Collect all dashboard metrics
        $data = [
            'title' => 'Branch Manager Dashboard',
            'branch' => $branch,
            'todaySales' => $this->branchModel->getDailySalesSummary($branch->branch_id, $today),
            'yesterdaySales' => $this->branchModel->getDailySalesSummary($branch->branch_id, $yesterday),
            'weeklySales' => $this->branchModel->getDateRangeSummary($branch->branch_id, $weekStart, $today),
            'stockMetrics' => $this->branchModel->getStockMetrics($branch->branch_id),
            'todayOrders' => $this->branchModel->getDailyOrderCount($branch->branch_id, $today),
            'pendingOrders' => $this->branchModel->getPendingOrdersCount($branch->branch_id),
            'lowStock' => $this->branchModel->getLowStockCount($branch->branch_id),
            'expiringStock' => $this->branchModel->getExpiringStockCount($branch->branch_id),
            'topProducts' => $this->branchModel->getTopSellingProducts($branch->branch_id, $weekStart),
            'salesChartData' => $this->branchModel->getDailySalesForLastDays($branch->branch_id, 7),
            'categoryPerformance' => $this->branchModel->getCategoryPerformance($branch->branch_id, $weekStart, $today)
        ];
        
        $this->view('BranchM/v_BranchMdashboard', $data);
    }

    public function index() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found.');
        }

        // Get today's and yesterday's date
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $weekStart = date('Y-m-d', strtotime('-6 days'));
        $branchId = $branch->branch_id;

        $data = [
            'branch' => $branch,
            'todaySales' => $this->branchModel->getDailySalesSummary($branchId, $today),
            'yesterdaySales' => $this->branchModel->getDailySalesSummary($branchId, $yesterday),
            'todayOrders' => $this->branchModel->getDailyOrderCount($branchId, $today),
            'weeklySales' => $this->branchModel->getWeeklySalesSummary($branchId, $weekStart, $today),
            'stockMetrics' => $this->branchModel->getStockMetrics($branchId)
        ];

        $this->view('BranchM/v_BranchMdashboard', $data);
    }

    public function notifications() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        // Fetch notifications for this branch
        $notifications = $this->notificationModel->getNotifications($branch->branch_id);

        $data = [
            'notifications' => $notifications,
            'branch' => $branch,
            'title' => 'Notifications'
        ];
        
        $this->view('BranchM/v_notifications', $data);
    }

    public function markNotificationRead() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'));
        
        if (!isset($data->notification_id)) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['success' => false, 'message' => 'Notification ID required']);
            return;
        }

        $success = $this->notificationModel->markAsRead($data->notification_id);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function getUnreadCount() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            header('Content-Type: application/json');
            echo json_encode(['count' => 0]);
            return;
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            header('Content-Type: application/json');
            echo json_encode(['count' => 0]);
            return;
        }

        $count = $this->notificationModel->getUnreadCount($branch->branch_id);
        
        header('Content-Type: application/json');
        echo json_encode(['count' => $count]);
    }

    private function cleanupDuplicateBranchmanagerEntries($userId) {
        try {
            $db = new Database();
            // Check if there are duplicates
            $db->query("SELECT COUNT(*) as count FROM branchmanager WHERE user_id = :user_id");
            $db->bind(':user_id', $userId);
            $result = $db->single();
            if ($result && $result->count > 1) {
                error_log("Found {$result->count} duplicate entries for user {$userId}. Cleaning up...");
                // Keep only the first entry (with the lowest ID)
                $db->query("DELETE FROM branchmanager 
                           WHERE user_id = :user_id 
                           AND branchmanager_id NOT IN 
                           (SELECT * FROM (SELECT MIN(branchmanager_id) FROM branchmanager WHERE user_id = :user_id2) as tmp)");
                $db->bind(':user_id', $userId);
                $db->bind(':user_id2', $userId);
                $db->execute();
                
                error_log("Duplicates removed.");
            }
        } catch (Exception $e) {
            error_log("Error cleaning up duplicates: " . $e->getMessage());
        }   
    }

    private function createBranchAssociationIfNeeded($userId) {
        try {
            $db = new Database();
            // Check if branchmanager table has the needed columns
            $db->query("SHOW COLUMNS FROM branchmanager LIKE 'user_id'");
            $columnExists = $db->single();
            
            if (!$columnExists) {
                error_log("Adding user_id column to branchmanager table");
                $db->query("ALTER TABLE branchmanager ADD COLUMN user_id INT(11) AFTER branch_id");
                $db->execute();
            }

            // Associate user with branch if possible
            $db->query("SELECT branch_id FROM branch LIMIT 1");
            $branch = $db->single();
            if ($branch) {
                $db->query("INSERT IGNORE INTO branchmanager (user_id, branch_id) VALUES (:user_id, :branch_id)");
                $db->bind(':user_id', $userId);
                $db->bind(':branch_id', $branch->branch_id);
                $db->execute();
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error in ensureBranchManagerStructure: " . $e->getMessage());
            return false;
        }
    }
}
?>