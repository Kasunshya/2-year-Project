<?php
class M_Employee {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getEmployeeById($employeeId) {
        $this->db->query('SELECT e.*, b.branch_name, b.branch_address 
                         FROM employee e 
                         LEFT JOIN branch b ON e.branch = b.branch_name 
                         WHERE e.employee_id = :employee_id');
        $this->db->bind(':employee_id', $employeeId);
        return $this->db->single();
    }

    public function getBranchManagerDetails($userId) {
        $this->db->query('SELECT e.*, b.branch_name, b.branch_address, b.branch_contact,
                         bm.branchmanager_id, bm.branch_id
                         FROM employee e
                         LEFT JOIN branchmanager bm ON e.employee_id = bm.employee_id
                         LEFT JOIN branch b ON bm.branch_id = b.branch_id
                         WHERE e.user_id = :user_id AND e.user_role = "branchmanager"');
                         
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        
        if ($result) {
            // Log successful fetch
            error_log("Successfully fetched branch manager details for user_id: " . $userId);
        } else {
            // Log failure
            error_log("Failed to fetch branch manager details for user_id: " . $userId);
        }
        
        return $result;
    }

    public function updateProfile($userId, $data) {
        try {
            // Start transaction
            $this->db->beginTransaction();

            // Update employee table
            $this->db->query('UPDATE employee SET 
                             contact_no = :contact_no,
                             email = :email,
                             address = :address
                             WHERE user_id = :user_id');

            $this->db->bind(':contact_no', $data['contact_no']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':user_id', $userId);

            $this->db->execute();

            // Update users table email
            $this->db->query('UPDATE users SET email = :email WHERE user_id = :user_id');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':user_id', $userId);

            $this->db->execute();

            // Commit transaction
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollBack();
            error_log('Error updating profile: ' . $e->getMessage());
            return false;
        }
    }

    public function getEmployeesByBranch($branchId) {
        $this->db->query('SELECT e.* 
                         FROM employee e 
                         JOIN branch b ON e.branch = b.branch_name 
                         WHERE b.branch_id = :branch_id');
        $this->db->bind(':branch_id', $branchId);
        return $this->db->resultSet();
    }

    public function getAllEmployees() {
        $this->db->query('SELECT e.*, b.branch_name 
                         FROM employee e 
                         LEFT JOIN branch b ON e.branch = b.branch_name 
                         ORDER BY e.full_name');
        return $this->db->resultSet();
    }
}
?>
