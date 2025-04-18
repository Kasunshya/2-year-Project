<?php
class M_Profile {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getEmployeeByUserId($userId) {
        $this->db->query('SELECT e.*, u.email as user_email 
                         FROM employee e 
                         LEFT JOIN users u ON e.user_id = u.user_id 
                         WHERE e.user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    public function updateEmployee($data) {
        $this->db->query('UPDATE employee SET 
                         contact_no = :contact_no,
                         email = :email,
                         address = :address
                         WHERE user_id = :user_id');

        // Bind values
        $this->db->bind(':contact_no', $data['contact_no']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':user_id', $data['user_id']);

        // Execute
        if($this->db->execute()) {
            // Also update email in users table
            $this->db->query('UPDATE users SET email = :email WHERE user_id = :user_id');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':user_id', $data['user_id']);
            return $this->db->execute();
        }

        return false;
    }

    public function updatePassword($data) {
        // First verify current password
        $this->db->query('SELECT password FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $data['user_id']);
        $row = $this->db->single();

        if(password_verify($data['current_password'], $row->password)) {
            // If current password matches, update to new password
            $this->db->query('UPDATE users SET password = :password WHERE user_id = :user_id');
            $this->db->bind(':password', password_hash($data['new_password'], PASSWORD_DEFAULT));
            $this->db->bind(':user_id', $data['user_id']);
            return $this->db->execute();
        }

        return false;
    }
}
