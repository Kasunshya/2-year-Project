<?php
class Customer {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createCustomer($name, $userId, $contactNumber = null, $address = null) {
        // Debug logging
        error_log("Creating customer with name: $name, userId: $userId, contactNumber: $contactNumber, address: $address");
        
        // Insert into customer table (not customers)
        $this->db->query('INSERT INTO customer (customer_name, user_id, customer_contact, customer_address) 
                          VALUES (:name, :user_id, :contact, :address)');
        
        $this->db->bind(':name', $name);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':contact', $contactNumber);
        $this->db->bind(':address', $address);

        // Execute and log result
        $result = $this->db->execute();
        error_log("Customer creation result: " . ($result ? "Success" : "Failed"));
        
        return $result;
    }

    // You can add more customer-related methods here
    public function getCustomerById($id) {
        $this->db->query('SELECT * FROM customer WHERE customer_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    public function getCustomerByUserId($userId) {
        $this->db->query('SELECT * FROM customer WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }
}