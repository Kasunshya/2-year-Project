<?php
 class M_Cashier{
     private $db;

     public function __construct(){
         $this->db = new Database();
     }
     
     public function addCashier($data) {
        $this->db->query("INSERT INTO cashier (id, cashier_name, contacts, address, join_date, branch_name) 
                          VALUES (:id, :cashier_name, :contacts, :address, :join_date, :branch_name)");
        $this->db->bind(':id', $data['id']); // Use id from users table
        $this->db->bind(':cashier_name', $data['cashier_name']);
        $this->db->bind(':contacts', $data['contacts']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':join_date', $data['join_date']);
        $this->db->bind(':branch_name', $data['branch_name']);

        return $this->db->execute(); // Return true if successful
     }

     public function getProducts() {
        // If branch_id is available in session, show only products with stock for that branch
        if (isset($_SESSION['branch_id'])) {
            $branch_id = $_SESSION['branch_id'];
            $this->db->query("SELECT p.*, c.name as category_name, p.image_path,
                              COALESCE(bs.quantity, 0) as branch_quantity 
                              FROM product p 
                              LEFT JOIN category c ON p.category_id = c.category_id
                              INNER JOIN branchstock bs ON p.product_id = bs.product_id AND bs.branch_id = :branch_id
                              WHERE p.status = 1 AND bs.quantity > 0");
            $this->db->bind(':branch_id', $branch_id);
            error_log("Getting available products for branch_id: " . $branch_id);
        } else {
            // Fallback to showing products with stock in any branch
            $this->db->query("SELECT p.*, c.name as category_name, p.image_path,
                              p.available_quantity as branch_quantity
                              FROM product p 
                              LEFT JOIN category c ON p.category_id = c.category_id
                              WHERE p.status = 1 AND p.available_quantity > 0");
            error_log("Getting available products without branch_id");
        }
        return $this->db->resultSet();
     }

     public function getTotalOrderCount() {
        try {
            // Build query with branch and employee filters if available
            $whereClause = "WHERE 1=1";
            $params = [];
            
            if (isset($_SESSION['branch_id'])) {
                $whereClause .= " AND branch_id = :branch_id";
                $params[':branch_id'] = $_SESSION['branch_id'];
            }
            
            if (isset($_SESSION['employee_id'])) {
                $whereClause .= " AND employee_id = :employee_id";
                $params[':employee_id'] = $_SESSION['employee_id'];
            }
            
            $this->db->query("SELECT COUNT(*) AS total_orders FROM orders $whereClause");
            
            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }
            
            $result = $this->db->single();
            return $result ?: (object)['total_orders' => 0];
        } catch (Exception $e) {
            error_log("Error counting orders: " . $e->getMessage());
            return (object)['total_orders' => 0];
        }
     }

     public function calculateTotalRevenue() {
        try {
            // Check for branch_id and employee_id in session
            $whereClause = "WHERE 1=1";
            $params = [];
            
            if (isset($_SESSION['branch_id'])) {
                $whereClause .= " AND branch_id = :branch_id";
                $params[':branch_id'] = $_SESSION['branch_id'];
            }
            
            if (isset($_SESSION['employee_id'])) {
                $whereClause .= " AND employee_id = :employee_id";
                $params[':employee_id'] = $_SESSION['employee_id'];
            }
            
            $this->db->query("SELECT SUM(total) AS total_revenue FROM orders $whereClause");
            
            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }
            
            $result = $this->db->single();
            return $result->total_revenue ?? 0.00;
        } catch (Exception $e) {
            error_log("Error calculating total revenue: " . $e->getMessage());
            return 0.00;
        }
    }

    public function calculateTodaysRevenue() {
        try {
            // Build query with branch and employee filters if available
            $whereClause = "WHERE DATE(order_date) = CURDATE()";
            $params = [];
            
            if (isset($_SESSION['branch_id'])) {
                $whereClause .= " AND branch_id = :branch_id";
                $params[':branch_id'] = $_SESSION['branch_id'];
            }
            
            if (isset($_SESSION['employee_id'])) {
                $whereClause .= " AND employee_id = :employee_id";
                $params[':employee_id'] = $_SESSION['employee_id'];
            }
            
            $this->db->query("SELECT SUM(total) AS today_revenue FROM orders $whereClause");
            
            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }
            
            $result = $this->db->single();
            return $result->today_revenue ?? 0.00;
        } catch (Exception $e) {
            error_log("Error calculating today's revenue: " . $e->getMessage());
            return 0.00;
        }
    }

    public function calculateAverageOrderValue() {
        try {
            // Build query with branch and employee filters if available
            $whereClause = "WHERE DATE(order_date) = CURDATE()";
            $params = [];
            
            if (isset($_SESSION['branch_id'])) {
                $whereClause .= " AND branch_id = :branch_id";
                $params[':branch_id'] = $_SESSION['branch_id'];
            }
            
            if (isset($_SESSION['employee_id'])) {
                $whereClause .= " AND employee_id = :employee_id";
                $params[':employee_id'] = $_SESSION['employee_id'];
            }
            
            $this->db->query("SELECT AVG(total) AS avg_order_value FROM orders $whereClause");
            
            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }
            
            $result = $this->db->single();
            return $result->avg_order_value ?? 0.00;
        } catch (Exception $e) {
            error_log("Error calculating average order value: " . $e->getMessage());
            return 0.00;
        }
    }

    public function createOrder($data) {
        try {
            $this->db->beginTransaction();
            
            // Show all data we're working with
            error_log("createOrder data: " . print_r($data, true));
            
            // Check if we have a PayPal transaction ID
            $transactionIdField = isset($data['transaction_id']) ? ', transaction_id' : '';
            $transactionIdValue = isset($data['transaction_id']) ? ', :transaction_id' : '';
            
            // Use the SQL query with all required fields
            $sql = "INSERT INTO orders (
                customer_id, total, order_date, order_type, payment_method, 
                payment_status, discount, employee_id, branch_id,
                amount_tendered, change_amount" . $transactionIdField . "
            ) VALUES (
                :customer_id, :total, NOW(), :order_type, :payment_method,
                'Paid', :discount, :employee_id, :branch_id, 
                :amount_tendered, :change_amount" . $transactionIdValue . "
            )";
            
            $this->db->query($sql);
            
            // Bind all parameters including employee_id and branch_id
            $this->db->bind(':customer_id', (int)$data['customer_id']);
            $this->db->bind(':total', (float)$data['total']);
            $this->db->bind(':order_type', $data['order_type']);
            $this->db->bind(':payment_method', $data['payment_method']);
            $this->db->bind(':discount', (float)$data['discount_amount']);
            $this->db->bind(':employee_id', (int)$data['employee_id']);
            $this->db->bind(':branch_id', (int)$data['branch_id']);
            $this->db->bind(':amount_tendered', (float)$data['amount_tendered']);
            $this->db->bind(':change_amount', (float)$data['change_amount']);
            
            // Bind transaction_id if available
            if (isset($data['transaction_id'])) {
                $this->db->bind(':transaction_id', $data['transaction_id']);
            }
            
            // Debug the final values being used
            error_log("SQL execution with employee_id=" . $data['employee_id'] . ", branch_id=" . $data['branch_id']);
            
            if (!$this->db->execute()) {
                throw new Exception("Failed to execute order creation SQL");
            }
            
            $orderId = $this->db->lastInsertId();
            error_log("Created order with ID: " . $orderId);
            
            // We commit here so the order is created even if stock update fails
            // This ensures we don't lose orders but can detect inventory issues
            $this->db->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Order creation failed: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function addOrderDetail($data) {
        try {
            error_log("Adding order detail: " . print_r($data, true));
            
            $this->db->query("INSERT INTO orderdetails 
                (order_id, product_id, quantity, price) 
                VALUES 
                (:order_id, :product_id, :quantity, :price)");
            
            $this->db->bind(':order_id', (int)$data['order_id']);
            $this->db->bind(':product_id', (int)$data['product_id']);
            $this->db->bind(':quantity', (int)$data['quantity']);
            $this->db->bind(':price', (float)$data['price']);
            
            $success = $this->db->execute();
            error_log("Order detail added successfully: " . ($success ? "true" : "false"));
            return $success;
        } catch (Exception $e) {
            error_log("Failed to add order detail: " . $e->getMessage());
            return false;
        }
    }

    public function searchProducts($searchTerm) {
        // If branch_id is available in session, show only products with stock for that branch
        if (isset($_SESSION['branch_id'])) {
            $branch_id = $_SESSION['branch_id'];
            $this->db->query("SELECT p.*, c.name as category_name, 
                              COALESCE(bs.quantity, 0) as branch_quantity
                              FROM product p 
                              LEFT JOIN category c ON p.category_id = c.category_id
                              INNER JOIN branchstock bs ON p.product_id = bs.product_id AND bs.branch_id = :branch_id
                              WHERE p.status = 1 AND bs.quantity > 0
                              AND (p.product_name LIKE :search 
                              OR p.description LIKE :search 
                              OR c.name LIKE :search)");
            $this->db->bind(':branch_id', $branch_id);
            $this->db->bind(':search', '%' . $searchTerm . '%');
        } else {
            // Fallback to showing products with stock in any branch
            $this->db->query("SELECT p.*, c.name as category_name,
                              p.available_quantity as branch_quantity
                              FROM product p 
                              LEFT JOIN category c ON p.category_id = c.category_id 
                              WHERE p.status = 1 AND p.available_quantity > 0
                              AND (p.product_name LIKE :search 
                              OR p.description LIKE :search 
                              OR c.name LIKE :search)");
            $this->db->bind(':search', '%' . $searchTerm . '%');
        }
        return $this->db->resultSet();
    }

    // Add a new method to check branch stock
    public function getBranchStock($branch_id, $product_id) {
        $this->db->query("SELECT quantity FROM branchstock 
                          WHERE branch_id = :branch_id AND product_id = :product_id");
        $this->db->bind(':branch_id', $branch_id);
        $this->db->bind(':product_id', $product_id);
        $result = $this->db->single();
        return $result ? $result->quantity : 0;
    }

    public function getDailyTransactions() {
        // Debug log to check employee_id
        error_log('Employee ID from session: ' . ($_SESSION['employee_id'] ?? 'not set'));
        
        // Modify query to show all orders for today if employee_id is not set
        $this->db->query("SELECT o.order_id, o.order_date, o.total, o.payment_method, o.payment_status 
                         FROM orders o 
                         WHERE DATE(o.order_date) = CURDATE() 
                         " . (isset($_SESSION['employee_id']) ? "AND o.employee_id = :employee_id" : "") . "
                         ORDER BY o.order_date DESC");
        
        if(isset($_SESSION['employee_id'])) {
            $this->db->bind(':employee_id', $_SESSION['employee_id']);
        }
        
        $result = $this->db->resultSet();
        // Debug log to check results
        error_log('Number of transactions found: ' . count($result));
        
        return $result;
    }

    public function getDailySummary() {
        try {
            $whereBase = "WHERE DATE(order_date) = CURDATE()";
            $params = [];
            
            if(isset($_SESSION['employee_id'])) {
                $whereBase .= " AND employee_id = :employee_id";
                $params[':employee_id'] = $_SESSION['employee_id'];
            }
            
            // Get total transactions and sales first
            $this->db->query("SELECT COUNT(*) as transaction_count, 
                            SUM(total) as total_sales 
                            FROM orders 
                            $whereBase");
            
            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }
            
            $summary = $this->db->single() ?: (object)['transaction_count' => 0, 'total_sales' => 0];
            
            // Get Cash sales
            $this->db->query("SELECT SUM(total) as cash_sales 
                            FROM orders 
                            $whereBase AND payment_method = 'Cash'");
                            
            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }
            
            $cashResult = $this->db->single();
            $summary->cash_sales = $cashResult->cash_sales ?? 0;
            
            // Get Card/Credit sales
            $this->db->query("SELECT SUM(total) as card_sales 
                            FROM orders 
                            $whereBase AND payment_method != 'Cash'");
                            
            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }
            
            $cardResult = $this->db->single();
            $summary->card_sales = $cardResult->card_sales ?? 0;
            
            return $summary;
        } catch (Exception $e) {
            error_log("Error getting daily summary: " . $e->getMessage());
            return (object)[
                'transaction_count' => 0,
                'total_sales' => 0,
                'cash_sales' => 0,
                'card_sales' => 0
            ];
        }
    }

    public function getBestSellingProducts() {
        $this->db->query("SELECT p.product_name, p.price, 
                         COUNT(od.product_id) as total_sold,
                         SUM(od.quantity) as quantity_sold
                         FROM product p
                         JOIN orderdetails od ON p.product_id = od.product_id
                         JOIN orders o ON od.order_id = o.order_id
                         WHERE o.order_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                         GROUP BY p.product_id
                         ORDER BY quantity_sold DESC
                         LIMIT 5");
        return $this->db->resultSet();
    }

    public function getSalesAnalytics() {
        $this->db->query("SELECT 
            DATE_FORMAT(o.order_date, '%a') as day,
            COUNT(o.order_id) as orders_count,
            SUM(o.total) as daily_total
            FROM orders o
            WHERE o.order_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)
            GROUP BY DATE_FORMAT(o.order_date, '%a')
            ORDER BY o.order_date");
        
        return $this->db->resultSet();
    }

    public function getRecentOrders() {
        $this->db->query("SELECT 
            o.order_id,
            o.order_date,
            o.total,
            o.payment_status,
            GROUP_CONCAT(CONCAT(p.product_name, ' (', od.quantity, ')') SEPARATOR ', ') as items
        FROM orders o
        JOIN orderdetails od ON o.order_id = od.order_id
        JOIN product p ON od.product_id = p.product_id
        GROUP BY o.order_id
        ORDER BY o.order_date DESC
        LIMIT 5");
        
        return $this->db->resultSet();
    }
    
    // Update getCashierByUserId to search deeper
    public function getCashierByUserId($userId) {
        // Log the lookup process
        error_log("Looking up cashier with user_id: " . $userId);
        
        // First check the cashier table
        $this->db->query("SELECT c.cashier_id, c.employee_id, c.branch_id, c.user_id 
                         FROM cashier c 
                         WHERE c.user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        
        if ($result) {
            error_log("Found cashier record: " . print_r($result, true));
            return $result;
        }
        
        // Not found in cashier, try employee table
        $this->db->query("SELECT e.employee_id, b.branch_id 
                         FROM employee e
                         LEFT JOIN branch b ON e.branch = b.branch_name
                         WHERE e.user_id = :user_id AND e.user_role = 'cashier'");
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        
        if ($result) {
            error_log("Found employee record: " . print_r($result, true));
        } else {
            error_log("No cashier or employee found for user ID: " . $userId);
        }
        
        return $result;
    }

    public function getBranchIdForCashier($cashierId) {
        $this->db->query("SELECT branch_id FROM cashier WHERE cashier_id = :cashier_id");
        $this->db->bind(':cashier_id', $cashierId);
        $result = $this->db->single();
        
        if ($result && $result->branch_id) {
            return $result->branch_id;
        }
        
        return null; // Return null if not found
    }

    public function updateBranchStock($branch_id, $product_id, $quantity) {
        try {
            $this->db->query("UPDATE branchstock 
                             SET quantity = quantity - :quantity 
                             WHERE branch_id = :branch_id 
                             AND product_id = :product_id 
                             AND quantity >= :quantity");
            $this->db->bind(':branch_id', (int)$branch_id);
            $this->db->bind(':product_id', (int)$product_id);
            $this->db->bind(':quantity', (int)$quantity);
            
            $result = $this->db->execute();
            $rowsAffected = $this->db->rowCount();
            
            if ($rowsAffected === 0) {
                // Check if it failed because there's not enough stock
                $this->db->query("SELECT quantity FROM branchstock 
                                 WHERE branch_id = :branch_id 
                                 AND product_id = :product_id");
                $this->db->bind(':branch_id', (int)$branch_id);
                $this->db->bind(':product_id', (int)$product_id);
                $stock = $this->db->single();
                
                if ($stock && $stock->quantity < $quantity) {
                    error_log("Not enough stock for product ID $product_id at branch $branch_id. Available: $stock->quantity, Requested: $quantity");
                    return false;
                }
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error updating stock: " . $e->getMessage());
            return false;
        }
    }

    public function getTodayOrderCount() {
        try {
            // Build query with branch and employee filters if available
            $whereClause = "WHERE DATE(order_date) = CURDATE()";
            $params = [];
            
            if (isset($_SESSION['branch_id'])) {
                $whereClause .= " AND branch_id = :branch_id";
                $params[':branch_id'] = $_SESSION['branch_id'];
            }
            
            if (isset($_SESSION['employee_id'])) {
                $whereClause .= " AND employee_id = :employee_id";
                $params[':employee_id'] = $_SESSION['employee_id'];
            }
            
            $this->db->query("SELECT COUNT(*) AS today_orders FROM orders $whereClause");
            
            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }
            
            $result = $this->db->single();
            return $result ?: (object)['today_orders' => 0];
        } catch (Exception $e) {
            error_log("Error counting today's orders: " . $e->getMessage());
            return (object)['today_orders' => 0];
        }
    }
 }
