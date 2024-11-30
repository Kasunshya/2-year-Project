<?php
class M_Customer {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllCustomers() {
        $this->db->query("SELECT * FROM customers");
        return $this->db->resultSet();
    }

    public function addCustomer($data) {
        $this->db->query("INSERT INTO customers (full_name, address, contact_no) VALUES (:full_name, :address, :contact_no)");
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':contact_no', $data['contact_no']);

        return $this->db->execute();
    }

    public function deleteCustomer($id) {
        $this->db->query("DELETE FROM customers WHERE customer_id = :customer_id");
        $this->db->bind(':customer_id', $id);

        return $this->db->execute();
    }
}
?>
