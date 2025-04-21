<?php
class M_SysAdminP {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCategories() {
        $this->db->query('SELECT * FROM category ORDER BY category_id DESC');
        return $this->db->resultSet();
    }

    public function addCategory($data) {
        $this->db->query('INSERT INTO category (name, description) VALUES (:name, :description)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }

    public function updateCategory($data) {
        $this->db->query('UPDATE category SET name = :name, description = :description WHERE category_id = :category_id');
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }

    public function deleteCategory($id) {
        $this->db->query('DELETE FROM category WHERE category_id = :category_id');
        $this->db->bind(':category_id', $id);

        return $this->db->execute();
    }

    public function getCategoryById($id) {
        $this->db->query('SELECT * FROM category WHERE category_id = :category_id');
        $this->db->bind(':category_id', $id);

        return $this->db->single();
    }

    // Product Methods
    public function getAllProducts() {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         ORDER BY p.product_id DESC');
        return $this->db->resultSet();
    }

    public function addProduct($data, $image_path = null) {
        $this->db->query('INSERT INTO product (product_name, description, price, 
                         available_quantity, category_id, image_path, expiry_date) 
                         VALUES (:name, :description, :price, :quantity, :category_id, :image_path, :expiry_date)');
        
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['available_quantity']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':image_path', $image_path);
        $this->db->bind(':expiry_date', $data['expiry_date']);

        return $this->db->execute();
    }

    public function updateProduct($data, $image_path = null) {
        $sql = 'UPDATE product SET 
                product_name = :name, 
                description = :description, 
                price = :price, 
                available_quantity = :quantity, 
                category_id = :category_id,
                expiry_date = :expiry_date';
        
        if ($image_path !== null) {
            $sql .= ', image_path = :image_path';
        }
        
        $sql .= ' WHERE product_id = :product_id';
        
        $this->db->query($sql);

        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['available_quantity']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':expiry_date', $data['expiry_date']);
        
        if ($image_path !== null) {
            $this->db->bind(':image_path', $image_path);
        }

        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM product WHERE product_id = :product_id');
        $this->db->bind(':product_id', $id);
        return $this->db->execute();
    }

    public function getProductById($id) {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         WHERE p.product_id = :product_id');
        $this->db->bind(':product_id', $id);

        return $this->db->single();
    }

    public function searchProducts($term) {
        $this->db->query('SELECT p.*, c.name as category_name 
                          FROM product p 
                          LEFT JOIN category c ON p.category_id = c.category_id 
                          WHERE p.product_name LIKE :term 
                          OR p.description LIKE :term 
                          OR c.name LIKE :term 
                          ORDER BY p.product_id DESC');
        
        $searchTerm = "%{$term}%";
        $this->db->bind(':term', $searchTerm);
        
        return $this->db->resultSet();
    }

    public function updateExpiredProducts() {
        $this->db->query('UPDATE product 
                          SET status = 0 
                          WHERE expiry_date IS NOT NULL 
                          AND expiry_date <= NOW() 
                          AND status = 1');
        return $this->db->execute();
    }

    // Branch Management Methods
    public function getAllBranches() {
        $this->db->query('SELECT * FROM branch ORDER BY branch_id DESC');
        return $this->db->resultSet();
    }

    public function addBranch($data) {
        $this->db->query('INSERT INTO branch (branch_name, branch_address, branch_contact) 
                         VALUES (:branch_name, :branch_address, :branch_contact)');
        
        $this->db->bind(':branch_name', $data['branch_name']);
        $this->db->bind(':branch_address', $data['branch_address']);
        $this->db->bind(':branch_contact', $data['branch_contact']);

        return $this->db->execute();
    }

    public function updateBranch($data) {
        $this->db->query('UPDATE branch SET 
                         branch_name = :branch_name, 
                         branch_address = :branch_address, 
                         branch_contact = :branch_contact 
                         WHERE branch_id = :branch_id');
        
        $this->db->bind(':branch_id', $data['branch_id']);
        $this->db->bind(':branch_name', $data['branch_name']);
        $this->db->bind(':branch_address', $data['branch_address']);
        $this->db->bind(':branch_contact', $data['branch_contact']);

        return $this->db->execute();
    }

    public function deleteBranch($id) {
        $this->db->query('DELETE FROM branch WHERE branch_id = :branch_id');
        $this->db->bind(':branch_id', $id);
        return $this->db->execute();
    }

    public function getBranchById($id) {
        $this->db->query('SELECT * FROM branch WHERE branch_id = :branch_id');
        $this->db->bind(':branch_id', $id);
        return $this->db->single();
    }

    public function getAllCustomers() {
        $this->db->query('SELECT c.*, u.email 
                          FROM customer c 
                          LEFT JOIN users u ON c.user_id = u.user_id 
                          ORDER BY c.customer_id DESC');
        return $this->db->resultSet();
    }
}
?>