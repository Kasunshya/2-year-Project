<?php
class M_Branch {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function addBranch($data) {
        $this->db->query("INSERT INTO branch (branch_name, branch_address, branch_contact) VALUES (:branch_name, :branch_address, :branch_contact)");
        $this->db->bind(':branch_name', $data['branch_name']);
        $this->db->bind(':branch_address', $data['branch_address']);
        $this->db->bind(':branch_contact', $data['branch_contact']);
        return $this->db->execute();
    }
}
?>
