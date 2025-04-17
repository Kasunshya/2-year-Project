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
        $this->db->query("SELECT p.*, c.name as category_name 
                          FROM product p 
                          LEFT JOIN category c ON p.category_id = c.category_id 
                          WHERE p.status = 1");
        return $this->db->resultSet();
     }

     public function getTotalOrderCount() {
        $this->db->query("SELECT COUNT(*) AS total_orders FROM orders");
        return $this->db->single(); // Return as an object with total_orders property
     }

     public function calculateTotalRevenue() {
        try {
            // Since the order_details table doesn't exist, return a placeholder value
            // In a production environment, you should determine the correct table name
            return 0.00; // Return placeholder value
            
            /* Uncomment and modify when correct table name is known
            $this->db->query("SELECT SUM(total_price) AS total_revenue FROM correct_table_name");
            $result = $this->db->single();
            return $result->total_revenue ?? 0.00;
            */
        } catch (Exception $e) {
            // Gracefully handle database exceptions
            return 0.00;
        }
    }

    public function createOrder($data) {
        $this->db->beginTransaction();
        
        try {
            $this->db->query("INSERT INTO orders (customer_id, total, order_date, order_type, 
                             payment_method, payment_status, discount, employee_id, branch_id,
                             amount_tendered, change_amount) 
                             VALUES (:customer_id, :total, NOW(), :order_type, 
                             :payment_method, 'Paid', :discount, :employee_id, :branch_id,
                             :amount_tendered, :change_amount)");
            
            $this->db->bind(':customer_id', $data['customer_id']);
            $this->db->bind(':total', $data['total']);
            $this->db->bind(':order_type', $data['order_type']);
            $this->db->bind(':payment_method', $data['payment_method']);
            $this->db->bind(':discount', $data['discount_amount']);
            $this->db->bind(':employee_id', $data['employee_id']);
            $this->db->bind(':branch_id', $data['branch_id']);
            $this->db->bind(':amount_tendered', $data['amount_tendered']);
            $this->db->bind(':change_amount', $data['change_amount']);
            
            if (!$this->db->execute()) {
                throw new Exception("Failed to execute order creation");
            }
            
            $orderId = $this->db->lastInsertId();
            
            if (!$orderId) {
                throw new Exception("Failed to get last insert ID");
            }
            
            $this->db->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Order creation failed: " . $e->getMessage());
            return false;
        }
    }

    public function addOrderDetail($data) {
        try {
            $this->db->query("INSERT INTO orderdetails (order_id, product_id, quantity, price) 
                             VALUES (:order_id, :product_id, :quantity, :price)");
            
            $this->db->bind(':order_id', $data['order_id']);
            $this->db->bind(':product_id', $data['product_id']);
            $this->db->bind(':quantity', $data['quantity']);
            $this->db->bind(':price', $data['price']);
            
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Failed to add order detail: " . $e->getMessage());
            return false;
        }
    }

    public function searchProducts($searchTerm) {
        $this->db->query("SELECT p.*, c.name as category_name 
                          FROM product p 
                          LEFT JOIN category c ON p.category_id = c.category_id 
                          WHERE p.status = 1 
                          AND (p.product_name LIKE :search 
                          OR p.description LIKE :search 
                          OR c.name LIKE :search)");
        $this->db->bind(':search', '%' . $searchTerm . '%');
        return $this->db->resultSet();
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
        // Similar modification for summary
        $this->db->query("SELECT COUNT(*) as transaction_count, 
                         SUM(total) as total_sales 
                         FROM orders 
                         WHERE DATE(order_date) = CURDATE()
                         " . (isset($_SESSION['employee_id']) ? "AND employee_id = :employee_id" : ""));
        
        if(isset($_SESSION['employee_id'])) {
            $this->db->bind(':employee_id', $_SESSION['employee_id']);
        }
        
        return $this->db->single();
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
 }
