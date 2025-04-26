<?php
class Branch extends Controller {
    private $branchModel;
    
    public function __construct() {
        $this->branchModel = $this->model('M_Branch');
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
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        $products = $this->branchModel->getAllProducts();
        $currentOrders = $this->branchModel->getDailyBranchOrders($branch->branch_id, date('Y-m-d'));

        $data = [
            'branch' => $branch,
            'products' => $products,
            'currentOrders' => $currentOrders,
            'title' => 'Daily Branch Order'
        ];
        
        $this->view('BranchM/v_dailyOrder', $data);
    }

    public function submitDailyOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('Branch/dailyOrder');
        }

        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found');
        }

        $description = $_POST['description'];
        $orderDate = $_POST['orderDate'] ?? date('Y-m-d');
        $quantities = $_POST['quantities'] ?? [];

        // Filter out zero quantities
        $quantities = array_filter($quantities, function($qty) {
            return (int)$qty > 0;
        });

        if (empty($quantities)) {
            flash('order_message', 'Please enter at least one product quantity', 'alert alert-danger');
            redirect('Branch/dailyOrder');
            return;
        }

        if ($this->branchModel->addDailyBranchOrder($branch->branch_id, $description, $orderDate, $quantities)) {
            flash('order_message', 'Daily order submitted successfully');
        } else {
            flash('order_message', 'Error submitting daily order', 'alert alert-danger');
        }
        
        redirect('Branch/dailyOrder');
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
            
            // Sales metrics
            'todaySales' => $this->branchModel->getDailySalesSummary($branch->branch_id, $today),
            'yesterdaySales' => $this->branchModel->getDailySalesSummary($branch->branch_id, $yesterday),
            'weeklySales' => $this->branchModel->getDateRangeSummary($branch->branch_id, $weekStart, $today),
            
            // Order metrics
            'todayOrders' => $this->branchModel->getDailyOrderCount($branch->branch_id, $today),
            'pendingOrders' => $this->branchModel->getPendingOrdersCount($branch->branch_id),
            
            // Stock metrics
            'stockMetrics' => $this->branchModel->getStockMetrics($branch->branch_id),
            'lowStock' => $this->branchModel->getLowStockCount($branch->branch_id),
            'expiringStock' => $this->branchModel->getExpiringStockCount($branch->branch_id),
            
            // Product performance
            'topProducts' => $this->branchModel->getTopSellingProducts($branch->branch_id, $weekStart),
            
            // Charts data
            'salesChartData' => $this->branchModel->getDailySalesForLastDays($branch->branch_id, 7),
            'categoryPerformance' => $this->branchModel->getCategoryPerformance($branch->branch_id, $weekStart, $today)
        ];
        
        $this->view('BranchM/v_BranchMdashboard', $data);
    }

    public function index() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'branchmanager') {
            redirect('Login/indexx');
        }

        // Get branch ID of the logged-in manager
        $userId = $_SESSION['user_id'];
        $branch = $this->branchModel->getBranchByManager($userId);
        
        if (!$branch) {
            die('Error: No branch association found.');
        }
        
        $branchId = $branch->branch_id;
        
        // Get today's and yesterday's date
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $weekStart = date('Y-m-d', strtotime('-6 days'));
        
        // Add stockMetrics to the data array
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