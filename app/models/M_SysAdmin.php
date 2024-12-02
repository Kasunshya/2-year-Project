<?php
class M_SysAdmin {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Customer Management Methods
    public function getAllCustomers() {
        $this->db->query('SELECT customer_id, full_name, address, contact_no, email FROM customer');
        return $this->db->resultSet();
    }

    public function addCustomer($data) {
        $this->db->query('INSERT INTO customer (full_name, address, contact_no, email) VALUES (:full_name, :address, :contact_no, :email)');
        
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':contact_no', $data['contact_no']);
        $this->db->bind(':email', $data['email']);

        return $this->db->execute();
    }

    public function updateCustomer($data) {
        $this->db->query('UPDATE customer SET full_name = :full_name, address = :address, contact_no = :contact_no, email = :email WHERE customer_id = :id');
        
        $this->db->bind(':id', $data['customer_id']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':contact_no', $data['contact_no']);
        $this->db->bind(':email', $data['email']);

        return $this->db->execute();
    }

    public function deleteCustomer($id) {
        $this->db->query('DELETE FROM customer WHERE customer_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Product Management Methods
    public function getAllProducts() {
        $this->db->query('SELECT product_id, product_name, price, quantity, star_rating, created_at FROM product');
        return $this->db->resultSet();
    }

    public function addProduct($data) {
        $this->db->query('INSERT INTO product (product_name, price, quantity) VALUES (:product_name, :price, :quantity)');
        
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);

        return $this->db->execute();
    }

    public function updateProduct($data) {
        $this->db->query('UPDATE product SET product_name = :product_name, price = :price, quantity = :quantity WHERE product_id = :id');
        
        $this->db->bind(':id', $data['product_id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);

        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM product WHERE product_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // User Management Methods
    public function getAllUsers() {
        $this->db->query('SELECT id, email, password, created_at, user_role FROM users');
        return $this->db->resultSet();
    }
    
    public function addUser($data) {
        $this->db->query('INSERT INTO users (email, password, user_role) VALUES (:email, :password, :user_role)');
        
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':user_role', $data['user_role']);
    
        return $this->db->execute();
    }
    
    public function updateUser($data) {
        $passwordQuery = $data['password'] ? ', password = :password' : '';
        $this->db->query('UPDATE users SET email = :email, user_role = :user_role' . $passwordQuery . ' WHERE id = :id');
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':user_role', $data['user_role']);
        
        if ($data['password']) {
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        }
    
        return $this->db->execute();
    }
    
    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
