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

    public function getAllBranches()
    {
        $this->db->query('SELECT branch_id, branch_name FROM branch');
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

    public function getDailyBranchOrders() {
        $this->db->query('
            SELECT
                dbo.dailybranchorder_id, 
                b.branch_name, 
                dbo.description, 
                dbo.orderdate 
            FROM dailybranchorder dbo
            JOIN branch b ON dbo.branch_id = b.branch_id
        ');
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
}
?>