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

    public function getAllBranchManagers()
    {
        $this->db->query('SELECT bm.branchmanager_id, bm.branch_id, bm.branchmanager_name, bm.address, bm.contact_number, u.email, u.password, b.branch_name 
                          FROM branchmanager bm 
                          JOIN users u ON bm.user_id = u.id
                          JOIN branch b ON bm.branch_id = b.branch_id');
        return $this->db->resultSet();
    }
    public function getBranchManagerById($id)
    {
        $this->db->query('SELECT bm.branchmanager_id, bm.user_id, bm.branch_id, bm.branchmanager_name, bm.address, bm.contact_number, u.email, u.password 
                          FROM branchmanager bm 
                          JOIN users u ON bm.user_id = u.id 
                          WHERE bm.branchmanager_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getAllBranches()
    {
        $this->db->query('SELECT branch_id, branch_name FROM branch');
        return $this->db->resultSet();
    }

    public function addBranchManager($data)
    {
        // Insert into users table
        $this->db->query('INSERT INTO users (email, password, user_role, created_at) 
                        VALUES (:email, :password, :user_role, NOW())');

        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':user_role', 'branchmanager');

        if ($this->db->execute()) {
            $user_id = $this->db->lastInsertId();

            // Insert into branchmanager table
            $this->db->query('INSERT INTO branchmanager (user_id, branch_id, branchmanager_name, address, contact_number) 
                            VALUES (:user_id, :branch_id, :branchmanager_name, :address, :contact_number)');

            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':branch_id', $data['branch_id']);
            $this->db->bind(':branchmanager_name', $data['branchmanager_name']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':contact_number', $data['contact_number']);

            return $this->db->execute();
        }
        return false;
    }


    public function updateBranchManager($data)
    {
        // Update branchmanager table
        $this->db->query('UPDATE branchmanager SET 
                          branch_id = :branch_id, 
                          branchmanager_name = :branchmanager_name, 
                          address = :address, 
                          contact_number = :contact_number 
                          WHERE branchmanager_id = :id');

        $this->db->bind(':id', $data['branchmanager_id']);
        $this->db->bind(':branch_id', $data['branch_id']);
        $this->db->bind(':branchmanager_name', $data['branchmanager_name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':contact_number', $data['contact_number']);

        $result1 = $this->db->execute();

        // Update users table
        $this->db->query('UPDATE users SET email = :email, password = :password WHERE id = :user_id');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));

        $result2 = $this->db->execute();

        return ($result1 && $result2);
    }

    public function deleteBranchManager($data)
    {
        // Get user_id before deletion
        $this->db->query('SELECT user_id FROM branchmanager WHERE branchmanager_id = :id');
        $this->db->bind(':id', $data['branchmanager_id']);
        $branchManager = $this->db->single();

        // Delete from branchmanager table
        $this->db->query('DELETE FROM branchmanager WHERE branchmanager_id = :id');
        $this->db->bind(':id', $data['branchmanager_id']);
        $result1 = $this->db->execute();

        // Delete from users table
        $this->db->query('DELETE FROM users WHERE id = :user_id');
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
}
?>