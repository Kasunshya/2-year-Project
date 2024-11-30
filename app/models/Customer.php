<?php
class Customer {
  private $db;

     public function __construct(){
         $this->db = new Database();
     }
    public function createCustomer($customerName, $userId) {
        $this->db->query('INSERT INTO customer (customer_name, id) VALUES (:customer_name, :user_id)');
        $this->db->bind(':customer_name', $customerName);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute(); // Returns true on success
    }
}
