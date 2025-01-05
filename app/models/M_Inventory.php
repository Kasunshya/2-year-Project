<?php
class M_Inventory {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getInventory() {
        $this->db->query('SELECT * FROM inventory');
        return $this->db->resultSet();
    }

    public function getInventoryById($id) {
        $this->db->query('SELECT * FROM inventory WHERE inventory_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addInventory($data) {
        $this->db->query('INSERT INTO inventory (name, quantity_available, Expiry_date, Price_per_kg) 
                          VALUES (:name, :quantity_available, :Expiry_date, :Price_per_kg)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':quantity_available', $data['quantity_available']);
        $this->db->bind(':Expiry_date', $data['Expiry_date']);
        $this->db->bind(':Price_per_kg', $data['Price_per_kg']);
    
        if ($this->db->execute()) {
            return true;
        } else {
            error_log('Database Error: ' . print_r($this->db->errorInfo(), true)); // Log detailed error
            return false;
        }
    }
        

    public function updateInventory($data) {
        $this->db->query('UPDATE inventory 
                          SET name = :name, 
                              quantity_available = :quantity, 
                              Price_per_kg = :price, 
                              Expiry_date = :expiry_date 
                          WHERE inventory_id = :id');
        $this->db->bind(':id', $data['inventory_id']);
        $this->db->bind(':name', $data['update_inventory_name']);
        $this->db->bind(':quantity', $data['update_quantity']);
        $this->db->bind(':price', $data['update_price']);
        $this->db->bind(':expiry_date', $data['update_expiry_date']);
        return $this->db->execute();
    }

    public function deleteInventory($inventory_id) {
        $this->db->query('DELETE FROM inventory WHERE inventory_id = :inventory_id');
        $this->db->bind(':inventory_id', $inventory_id);
        return $this->db->execute();
}
}
