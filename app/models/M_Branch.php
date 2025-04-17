<?php
class M_Branch {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllBranches() {
        $this->db->query('SELECT * FROM branch ORDER BY branch_id ASC');
        return $this->db->resultSet();
    }

    public function addBranch($data) {
        $this->db->query('INSERT INTO branch (branch_name, branch_address, branch_contact) 
                          VALUES (:branch_name, :branch_address, :branch_contact)');
        
        // Bind values
        $this->db->bind(':branch_name', $data['branch_name']);
        $this->db->bind(':branch_address', $data['branch_address']);
        $this->db->bind(':branch_contact', $data['branch_contact']);

        // Execute
        return $this->db->execute();
    }

    public function updateBranch($data) {
        $this->db->query('UPDATE branch 
                          SET branch_name = :branch_name, 
                              branch_address = :branch_address, 
                              branch_contact = :branch_contact 
                          WHERE branch_id = :branch_id');
        
        // Bind values
        $this->db->bind(':branch_id', $data['branch_id']);
        $this->db->bind(':branch_name', $data['branch_name']);
        $this->db->bind(':branch_address', $data['branch_address']);
        $this->db->bind(':branch_contact', $data['branch_contact']);

        // Execute
        return $this->db->execute();
    }

    public function deleteBranch($id) {
        $this->db->query('DELETE FROM branch WHERE branch_id = :branch_id');
        $this->db->bind(':branch_id', $id);
        return $this->db->execute();
    }

    public function searchBranches($searchTerm) {
        $this->db->query('SELECT * FROM branch WHERE branch_name LIKE :search ORDER BY branch_id ASC');
        $this->db->bind(':search', '%' . $searchTerm . '%');
        return $this->db->resultSet();
    }
   
}
?>