<?php
class M_Branch {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
   
    public function getBranchById($branchId) {
        $this->db->query('SELECT * FROM branch WHERE branch_id = :branch_id');
        $this->db->bind(':branch_id', $branchId);
        return $this->db->single();
    }

    public function getAllBranches() {
        $this->db->query('SELECT * FROM branch ORDER BY branch_name');
        return $this->db->resultSet();
    }

    public function getBranchByEmployee($employeeId) {
        $this->db->query('SELECT b.* 
                         FROM branch b 
                         JOIN employee e ON e.branch = b.branch_name 
                         WHERE e.employee_id = :employee_id');
        $this->db->bind(':employee_id', $employeeId);
        return $this->db->single();
    }

    public function checkBranchManager($userId) {
        $this->db->query('SELECT bm.* FROM branchmanager bm 
                         JOIN users u ON u.user_id = :user_id 
                         WHERE u.user_role = "branchmanager" 
                         AND u.user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    public function getBranchByManager($userId) {
        error_log("getBranchByManager called with userId: " . $userId);
        
        try {
            // Use the simplest possible query to get branch data
            $this->db->query("SELECT b.* 
                             FROM branch b 
                             WHERE b.branch_id = (
                                 SELECT branch_id FROM branchmanager 
                                 WHERE user_id = :user_id 
                                 LIMIT 1
                             )");
            $this->db->bind(':user_id', $userId);
            $branch = $this->db->single();
            
            if ($branch) {
                error_log("getBranchByManager: SUCCESS - Found branch with ID: " . $branch->branch_id);
                return $branch;
            }
            
            error_log("getBranchByManager: No branch found using subquery approach");
            
            // Fallback to direct join
            $this->db->query("SELECT b.* 
                             FROM branch b, branchmanager bm
                             WHERE b.branch_id = bm.branch_id
                             AND bm.user_id = :user_id
                             LIMIT 1");
            $this->db->bind(':user_id', $userId);
            $branch = $this->db->single();
            
            if ($branch) {
                error_log("getBranchByManager: SUCCESS - Found branch with ID: " . $branch->branch_id . " using direct join");
                return $branch;
            }
            
            error_log("getBranchByManager: FAILED - Could not find any branch for this user");
            return null;
        } catch (Exception $e) {
            error_log("Error in getBranchByManager: " . $e->getMessage());
            return null;
        }
    }
    
    private function cleanupDuplicateEntries($userId) {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM branchmanager WHERE user_id = :user_id");
            $this->db->bind(':user_id', $userId);
            $result = $this->db->single();
            
            if ($result && $result->count > 1) {
                error_log("Found {$result->count} duplicate entries for user {$userId}. Cleaning up...");
                
                // Keep only the first entry
                $this->db->query("DELETE FROM branchmanager 
                                 WHERE user_id = :user_id 
                                 AND branchmanager_id NOT IN 
                                 (SELECT * FROM (
                                     SELECT MIN(branchmanager_id) 
                                     FROM branchmanager 
                                     WHERE user_id = :user_id2
                                 ) as tmp)");
                $this->db->bind(':user_id', $userId);
                $this->db->bind(':user_id2', $userId);
                $this->db->execute();
                
                error_log("Cleanup complete");
            }
        } catch (Exception $e) {
            error_log("Error cleaning up duplicates: " . $e->getMessage());
        }
    }

    private function createBranchManagerAssociation($userId, $branchId) {
        try {
            error_log("Creating branch manager association for user {$userId} and branch {$branchId}");
            
            // Insert into branchmanager table
            $this->db->query("INSERT INTO branchmanager (user_id, branch_id) 
                            VALUES (:user_id, :branch_id)");
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':branch_id', $branchId);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error creating branch manager association: " . $e->getMessage());
            return false;
        }
    }

    public function getBranchStock($branchId) {
        if (!$branchId) {
            error_log("Invalid branch ID provided to getBranchStock");
            return [];
        }

        $this->db->query('SELECT bs.stock_id, bs.product_id, p.product_name, 
                         c.name as category_name, bs.quantity, bs.expiry_date, p.price 
                         FROM branchstock bs
                         JOIN product p ON bs.product_id = p.product_id
                         JOIN category c ON p.category_id = c.category_id
                         WHERE bs.branch_id = :branch_id
                         ORDER BY c.name, p.product_name');
        $this->db->bind(':branch_id', $branchId);
        return $this->db->resultSet();
    }

    public function getAllProducts() {
        $this->db->query('SELECT p.product_id, p.product_name, p.price, 
                         c.name as category_name 
                         FROM product p 
                         JOIN category c ON p.category_id = c.category_id 
                         WHERE p.is_active = 1
                         ORDER BY p.product_name');
        return $this->db->resultSet();
    }

    public function getAllCategories() {
        $this->db->query('SELECT * FROM category ORDER BY name');
        return $this->db->resultSet();
    }

    public function updateBranchStock($branchId, $productId, $quantity, $expiryDate) {
        $this->db->query('INSERT INTO branchstock (branch_id, product_id, quantity, expiry_date) 
                         VALUES (:branch_id, :product_id, :quantity, :expiry_date)
                         ON DUPLICATE KEY UPDATE 
                         quantity = quantity + :quantity,
                         expiry_date = :expiry_date');
        
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':product_id', $productId);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':expiry_date', $expiryDate);
        
        return $this->db->execute();
    }

    public function updateDailyStock($branchId, $productId, $quantity, $expiryDate) {
        // First clear existing stock for this product
        $this->db->query('UPDATE branchstock 
                         SET quantity = 0 
                         WHERE branch_id = :branch_id 
                         AND product_id = :product_id');
        
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':product_id', $productId);
        $this->db->execute();

        // Then insert new stock
        $this->db->query('INSERT INTO branchstock (branch_id, product_id, quantity, expiry_date) 
                         VALUES (:branch_id, :product_id, :quantity, :expiry_date)
                         ON DUPLICATE KEY UPDATE 
                         quantity = :quantity,
                         expiry_date = :expiry_date');
        
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':product_id', $productId);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':expiry_date', $expiryDate);
        
        return $this->db->execute();
    }

    public function getDailyTransactions($branchId, $date = null) {
        $date = $date ?? date('Y-m-d');
        
        $this->db->query("SELECT 
            o.order_id, 
            o.order_date, 
            o.total, 
            o.payment_method, 
            o.payment_status,
            e.full_name as cashier_name,
            COUNT(od.product_id) as items_count
            FROM orders o
            LEFT JOIN employee e ON o.employee_id = e.employee_id
            LEFT JOIN orderdetails od ON o.order_id = od.order_id
            WHERE o.branch_id = :branch_id 
            AND DATE(o.order_date) = :date
            GROUP BY o.order_id, o.order_date, o.total, 
                     o.payment_method, o.payment_status, e.full_name
            ORDER BY o.order_date DESC");
        
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':date', $date);
        return $this->db->resultSet();
    }

    public function getDailySalesSummary($branchId, $date) {
        $this->db->query("SELECT 
                 COALESCE(SUM(total), 0) as total_sales,
                 COUNT(*) as transaction_count
                 FROM orders
                 WHERE branch_id = :branch_id 
                 AND DATE(order_date) = :date
                 AND payment_status IN ('Paid', 'Completed')");
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':date', $date);
        
        return $this->db->single();
    }

    public function getWeeklySalesSummary($branchId, $startDate, $endDate) {
        $this->db->query("SELECT 
                 COALESCE(SUM(total), 0) as total_sales,
                 COUNT(*) as total_orders
                 FROM orders
                 WHERE branch_id = :branch_id 
                 AND DATE(order_date) BETWEEN :start_date AND :end_date
                 AND payment_status IN ('Paid', 'Completed')");
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        
        return $this->db->single();
    }

    public function getTopSellingProducts($branchId, $date = null) {
        $date = $date ?? date('Y-m-d');
        
        $this->db->query("SELECT p.product_name, 
            SUM(od.quantity) as total_quantity,
            SUM(od.quantity * od.price) as total_revenue
            FROM orderdetails od
            JOIN orders o ON od.order_id = o.order_id
            JOIN product p ON od.product_id = p.product_id
            WHERE o.branch_id = :branch_id 
            AND DATE(o.order_date) = :date
            GROUP BY p.product_id
            ORDER BY total_quantity DESC
            LIMIT 5");
        
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':date', $date);
        return $this->db->resultSet();
    }

    public function getDateRangeTransactions($branchId, $startDate, $endDate) {
        $this->db->query("SELECT 
            o.order_id, 
            o.order_date, 
            o.total, 
            o.payment_method, 
            o.payment_status,
            e.full_name as cashier_name,
            COUNT(od.product_id) as items_count
            FROM orders o
            LEFT JOIN employee e ON o.employee_id = e.employee_id
            LEFT JOIN orderdetails od ON o.order_id = od.order_id
            WHERE o.branch_id = :branch_id 
            AND DATE(o.order_date) BETWEEN :start_date AND :end_date
            GROUP BY o.order_id, o.order_date, o.total, 
                     o.payment_method, o.payment_status, e.full_name
            ORDER BY o.order_date DESC");
        
        $this->db->bind(':branch_id', $branchId); // Fixed capitalization
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        return $this->db->resultSet();
    }

    public function getDateRangeSummary($branchId, $startDate, $endDate) {
        // Log input parameters clearly
        error_log("[getDateRangeSummary] Fetching summary for Branch ID: {$branchId}, Start: {$startDate}, End: {$endDate}");
        
        // Add COALESCE to prevent null results from SUM/AVG/COUNT if no orders exist
        $this->db->query("SELECT
            COALESCE(COUNT(DISTINCT o.order_id), 0) as total_orders,
            COALESCE(SUM(o.total), 0) as total_sales,
            COALESCE(SUM(CASE WHEN o.payment_method = 'Cash' THEN o.total ELSE 0 END), 0) as cash_sales,
            COALESCE(SUM(CASE WHEN o.payment_method != 'Cash' THEN o.total ELSE 0 END), 0) as card_sales,
            COALESCE(COUNT(DISTINCT o.employee_id), 0) as total_cashiers,
            COALESCE(AVG(o.total), 0) as average_order_value,
            COALESCE(COUNT(DISTINCT DATE(o.order_date)), 0) as total_days
            FROM orders o
            WHERE o.branch_id = :branch_id
            AND DATE(o.order_date) BETWEEN :start_date AND :end_date
            AND o.payment_status IN ('Paid', 'Completed')"); // Added payment status filter

        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        $result = $this->db->single();
        
        // Log the result
        error_log("[getDateRangeSummary] Query Result: " . json_encode($result));
        
        // Ensure result is an object even if query fails or returns null
        return $result ?: (object)[
            'total_orders' => 0, 
            'total_sales' => 0.0, 
            'cash_sales' => 0.0, 
            'card_sales' => 0.0, 
            'total_cashiers' => 0, 
            'average_order_value' => 0.0, 
            'total_days' => 0
        ];
    }

    public function getProductPerformance($branchId, $startDate, $endDate) {
        $this->db->query("SELECT 
            p.product_id,
            p.product_name,
            c.name as category_name,
            COALESCE(SUM(od.quantity), 0) as total_sold,
            COALESCE(SUM(od.quantity * od.price), 0) as total_revenue,
            COUNT(DISTINCT o.order_id) as order_count,
            COALESCE(AVG(od.price), 0) as average_price
            FROM product p
            JOIN category c ON p.category_id = c.category_id
            LEFT JOIN orderdetails od ON p.product_id = od.product_id
            LEFT JOIN orders o ON od.order_id = o.order_id AND o.branch_id = :branch_id 
                AND DATE(o.order_date) BETWEEN :start_date AND :end_date
                AND o.payment_status IN ('Paid', 'Completed')
            GROUP BY p.product_id, p.product_name, c.name
            ORDER BY total_revenue DESC");
        
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        return $this->db->resultSet();
    }

    public function getCategoryPerformance($branchId, $startDate, $endDate) {
        $this->db->query("SELECT 
            c.name as category_name,
            COUNT(DISTINCT p.product_id) as product_count,
            COALESCE(SUM(od.quantity), 0) as total_sold,
            COALESCE(SUM(od.quantity * od.price), 0) as total_revenue
            FROM category c
            JOIN product p ON c.category_id = p.category_id
            LEFT JOIN orderdetails od ON p.product_id = od.product_id
            LEFT JOIN orders o ON od.order_id = o.order_id AND o.branch_id = :branch_id 
                AND DATE(o.order_date) BETWEEN :start_date AND :end_date
                AND o.payment_status IN ('Paid', 'Completed')
            GROUP BY c.category_id, c.name
            ORDER BY total_revenue DESC");
        
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        return $this->db->resultSet();
    }

    public function getDailyBranchOrders($branchId, $date) {
        $this->db->query('SELECT * FROM dailybranchorder 
                      WHERE branch_id = :branch_id 
                      AND DATE(orderdate) = :orderdate
                      ORDER BY dailybranchorder_id DESC');
        
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':orderdate', $date);
        
        return $this->db->resultSet();
    }

    public function addDailyBranchOrder($branchId, $description, $orderDate, $quantities) {
        $this->db->beginTransaction();

        try {
            // Insert main order with default pending status
            $this->db->query('INSERT INTO dailybranchorder 
                             (branch_id, description, orderdate, status) 
                             VALUES (:branch_id, :description, :orderdate, :status)');
            
            $this->db->bind(':branch_id', $branchId);
            $this->db->bind(':description', $description);
            $this->db->bind(':orderdate', $orderDate);
            $this->db->bind(':status', 'pending'); // Always set initial status to pending
            
            $this->db->execute();
            $orderId = $this->db->lastInsertId();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error in addDailyBranchOrder: " . $e->getMessage());
            return false;
        }
    }

    public function getDailySalesChartData($branchId, $startDate, $endDate) {
        $this->db->query("SELECT 
            DATE(o.order_date) as sale_date,
            SUM(o.total) as total_sales,
            COUNT(DISTINCT o.order_id) as order_count
            FROM orders o
            WHERE o.branch_id = :branch_id 
            AND DATE(o.order_date) BETWEEN :start_date AND :end_date
            GROUP BY DATE(o.order_date)
            ORDER BY DATE(o.order_date)");
            
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        return $this->db->resultSet();
    }

    public function getCategorySalesData($branchId, $startDate, $endDate) {
        $this->db->query("SELECT 
            c.name as category_name,
            SUM(od.quantity * od.price) as total_sales
            FROM orders o
            JOIN orderdetails od ON o.order_id = od.order_id
            JOIN product p ON od.product_id = p.product_id
            JOIN category c ON p.category_id = c.category_id
            WHERE o.branch_id = :branch_id 
            AND DATE(o.order_date) BETWEEN :start_date AND :end_date
            GROUP BY c.category_id, c.name
            ORDER BY total_sales DESC");
            
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        return $this->db->resultSet();
    }

    public function getLowStockProducts($branchId, $threshold = 10) {
        $this->db->query("SELECT 
            bs.product_id, 
            p.product_name,
            bs.quantity,
            c.name as category_name
            FROM branchstock bs
            JOIN product p ON bs.product_id = p.product_id
            JOIN category c ON p.category_id = c.category_id
            WHERE bs.branch_id = :branch_id
            AND bs.quantity <= :threshold
            ORDER BY bs.quantity ASC");
            
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':threshold', $threshold);
        return $this->db->resultSet();
    }

    /**
     * Get stock metrics for a branch
     */
    public function getStockMetrics($branchId) {
        // Get total quantity from branchstock table - same as used in v_stock page
        $this->db->query("SELECT 
                        COUNT(DISTINCT bs.product_id) as total_products,
                        SUM(bs.quantity) as total_items
                        FROM branchstock bs
                        WHERE bs.branch_id = :branch_id");
        $this->db->bind(':branch_id', $branchId);
        
        $result = $this->db->single();
        
        // Create default object if query returns nothing
        if (!$result) {
            $result = new stdClass();
            $result->total_products = 0;
            $result->total_items = 0;
        }
        
        return $result;
    }

    public function getCategorySalesByPaymentMethod($branchId, $startDate, $endDate) {
        $this->db->query("SELECT 
            c.name as category_name,
            SUM(CASE WHEN o.payment_method = 'Cash' THEN od.quantity * od.price ELSE 0 END) as cash_sales,
            SUM(CASE WHEN o.payment_method = 'Credit Card' THEN od.quantity * od.price ELSE 0 END) as card_sales,
            SUM(od.quantity * od.price) as total_sales
            FROM orders o
            JOIN orderdetails od ON o.order_id = od.order_id
            JOIN product p ON od.product_id = p.product_id
            JOIN category c ON p.category_id = c.category_id
            WHERE o.branch_id = :branch_id 
            AND DATE(o.order_date) BETWEEN :start_date AND :end_date
            GROUP BY c.category_id, c.name
            ORDER BY total_sales DESC");
            
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        return $this->db->resultSet();
    }

    // Get daily order count
    public function getDailyOrderCount($branchId, $date) {
        $this->db->query("SELECT COUNT(*) as order_count FROM dailybranchorder 
                         WHERE branch_id = :branch_id 
                         AND DATE(orderdate) = :date");
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':date', $date);
        
        $result = $this->db->single();
        return $result ? $result->order_count : 0;
    }

    // Get pending orders count
    public function getPendingOrdersCount($branchId) {
        $this->db->query("SELECT COUNT(*) as pending_count FROM dailybranchorder 
                         WHERE branch_id = :branch_id 
                         AND status = 'pending'");
        $this->db->bind(':branch_id', $branchId);
        
        $result = $this->db->single();
        return $result ? $result->pending_count : 0;
    }

    // Get count of low stock items
    public function getLowStockCount($branchId) {
        $this->db->query("SELECT COUNT(*) as low_count FROM branchstock 
                         WHERE branch_id = :branch_id 
                         AND quantity <= 5");
        $this->db->bind(':branch_id', $branchId);
        
        $result = $this->db->single();
        return $result ? $result->low_count : 0;
    }

    // Get count of expiring stock items (next 3 days)
    public function getExpiringStockCount($branchId) {
        $today = date('Y-m-d');
        $threeDaysLater = date('Y-m-d', strtotime('+3 days'));
        
        $this->db->query("SELECT COUNT(*) as expiring_count FROM branchstock 
                         WHERE branch_id = :branch_id 
                         AND expiry_date BETWEEN :today AND :three_days");
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':today', $today);
        $this->db->bind(':three_days', $threeDaysLater);
        
        $result = $this->db->single();
        return $result ? $result->expiring_count : 0;
    }

    // Get daily sales data for last N days (for chart)
    public function getDailySalesForLastDays($branchId, $days = 7) {
        $result = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $this->db->query("SELECT COALESCE(SUM(total), 0) as sales
                         FROM orders
                         WHERE branch_id = :branch_id 
                         AND DATE(order_date) = :date
                         AND payment_status IN ('Paid', 'Completed')");
            $this->db->bind(':branch_id', $branchId);
            $this->db->bind(':date', $date);
            
            $sales = $this->db->single();
            
            $result[] = [
                'date' => date('M d', strtotime($date)),
                'sales' => $sales ? $sales->sales : 0
            ];
        }
        return $result;
    }

    public function getTodaysOrders($branchId, $date) {
        $this->db->query('SELECT 
                        dailybranchorder_id, 
                        description, 
                        orderdate, 
                        COALESCE(status, "pending") as status 
                        FROM dailybranchorder 
                        WHERE branch_id = :branch_id 
                        AND DATE(orderdate) = :date
                        ORDER BY dailybranchorder_id DESC');
    
        $this->db->bind(':branch_id', $branchId);
        $this->db->bind(':date', $date);
    
        return $this->db->resultSet();
    }

    
}
?>
