<?php
 class M_Cashier{
     private $db;

     public function __construct(){
         $this->db = new Database();
     }
     public function addCashier($data) {
        $this->db->query("INSERT INTO cashier (id, cashier_name, contacts, address, join_date, branch_name) 
                          VALUES (:id, :cashier_name, :contacts, :address, :join_date, :branch_name)");
        $this->db->bind(':id', $data['id']); // Use id from users table
        $this->db->bind(':cashier_name', $data['cashier_name']);
        $this->db->bind(':contacts', $data['contacts']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':join_date', $data['join_date']);
        $this->db->bind(':branch_name', $data['branch_name']);

        return $this->db->execute(); // Return true if successful
}
/*public function deleteCashierById($cashierId)
{
    $this->db->query('DELETE FROM cashier WHERE cashier_id = :cashier_id');
    $this->db->bind(':cashier_id', $cashierId);

    // Execute the query
    return $this->db->execute();
}*/



/*public function updateCashier($data) {
    $this->db->query("UPDATE cashier 
                      SET address = :address, 
                          contacts = :contacts, 
                          join_date = :join_date, 
                          branch_name = :branch_name 
                      WHERE cashier_name = :cashier_name");
    $this->db->bind(':cashier_name', $data['cashier_name']); // Assuming cashier_name is unique
    $this->db->bind(':address', $data['address']);
    $this->db->bind(':contacts', $data['contacts']);
    $this->db->bind(':join_date', $data['join_date']);
    $this->db->bind(':branch_name', $data['branch_name']);

    return $this->db->execute();
}*/

public function getCashiers() {
    $this->db->query("SELECT cashier_id, cashier_name, address, contacts, join_date, branch_name 
                      FROM cashier");
    return $this->db->resultSet(); // Fetch all results as an array of objects
}
// Fetch a specific cashier by their ID
public function getCashierById($cashierId) {
    $this->db->query("SELECT * FROM cashier WHERE cashier_id = :cashier_id");
    $this->db->bind(':cashier_id', $cashierId);
    return $this->db->single(); // Fetch single row
}

public function deleteCashier($cashier_id) {
    // Prepare the SQL statement
    $sql = "DELETE FROM cashier WHERE cashier_id = :cashier_id";

    // Call the query method to prepare the statement
    $this->db->query($sql);

    // Bind the cashier_id parameter
    $this->db->bind(':cashier_id', $cashier_id, PDO::PARAM_INT);

    // Execute the query and return the result
    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}

}
?>
