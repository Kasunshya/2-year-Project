<?php
class M_Cashier {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCashiers() {
        $this->db->query('SELECT * FROM cashier');
        $result = $this->db->resultSet();
        return $result;
    }

    public function addCashier($data) {
        $this->db->query('INSERT INTO cashier (Name, Contact, Address, Email, Join_Date, Password) VALUES (:name, :contact, :address, :email, :joindate, :password)');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':contact', $data['contact']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':joindate', $data['joindate']);
        $this->db->bind(':password', $data['password']);

        return $this->db->execute();
    }

    public function updateCashier($data) {
        $this->db->query('UPDATE cashier SET Name = :name, Contact = :contact, Address = :address, Email = :email, Join_Date = :joindate, Password = :password WHERE ID = :id');
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':contact', $data['contact']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':joindate', $data['joindate']);
        $this->db->bind(':password', $data['password']);

        return $this->db->execute();
    }

    public function deleteCashier($id) {
        $this->db->query('DELETE FROM cashier WHERE ID = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
