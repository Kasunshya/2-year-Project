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
        $this->db->query('SELECT product_id, product_name, category, quantity, price FROM product');
        return $this->db->resultSet();
    }

    public function addProduct($data) {
        $this->db->query('INSERT INTO product (product_name, category, quantity, price) VALUES (:product_name, :category, :quantity, :price)');
        
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);

        return $this->db->execute();
    }

    public function updateProduct($data) {
        $this->db->query('UPDATE product SET product_name = :product_name, category = :category, quantity = :quantity, price = :price WHERE product_id = :id');
        
        $this->db->bind(':id', $data['product_id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);

        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM product WHERE product_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // User Management Methods
    public function getAllUsers() {
        $this->db->query('SELECT employee_id, full_name, address, contact_no, user_role FROM employee');
        return $this->db->resultSet();
    }

    public function addUser($data) {
        $this->db->query('INSERT INTO employee (full_name, address, contact_no, user_role) VALUES (:full_name, :address, :contact_no, :user_role)');
        
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':contact_no', $data['contact_no']);
        $this->db->bind(':user_role', $data['user_role']);

        return $this->db->execute();
    }

    public function updateUser($data) {
        $this->db->query('UPDATE employee SET full_name = :full_name, address = :address, contact_no = :contact_no, user_role = :user_role WHERE employee_id = :id');
        
        $this->db->bind(':id', $data['employee_id']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':contact_no', $data['contact_no']);
        $this->db->bind(':user_role', $data['user_role']);

        return $this->db->execute();
    }

    public function deleteUser($id) {
        $this->db->query('DELETE FROM employee WHERE employee_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
