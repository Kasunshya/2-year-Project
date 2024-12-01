<?php
class M_Inventory
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Add Inventory
    public function addinventory($data)
    {
        $this->db->query('INSERT INTO inventory (name, quantity_available, Expiry_date, Price_per_kg) 
                          VALUES(:name, :quantity_available, :Expiry_date, :Price_per_kg)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':quantity_available', $data['quantity_available']);
        $this->db->bind(':Expiry_date', $data['Expiry_date']);
        $this->db->bind(':Price_per_kg', $data['Price_per_kg']);

        // Execute query
        return $this->db->execute();
    }

    // Update Inventory
    public function updateInventory($data)
    {
        $this->db->query('UPDATE inventory 
                      SET name = :name, 
                          quantity_available = :quantity_available, 
                          Price_per_kg = :Price_per_kg, 
                          Expiry_date = :Expiry_date 
                      WHERE inventory_id = :inventory_id');

        // Bind values
        $this->db->bind(':inventory_id', $data['inventory_id']);
        $this->db->bind(':name', $data['update_inventory_name']);
        $this->db->bind(':quantity_available', $data['update_quantity']);
        $this->db->bind(':Price_per_kg', $data['update_price']);
        $this->db->bind(':Expiry_date', $data['update_expiry_date']);

        // Execute query
        return $this->db->execute();
    }


    // Delete Inventory
    public function deleteInventory($inventory_id)
    {
        $this->db->query('DELETE FROM inventory WHERE inventory_id = :inventory_id');

        // Bind the inventory_id
        $this->db->bind(':inventory_id', $inventory_id);

        // Execute the query
        return $this->db->execute();
    }


    // View Inventory
    public function getInventory()
    {
        $this->db->query('SELECT * FROM inventory');

        // Execute and fetch results
        return $this->db->resultSet();
    }

    public function getInventoryStorageStats()
    {
        $this->db->query('SELECT 
                        SUM(CASE WHEN quantity_available < 50 THEN 1 ELSE 0 END) AS low_storage,
                        SUM(CASE WHEN quantity_available >= 50 THEN 1 ELSE 0 END) AS sufficient_storage
                      FROM inventory');

        // Execute and fetch single row
        return $this->db->single();
    }


}
?>