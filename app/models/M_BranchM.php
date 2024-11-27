<?php
 class M_BranchM{
     private $db;

     public function __construct(){
         $this->db = new Database();
     }
     public function addCashier($data){
         $this->db->query('INSERT INTO cashier (Name, Contact, Address, Email, Join_Date, Password) VALUES(:Name, :Contact, :Address, :Email, :Join_Date, :Password)');
         $this->db->bind(':Name', $data['Name']);
         $this->db->bind(':Contact', $data['Contact']);
         $this->db->bind(':Address', $data['Address']);
         $this->db->bind(':Email', $data['Email']);
         $this->db->bind(':Join_Date', $data['Join_Date']);
         $this->db->bind(':Password', $data['Password']);

         //execute query
         if($this->db->execute()){
             return true;
         } else {
             return false;
         }
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
    $this->db->query('SELECT * FROM cashier WHERE ID = :id');
    $this->db->bind(':id', $id);
    return $this->db->single(); // Return the row as an object
}
    public function updateCashier($data) {
        $this->db->query('UPDATE cashier SET Name = :Name, Contact = :Contact, Address = :Address, Email = :Email, Join_Date = :Join_Date, Password = :Password WHERE ID = :ID');
        
        // Bind the parameters
        $this->db->bind(':ID', $data['ID']);
        $this->db->bind(':Name', $data['Name']);
        $this->db->bind(':Contact', $data['Contact']);
        $this->db->bind(':Address', $data['Address']);
        $this->db->bind(':Email', $data['Email']);
        $this->db->bind(':Join_Date', $data['Join_Date']);
        $this->db->bind(':Password', $data['Password']);
    
        // Execute the query
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }public function deleteCashierById($id) {
        $this->db->query('DELETE FROM cashier WHERE ID = :id');
        $this->db->bind(':id', $id);
    
        // Execute the query and return true if it is successful
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getSalesData() {
        
    
        // Return the result set (array of sales data)
        return $this->db->resultSet();
    }
    
    
    
 }
?>