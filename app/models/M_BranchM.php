<?php
 class M_BranchM{
     private $db;

     public function __construct(){
         $this->db = new Database();
     }
    
     public function DailyOrder($data) {
        $this->db->query('INSERT INTO dailybranchorder (branchid, branchname, date, orderdescription) VALUES (:branchid, :branchname, :date, :orderdescription)');
        // Bind values
        $this->db->bind(':branchid', $data['branchid']);
        $this->db->bind(':branchname', $data['branchname']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':orderdescription', $data['orderdescription']);
    
        //execute query
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
    //read data from databse
    public function getCashiers() {
        $this->db->query('SELECT * FROM cashier');
        return $this->db->resultSet();  // Returns an array of all cashiers
    }

    // Fetch a single cashier by ID
    public function getCashierById($id) {
    $this->db->query('SELECT * FROM cashier WHERE cashier_id = :id');
    $this->db->bind(':id', $id);
    return $this->db->single(); // Return the row as an object
}

    public function getSalesData() {
        
    
        // Return the result set (array of sales data)
        return $this->db->resultSet();
    }
    // Update cashier data
    public function updateCashier($data) {
        $this->db->query("UPDATE cashier 
                          SET address = :address, 
                             cashier_name = :cashier_name,
                              contacts = :contacts, 
                              join_date = :join_date, 
                              branch_name = :branch_name 
                          WHERE cashier_id = :cashier_id");
        $this->db->bind(':cashier_id', $data['cashier_id']);  // Use cashier_id for identifying the row
        $this->db->bind(':cashier_name', $data['cashier_name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':contacts', $data['contacts']);
        $this->db->bind(':join_date', $data['join_date']);
        $this->db->bind(':branch_name', $data['branch_name']);

        return $this->db->execute();  // Execute the query
    }
    

}
?>