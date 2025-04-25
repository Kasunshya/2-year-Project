<?php
class M_HeadM
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getTotalCashiers()
    {
        $this->db->query('SELECT COUNT(*) as total FROM cashier');
        return $this->db->single()->total;
    }

    public function getTotalCustomers()
    {
        $this->db->query('SELECT COUNT(*) as total FROM customer');
        return $this->db->single()->total;
    }

    public function getTotalBranchManagers()
    {
        $this->db->query('SELECT COUNT(*) as total FROM branchmanager');
        return $this->db->single()->total;
    }

    public function getAllBranchManagers($search = '')
    {
        $query = '
            SELECT 
                bm.branchmanager_id, 
                bm.branch_id,
                bm.employee_id,
                e.full_name AS branchmanager_name,
                e.address,
                e.contact_no, 
                e.cv_upload, 
                e.email AS employee_email,
                b.branch_name 
            FROM branchmanager bm
            JOIN employee e ON bm.employee_id = e.employee_id
            JOIN branch b ON bm.branch_id = b.branch_id
        ';
        
        // Add search condition if a search query is provided
        if (!empty($search)) {
            $query .= ' WHERE e.full_name LIKE :search OR b.branch_name LIKE :search';
            $this->db->query($query);
            $this->db->bind(':search', '%' . $search . '%');
        } else {
            $this->db->query($query);
        }
        
        return $this->db->resultSet();
    }

    public function getBranchManagerById($id)
    {
        $this->db->query('
            SELECT 
                bm.branchmanager_id, 
                bm.user_id, 
                bm.branch_id,
                bm.employee_id,
                e.full_name AS branchmanager_name,
                e.address, 
                e.contact_no AS contact_number, 
                u.email
            FROM branchmanager bm 
            JOIN users u ON bm.user_id = u.user_id
            JOIN employee e ON bm.employee_id = e.employee_id
            WHERE bm.branchmanager_id = :id
        ');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getBranchManagerByBranchId($branch_id) {
        $this->db->query('
            SELECT 
                bm.branchmanager_id, 
                e.full_name AS branchmanager_name, 
                e.contact_no, 
                e.email 
            FROM branchmanager bm
            JOIN employee e ON bm.employee_id = e.employee_id
            WHERE bm.branch_id = :branch_id
        ');
        $this->db->bind(':branch_id', $branch_id);
        return $this->db->single();
    }

    public function getAllBranches() {
        $this->db->query('SELECT branch_id, branch_name, branch_address FROM branch'); // Include branch_address
        return $this->db->resultSet();
    }

    public function addBranchManager($data) {
        // Insert into users table
        $this->db->query('INSERT INTO users (email, password, user_role, created_at) 
                          VALUES (:email, :password, :user_role, NOW())');

        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':user_role', 'branchmanager');

        if ($this->db->execute()) {
            $user_id = $this->db->lastInsertId();
            
            // First insert into employee table
            $this->db->query('INSERT INTO employee (full_name, address, contact_no, email, user_id, user_role) 
                             VALUES (:full_name, :address, :contact_no, :email, :user_id, :user_role)');

            $this->db->bind(':full_name', $data['branchmanager_name']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':contact_no', $data['contact_number']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':user_role', 'branchmanager');

            if ($this->db->execute()) {
                $employee_id = $this->db->lastInsertId();
                
                // Then insert into branchmanager table
                $this->db->query('INSERT INTO branchmanager (employee_id, branch_id, user_id) 
                                 VALUES (:employee_id, :branch_id, :user_id)');

                $this->db->bind(':employee_id', $employee_id);
                $this->db->bind(':branch_id', $data['branch_id']);
                $this->db->bind(':user_id', $user_id);

                return $this->db->execute();
            }
        }
        return false;
    }

    public function updateBranchManager($data) {
        // Get employee_id from branchmanager
        $this->db->query('SELECT employee_id FROM branchmanager WHERE branchmanager_id = :id');
        $this->db->bind(':id', $data['branchmanager_id']);
        $branchManager = $this->db->single();
        
        if (!$branchManager) {
            return false;
        }
        
        // Update employee table
        $this->db->query('UPDATE employee SET 
                          full_name = :full_name, 
                          address = :address, 
                          contact_no = :contact_number
                          WHERE employee_id = :employee_id');

        $this->db->bind(':employee_id', $branchManager->employee_id);
        $this->db->bind(':full_name', $data['branchmanager_name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':contact_number', $data['contact_number']);

        $result1 = $this->db->execute();

        // Update branchmanager table
        $this->db->query('UPDATE branchmanager SET 
                         branch_id = :branch_id
                         WHERE branchmanager_id = :id');

        $this->db->bind(':id', $data['branchmanager_id']);
        $this->db->bind(':branch_id', $data['branch_id']);

        $result2 = $this->db->execute();

        // Update users table if password is provided
        if (!empty($data['password'])) {
            $this->db->query('UPDATE users SET password = :password WHERE user_id = :user_id');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            $result3 = $this->db->execute();
        } else {
            $result3 = true;
        }

        return ($result1 && $result2 && $result3);
    }

    public function deleteBranchManager($data) {
        // Get user_id before deletion
        $this->db->query('SELECT user_id FROM branchmanager WHERE branchmanager_id = :id');
        $this->db->bind(':id', $data['branchmanager_id']);
        $branchManager = $this->db->single();

        // Delete from branchmanager table
        $this->db->query('DELETE FROM branchmanager WHERE branchmanager_id = :id');
        $this->db->bind(':id', $data['branchmanager_id']);
        $result1 = $this->db->execute();

        // Delete from users table
        $this->db->query('DELETE FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $branchManager->user_id);
        $result2 = $this->db->execute();

        return ($result1 && $result2);
    }

    public function getAllCashiers()
    {
        $this->db->query('SELECT 
                        employee_id, 
                        full_name, 
                        email, 
                        contact_no, 
                        nic, 
                        address, 
                        branch, 
                        cv_upload 
                      FROM employee
                      WHERE user_role = "cashier"');
        return $this->db->resultSet();
    }

    public function searchCashiers($search)
    {
        $this->db->query('SELECT employee_id, full_name, email, contact_no 
                          FROM employee 
                          WHERE user_role = "cashier" 
                          AND (full_name LIKE :search OR email LIKE :search)');
        $this->db->bind(':search', '%' . $search . '%');
        return $this->db->resultSet();
    }

    public function getCashierById($employee_id)
    {
        $this->db->query('SELECT employee_id, full_name, cv_upload FROM employee WHERE employee_id = :employee_id AND user_role = "cashier"');
        $this->db->bind(':employee_id', $employee_id);
        return $this->db->single();
    }

    public function getEmployeeById($employee_id) {
        $this->db->query('
            SELECT 
                employee_id, 
                full_name, 
                cv_upload 
            FROM employee 
            WHERE employee_id = :employee_id
        ');
        $this->db->bind(':employee_id', $employee_id);
        return $this->db->single();
    }

    public function getAllProducts() {
        $this->db->query('
            SELECT 
                p.product_id, 
                p.product_name, 
                p.description, 
                p.price, 
                p.available_quantity, 
                p.star_rating, 
                c.name AS category_name, 
                c.category_id 
            FROM product p
            INNER JOIN category c ON p.category_id = c.category_id
        ');
        return $this->db->resultSet();
    }

    public function addProduct($data) {
        $this->db->query('INSERT INTO product (product_name, price, description, category_id, available_quantity) 
                          VALUES (:product_name, :price, :description, :category_id, :available_quantity)');

        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':available_quantity', $data['available_quantity']);

        return $this->db->execute();
    }

    public function editProduct($data) {
        $this->db->query('UPDATE product 
                          SET product_name = :product_name, 
                              price = :price, 
                              description = :description, 
                              category_id = :category_id, 
                              available_quantity = :available_quantity 
                          WHERE product_id = :product_id');

        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':available_quantity', $data['available_quantity']);

        return $this->db->execute();
    }

    public function updateProduct($data) {
        $this->db->query('UPDATE product 
                          SET product_name = :product_name, 
                              price = :price, 
                              description = :description, 
                              available_quantity = :available_quantity, 
                              category_id = :category_id, 
                              image = :image 
                          WHERE product_id = :product_id');

        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':available_quantity', $data['available_quantity']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':image', $data['image']);

        return $this->db->execute();
    }

    public function getProductById($productId) {
        $this->db->query('SELECT * FROM product WHERE product_id = :product_id');
        $this->db->bind(':product_id', $productId);
        return $this->db->single();
    }

    public function deleteProductById($productId) {
        $this->db->query('DELETE FROM product WHERE product_id = :product_id');
        $this->db->bind(':product_id', $productId);

        return $this->db->execute();
    }

    public function getAllCategories() {
        $this->db->query('SELECT category_id, name FROM category');
        return $this->db->resultSet();
    }

    public function searchProducts($productName, $categoryId, $minPrice, $maxPrice) {
        $query = 'SELECT 
                    p.product_id, 
                    p.product_name, 
                    p.description, 
                    p.price, 
                    p.available_quantity, 
                    p.star_rating, 
                    c.name AS category_name 
                  FROM product p
                  INNER JOIN category c ON p.category_id = c.category_id
                  WHERE 1=1';

        if (!empty($productName)) {
            $query .= ' AND p.product_name LIKE :product_name';
        }
        if (!empty($categoryId)) {
            $query .= ' AND p.category_id = :category_id';
        }
        if (!empty($minPrice)) {
            $query .= ' AND p.price >= :min_price';
        }
        if (!empty($maxPrice)) {
            $query .= ' AND p.price <= :max_price';
        }

        $this->db->query($query);

        if (!empty($productName)) {
            $this->db->bind(':product_name', '%' . $productName . '%');
        }
        if (!empty($categoryId)) {
            $this->db->bind(':category_id', $categoryId);
        }
        if (!empty($minPrice)) {
            $this->db->bind(':min_price', $minPrice);
        }
        if (!empty($maxPrice)) {
            $this->db->bind(':max_price', $maxPrice);
        }

        return $this->db->resultSet();
    }

    public function getDailyBranchOrders($branchId = '') {
        $sql = '
            SELECT 
                dbo.dailybranchorder_id, 
                b.branch_name, 
                dbo.description, 
                dbo.orderdate 
            FROM dailybranchorder dbo
            JOIN branch b ON dbo.branch_id = b.branch_id
        ';

        // Add filtering condition if a branch ID is provided
        if (!empty($branchId)) {
            $sql .= ' WHERE dbo.branch_id = :branch_id';
        }

        $this->db->query($sql);

        if (!empty($branchId)) {
            $this->db->bind(':branch_id', $branchId);
        }

        return $this->db->resultSet();
    }

    public function getAllFeedbacks($search = '') {
        $query = '
            SELECT 
                p.product_name, 
                f.star_rating, 
                f.feedback_comment, 
                f.created_at 
            FROM feedback f
            JOIN product p ON f.product_id = p.product_id
        ';

        // Add search condition if a search query is provided
        if (!empty($search)) {
            $query .= ' WHERE p.product_name LIKE :search';
            $this->db->query($query);
            $this->db->bind(':search', '%' . $search . '%');
        } else {
            $this->db->query($query);
        }

        return $this->db->resultSet();
    }

    public function getAllOrders($search = '') {
        $query = '
            SELECT 
                c.customer_name, 
                o.order_date, 
                o.order_type, 
                o.payment_method, 
                o.payment_status, 
                o.discount, 
                e.full_name AS employee_name, 
                b.branch_name, 
                o.total 
            FROM orders o
            JOIN customer c ON o.customer_id = c.customer_id
            LEFT JOIN employee e ON o.employee_id = e.employee_id
            LEFT JOIN branch b ON o.branch_id = b.branch_id
        ';

        // Add search condition if a search query is provided
        if (!empty($search)) {
            $query .= ' WHERE c.customer_name LIKE :search OR b.branch_name LIKE :search';
            $this->db->query($query);
            $this->db->bind(':search', '%' . $search . '%');
        } else {
            $this->db->query($query);
        }

        return $this->db->resultSet();
    }

    public function getBranchById($branch_id) {
        $this->db->query('SELECT branch_id, branch_name, branch_address, branch_contact FROM branch WHERE branch_id = :branch_id');
        $this->db->bind(':branch_id', $branch_id);
        return $this->db->single();
    }

    public function getCashiersByBranchId($branch_id) {
        $this->db->query('
            SELECT 
                e.employee_id, 
                e.full_name, 
                e.contact_no, 
                e.email 
            FROM cashier c
            JOIN employee e ON c.employee_id = e.employee_id
            WHERE c.branch_id = :branch_id
        ');
        $this->db->bind(':branch_id', $branch_id);
        return $this->db->resultSet();
    }

    public function getBranchByIdentifier($branchIdentifier) {
        $this->db->query('SELECT branch_id, branch_name, branch_address, branch_contact FROM branch WHERE branch_name = :branch_name OR branch_id = :branch_id');
        $this->db->bind(':branch_name', $branchIdentifier);
        $this->db->bind(':branch_id', $branchIdentifier);
        return $this->db->single();
    }

    public function getSalesReportsByBranchId($branch_id) {
        $this->db->query('
            SELECT 
                sr.report_id, 
                sr.total_sales, 
                sr.report_date 
            FROM sales_reports sr
            WHERE sr.branch_id = :branch_id
        ');
        $this->db->bind(':branch_id', $branch_id);
        return $this->db->resultSet();
    }

    public function getSalesByBranch($branch_id, $filters = [])
    {
        // Start building the query
        $sql = "SELECT DATE(o.order_date) as sales_date, SUM(o.total) as total_sales 
                FROM orders o 
                WHERE o.branch_id = :branch_id";

        // Apply date filters based on what was provided
        if (isset($filters['date']) && !empty($filters['date'])) {
            // Daily filter - exact date
            $sql .= " AND DATE(o.order_date) = :date";
        } elseif (isset($filters['month']) && isset($filters['year'])) {
            // Monthly filter - specific month and year
            $sql .= " AND MONTH(o.order_date) = :month AND YEAR(o.order_date) = :year";
        } elseif (isset($filters['year'])) {
            // Yearly filter - only year
            $sql .= " AND YEAR(o.order_date) = :year";
        }

        // Group by date for proper aggregation
        $sql .= " GROUP BY DATE(o.order_date) ORDER BY sales_date DESC";
        
        // Prepare and execute query
        $this->db->query($sql);
        $this->db->bind(':branch_id', $branch_id);
        
        // Bind date parameters if set
        if (isset($filters['date']) && !empty($filters['date'])) {
            $this->db->bind(':date', $filters['date']);
        } elseif (isset($filters['month']) && isset($filters['year'])) {
            $this->db->bind(':month', $filters['month']);
            $this->db->bind(':year', $filters['year']);
        } elseif (isset($filters['year'])) {
            $this->db->bind(':year', $filters['year']);
        }

        return $this->db->resultSet();
    }

    // Also update getTotalSalesByBranch with the same filter logic
    public function getTotalSalesByBranch($branch_id, $filters = [])
    {
        // Similar SQL with the same filters but just getting the sum
        $sql = "SELECT SUM(o.total) as total_sales 
                FROM orders o 
                WHERE o.branch_id = :branch_id";

        if (isset($filters['date']) && !empty($filters['date'])) {
            $sql .= " AND DATE(o.order_date) = :date";
        } elseif (isset($filters['month']) && isset($filters['year'])) {
            $sql .= " AND MONTH(o.order_date) = :month AND YEAR(o.order_date) = :year";
        } elseif (isset($filters['year'])) {
            $sql .= " AND YEAR(o.order_date) = :year";
        }
        
        $this->db->query($sql);
        $this->db->bind(':branch_id', $branch_id);
        
        if (isset($filters['date']) && !empty($filters['date'])) {
            $this->db->bind(':date', $filters['date']);
        } elseif (isset($filters['month']) && isset($filters['year'])) {
            $this->db->bind(':month', $filters['month']);
            $this->db->bind(':year', $filters['year']);
        } elseif (isset($filters['year'])) {
            $this->db->bind(':year', $filters['year']);
        }

        return $this->db->single();
    }
    
    

    public function getInventoryData($productName = '', $branchId = '')
    {
        $sql = '
            SELECT 
                b.branch_name, 
                p.product_name, 
                bs.quantity, 
                bs.expiry_date
            FROM branchstock bs
            JOIN branch b ON bs.branch_id = b.branch_id
            JOIN product p ON bs.product_id = p.product_id
        ';

        $conditions = [];
        if (!empty($productName)) {
            $conditions[] = 'p.product_name LIKE :product_name';
        }
        if (!empty($branchId)) {
            $conditions[] = 'bs.branch_id = :branch_id';
        }

        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $this->db->query($sql);

        if (!empty($productName)) {
            $this->db->bind(':product_name', '%' . $productName . '%');
        }
        if (!empty($branchId)) {
            $this->db->bind(':branch_id', $branchId);
        }

        return $this->db->resultSet();
    }

    public function getCashiers($nameEmail = '', $branchId = '')
    {
        $sql = '
            SELECT 
                e.employee_id, 
                e.full_name, 
                e.email, 
                e.contact_no, 
                e.nic, 
                e.address, 
                b.branch_name AS branch, -- Alias branch_name as branch
                e.cv_upload
            FROM cashier c
            JOIN employee e ON c.employee_id = e.employee_id
            JOIN branch b ON c.branch_id = b.branch_id
        ';

        $conditions = [];
        if (!empty($nameEmail)) {
            $conditions[] = '(e.full_name LIKE :name_email OR e.email LIKE :name_email)';
        }
        if (!empty($branchId)) {
            $conditions[] = 'c.branch_id = :branch_id';
        }

        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $this->db->query($sql);

        if (!empty($nameEmail)) {
            $this->db->bind(':name_email', '%' . $nameEmail . '%');
        }
        if (!empty($branchId)) {
            $this->db->bind(':branch_id', $branchId);
        }

        return $this->db->resultSet();
    }

    public function getAllCustomizations()
    {
        $this->db->query('
            SELECT 
                c.customisation_id,
                cu.customer_name,
                c.flavour,
                c.size,
                c.toppings,
                c.custom_message,
                c.delivery_date
            FROM customisation c
            JOIN customer cu ON c.customer_id = cu.customer_id
        ');

        return $this->db->resultSet();
    }

    public function getAllPreOrders()
    {
        $this->db->query('
            SELECT 
                preorder_id,
                first_name,
                last_name,
                email_address AS email,
                phone_number,
                description
            FROM preorder
        ');

        return $this->db->resultSet();
    }

    public function getFeedbacks($productName = '')
    {
        $sql = '
            SELECT 
                f.*,
                c.customer_name,
                p.product_name
            FROM feedback f
            LEFT JOIN customer c ON f.customer_id = c.customer_id
            LEFT JOIN orders o ON f.order_id = o.order_id
            LEFT JOIN orderdetails od ON o.order_id = od.order_id
            LEFT JOIN product p ON od.product_id = p.product_id
        ';

        if (!empty($productName)) {
            $sql .= ' WHERE p.product_name LIKE :product_name';
        }

        // Debug query
        error_log("SQL Query: " . $sql);

        $this->db->query($sql);

        if (!empty($productName)) {
            $this->db->bind(':product_name', '%' . $productName . '%');
        }

        $result = $this->db->resultSet();
        
        // Debug result
        error_log("Query Result: " . print_r($result, true));
        
        return $result;
    }

    public function getPreOrders($search = '')
    {
        $sql = '
            SELECT 
                enquiry_id,
                first_name,
                last_name,
                email_address AS email,
                phone_number,
                message as description
            FROM enquiry
        ';

        if (!empty($search)) {
            $sql .= ' WHERE first_name LIKE :search 
                      OR last_name LIKE :search 
                      OR email_address LIKE :search';
        }

        $this->db->query($sql);

        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }

        return $this->db->resultSet();
    }

    public function getEnquiryById($enquiry_id) {
        $this->db->query('SELECT * FROM enquiry WHERE enquiry_id = :enquiry_id');
        $this->db->bind(':enquiry_id', $enquiry_id);
        return $this->db->single();
    }

    public function getOrders($filters = [])
    {
        $sql = '
            SELECT 
                o.order_id,
                c.customer_name,
                o.order_date,
                o.order_type,
                o.payment_method,
                o.payment_status,
                o.discount,
                e.full_name AS employee_name,
                b.branch_name,
                o.total
            FROM orders o
            JOIN customer c ON o.customer_id = c.customer_id
            JOIN employee e ON o.employee_id = e.employee_id
            JOIN branch b ON o.branch_id = b.branch_id
        ';

        $conditions = [];
        if (!empty($filters['customer_name'])) {
            $conditions[] = '(c.customer_name LIKE :customer_name)';
        }
        if (!empty($filters['payment_method'])) {
            $conditions[] = 'o.payment_method = :payment_method';
        }
        if (!empty($filters['order_type'])) {
            $conditions[] = 'o.order_type = :order_type';
        }
        if (!empty($filters['branch_id'])) {
            $conditions[] = 'o.branch_id = :branch_id';
        }
        if (!empty($filters['date'])) {
            $conditions[] = 'o.order_date = :date';
        }
        if (!empty($filters['month'])) {
            $conditions[] = 'MONTH(o.order_date) = :month';
        }
        if (!empty($filters['year'])) {
            $conditions[] = 'YEAR(o.order_date) = :year';
        }

        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $this->db->query($sql);

        if (!empty($filters['customer_name'])) {
            $this->db->bind(':customer_name', '%' . $filters['customer_name'] . '%');
        }
        if (!empty($filters['payment_method'])) {
            $this->db->bind(':payment_method', $filters['payment_method']);
        }
        if (!empty($filters['order_type'])) {
            $this->db->bind(':order_type', $filters['order_type']);
        }
        if (!empty($filters['branch_id'])) {
            $this->db->bind(':branch_id', $filters['branch_id']);
        }
        if (!empty($filters['date'])) {
            $this->db->bind(':date', $filters['date']);
        }
        if (!empty($filters['month'])) {
            $this->db->bind(':month', $filters['month']);
        }
        if (!empty($filters['year'])) {
            $this->db->bind(':year', $filters['year']);
        }

        return $this->db->resultSet();
    }

    public function getCustomizations($customerName = '')
    {
        $sql = '
            SELECT 
                cc.customization_id,
                c.customer_name,
                cc.flavor,
                cc.size,
                cc.toppings,
                cc.premium_toppings,
                cc.message,
                cc.delivery_option,
                cc.delivery_address,
                cc.delivery_date,
                cc.order_status,
                cc.created_at
            FROM cake_customization cc
            JOIN customer c ON cc.customer_id = c.customer_id
        ';

        // Add search condition if a customer name is provided
        if (!empty($customerName)) {
            $sql .= ' WHERE c.customer_name LIKE :customer_name';
        }

        $this->db->query($sql);

        if (!empty($customerName)) {
            $this->db->bind(':customer_name', '%' . $customerName . '%');
        }

        return $this->db->resultSet();
    }

    public function getCustomizationById($customization_id) {
        $this->db->query('
            SELECT 
                cc.customization_id,
                c.customer_name,
                u.email AS customer_email,
                cc.flavor,
                cc.size,
                cc.toppings,
                cc.premium_toppings,
                cc.message,
                cc.delivery_option,
                cc.delivery_address,
                cc.delivery_date,
                cc.order_status,
                cc.created_at
            FROM cake_customization cc
            JOIN customer c ON cc.customer_id = c.customer_id
            JOIN users u ON c.user_id = u.user_id
            WHERE cc.customization_id = :customization_id
        ');
        $this->db->bind(':customization_id', $customization_id);
        return $this->db->single();
    }

    public function updateCustomizationStatus($customization_id, $status) {
        $this->db->query('
            UPDATE cake_customization 
            SET order_status = :status 
            WHERE customization_id = :customization_id
        ');
        $this->db->bind(':customization_id', $customization_id);
        $this->db->bind(':status', $status);
        
        return $this->db->execute();
    }

    public function getTotalProducts()
    {
        $this->db->query('SELECT COUNT(*) as total FROM product');
        return $this->db->single()->total;
    }

    public function getTotalOrders()
    {
        $this->db->query('SELECT COUNT(*) as total FROM orders');
        return $this->db->single()->total;
    }

    public function getTotalRevenue()
    {
        $this->db->query('SELECT SUM(total) as total_revenue FROM orders');
        $result = $this->db->single();
        return $result ? $result->total_revenue : 0;
    }

    public function getSalesAnalytics()
    {
        $this->db->query('
            SELECT 
                DATE(order_date) as day,
                SUM(total) as daily_total
            FROM orders
            GROUP BY DATE(order_date)
            ORDER BY day DESC
            LIMIT 14
        ');
        return $this->db->resultSet();
    }

    public function getBestSellingProducts()
    {
        $this->db->query('
            SELECT 
                p.product_id,
                p.product_name,
                p.price,
                SUM(od.quantity) as quantity_sold,
                SUM(od.quantity * od.price) as total_revenue
            FROM orderdetails od
            JOIN product p ON od.product_id = p.product_id
            GROUP BY p.product_id
            ORDER BY quantity_sold DESC
            LIMIT 4
        ');
        return $this->db->resultSet();
    }

    public function getRecentOrders()
    {
        $this->db->query('
            SELECT 
                o.order_id,
                o.order_date,
                o.total,
                o.payment_status,
                b.branch_name,
                COUNT(od.order_detail_id) as items
            FROM orders o
            LEFT JOIN orderdetails od ON o.order_id = od.order_id
            LEFT JOIN branch b ON o.branch_id = b.branch_id
            GROUP BY o.order_id
            ORDER BY o.order_date DESC
            LIMIT 5
        ');
        return $this->db->resultSet();
    }

    public function getOrderDates()
    {
        $this->db->query('
            SELECT 
                DATE(order_date) as order_day,
                COUNT(*) as order_count,
                SUM(total) as day_total
            FROM orders
            WHERE order_date >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)
            GROUP BY order_day
        ');
        return $this->db->resultSet();
    }

    public function getBranchPerformance()
    {
        $this->db->query('
            SELECT 
                b.branch_name,
                COUNT(o.order_id) as order_count,
                SUM(o.total) as total_sales
            FROM branch b
            LEFT JOIN orders o ON b.branch_id = o.branch_id
            GROUP BY b.branch_id
            ORDER BY total_sales DESC
        ');
        return $this->db->resultSet();
    }

    public function getLatestFeedbacks()
    {
        $this->db->query('
            SELECT 
                f.feedback_id,
                f.feedback_text,
                f.created_at AS feedback_date,
                p.product_id,
                p.product_name,
                p.image_path AS product_image
            FROM feedback f
            JOIN product p ON f.order_id = p.product_id
            ORDER BY f.created_at DESC
            LIMIT 5
        ');
        
        return $this->db->resultSet();
    }

    public function postFeedbackToHomepage($feedback_id) {
        // Update the feedback to mark it as "posted" without requiring star_rating
        $this->db->query('UPDATE feedback SET is_posted = 1 WHERE feedback_id = :feedback_id');
        $this->db->bind(':feedback_id', $feedback_id);
        
        return $this->db->execute();
    }

    public function getPostedFeedbacks() {
        // Get feedbacks that have been posted to the homepage (limit to 3 most recent)
        $this->db->query('
            SELECT 
                f.feedback_id,
                c.customer_name,
                f.feedback_text,
                f.star_rating,
                f.created_at,
                p.product_name
            FROM feedback f
            LEFT JOIN customer c ON f.customer_id = c.customer_id
            LEFT JOIN product p ON f.product_id = p.product_id
            WHERE f.is_posted = 1
            ORDER BY f.created_at DESC
            LIMIT 3
        ');
        
        return $this->db->resultSet();
    }
}
?>