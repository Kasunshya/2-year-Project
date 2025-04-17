<?php
if (!class_exists('M_SysAdmin')) {
    class M_SysAdmin
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }
      
        // Customer Management Methods
        public function getAllCustomers()
        {
            $this->db->query('SELECT customer_id, full_name, address, contact_no, email FROM customer');
            return $this->db->resultSet();
        }

        public function addCustomer($data)
        {
            $this->db->query('INSERT INTO customer (full_name, address, contact_no, email) VALUES (:full_name, :address, :contact_no, :email)');

            $this->db->bind(':full_name', $data['full_name']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':contact_no', $data['contact_no']);
            $this->db->bind(':email', $data['email']);

            return $this->db->execute();
        }

        public function updateCustomer($data)
        {
            $this->db->query('UPDATE customer SET full_name = :full_name, address = :address, contact_no = :contact_no, email = :email WHERE customer_id = :id');

            $this->db->bind(':id', $data['customer_id']);
            $this->db->bind(':full_name', $data['full_name']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':contact_no', $data['contact_no']);
            $this->db->bind(':email', $data['email']);

            return $this->db->execute();
        }

        public function deleteCustomer($id)
        {
            $this->db->query('DELETE FROM customer WHERE customer_id = :id');
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }

        // Product Management Methods
        public function getAllProducts()
        {
            $this->db->query('SELECT product_id, product_name, price, quantity, star_rating, created_at FROM product');
            return $this->db->resultSet();
        }

        public function addProduct($data)
        {
            $this->db->query('INSERT INTO product (product_name, price, quantity) VALUES (:product_name, :price, :quantity)');

            $this->db->bind(':product_name', $data['product_name']);
            $this->db->bind(':price', $data['price']);
            $this->db->bind(':quantity', $data['quantity']);

            return $this->db->execute();
        }

        public function updateProduct($data)
        {
            $this->db->query('UPDATE product SET product_name = :product_name, price = :price, quantity = :quantity WHERE product_id = :id');

            $this->db->bind(':id', $data['product_id']);
            $this->db->bind(':product_name', $data['product_name']);
            $this->db->bind(':price', $data['price']);
            $this->db->bind(':quantity', $data['quantity']);

            return $this->db->execute();
        }

        public function deleteProduct($id)
        {
            $this->db->query('DELETE FROM product WHERE product_id = :id');
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }

        // User Management Methods
        public function getAllUsers()
        {
            $this->db->query('SELECT id, email, password, created_at, user_role FROM users');
            return $this->db->resultSet();
        }

        public function addUser($data)
        {
            $this->db->query('INSERT INTO users (email, password, user_role) VALUES (:email, :password, :user_role)');

            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            $this->db->bind(':user_role', $data['user_role']);

            return $this->db->execute();
        }

        public function updateUser($data)
        {
            $this->db->query('UPDATE users SET email = :email, user_role = :user_role WHERE user_id = :user_id');

            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':user_role', $data['user_role']);

            return $this->db->execute();
        }

        public function deleteUser($user_id)
        {
            $this->db->query('DELETE FROM users WHERE user_id = :user_id');
            $this->db->bind(':user_id', $user_id);
            return $this->db->execute();
        }

        // Employee Management Methods
        public function getAllEmployees()
        {
            $this->db->query('SELECT employee_id, full_name, address, contact_no, nic, dob, gender, email, join_date, cv_upload, branch, user_id, user_role FROM employee');
            return $this->db->resultSet();
        }

        public function addEmployee($data) {
            $this->db->query('INSERT INTO employee (full_name, address, contact_no, nic, dob, gender, email, join_date, cv_upload, branch, user_id, user_role) 
                              VALUES (:full_name, :address, :contact_no, :nic, :dob, :gender, :email, :join_date, :cv_upload, :branch, :user_id, :user_role)');

            $this->db->bind(':full_name', $data['full_name']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':contact_no', $data['contact_no']);
            $this->db->bind(':nic', $data['nic']);
            $this->db->bind(':dob', $data['dob']);
            $this->db->bind(':gender', $data['gender']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':join_date', $data['join_date']);
            $this->db->bind(':cv_upload', $data['cv_upload']); // Save only the file name
            $this->db->bind(':branch', $data['branch']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':user_role', $data['user_role']);

            return $this->db->execute();
        }

        public function getUserByEmail($email)
        {
            $this->db->query('SELECT user_id FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            return $this->db->single();
        }

        public function getEmployeeById($employee_id)
        {
            $this->db->query('SELECT * FROM employee WHERE employee_id = :employee_id');
            $this->db->bind(':employee_id', $employee_id);
            return $this->db->single();
        }

        public function updateEmployee($data) {
            $this->db->query('UPDATE employee SET 
                              full_name = :full_name, 
                              address = :address, 
                              contact_no = :contact_no, 
                              nic = :nic, 
                              dob = :dob, 
                              gender = :gender, 
                              email = :email, 
                              join_date = :join_date, 
                              cv_upload = :cv_upload, 
                              branch = :branch, 
                              user_role = :user_role 
                              WHERE employee_id = :employee_id');

            $this->db->bind(':employee_id', $data['employee_id']);
            $this->db->bind(':full_name', $data['full_name']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':contact_no', $data['contact_no']);
            $this->db->bind(':nic', $data['nic']);
            $this->db->bind(':dob', $data['dob']);
            $this->db->bind(':gender', $data['gender']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':join_date', $data['join_date']);
            $this->db->bind(':cv_upload', $data['cv_upload']);
            $this->db->bind(':branch', $data['branch']);
            $this->db->bind(':user_role', $data['user_role']);

            $result1 = $this->db->execute();

            // Update related table based on user_role
            if ($data['user_role'] === 'cashier') {
                $this->db->query('UPDATE cashier SET 
                                  branch_id = :branch_id 
                                  WHERE employee_id = :employee_id');
                $this->db->bind(':branch_id', $data['branch_id']);
                $this->db->bind(':employee_id', $data['employee_id']);
                $result2 = $this->db->execute();
                return $result1 && $result2;
            } elseif ($data['user_role'] === 'branchmanager') {
                $this->db->query('UPDATE branchmanager SET 
                                  branch_id = :branch_id 
                                  WHERE employee_id = :employee_id');
                $this->db->bind(':branch_id', $data['branch_id']);
                $this->db->bind(':employee_id', $data['employee_id']);
                $result2 = $this->db->execute();
                return $result1 && $result2;
            }

            return $result1;
        }

        public function deleteEmployee($id)
        {
            // Check if the employee is a cashier
            $this->db->query('SELECT user_role FROM employee WHERE employee_id = :id');
            $this->db->bind(':id', $id);
            $employee = $this->db->single();

            if ($employee && $employee->user_role === 'cashier') {
                // Delete from the cashier table
                $this->db->query('DELETE FROM cashier WHERE employee_id = :id');
                $this->db->bind(':id', $id);
                $this->db->execute();
            }

            // Delete from the employee table
            $this->db->query('DELETE FROM employee WHERE employee_id = :id');
            $this->db->bind(':id', $id);
            return $this->db->execute();
        }

        public function addCashier($data) {
            $this->db->query('INSERT INTO cashier (employee_id, user_id, branch_id) 
                              VALUES (:employee_id, :user_id, :branch_id)');
            $this->db->bind(':employee_id', $data['employee_id']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':branch_id', $data['branch_id']);
            return $this->db->execute();
        }

        public function updateCashier($data) {
            $this->db->query('UPDATE cashier SET branch_id = :branch_id WHERE employee_id = :employee_id');
            $this->db->bind(':branch_id', $data['branch_id']);
            $this->db->bind(':employee_id', $data['employee_id']);
            return $this->db->execute();
        }

        public function deleteCashier($employee_id) {
            $this->db->query('DELETE FROM cashier WHERE employee_id = :employee_id');
            $this->db->bind(':employee_id', $employee_id);
            return $this->db->execute();
        }

        public function addBranchManager($data) {
            $this->db->query('INSERT INTO branchmanager (employee_id, user_id, branch_id) 
                              VALUES (:employee_id, :user_id, :branch_id)');
            $this->db->bind(':employee_id', $data['employee_id']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':branch_id', $data['branch_id']);
            return $this->db->execute();
        }

        public function updateBranchManager($data) {
            $this->db->query('UPDATE branchmanager SET 
                              branch_id = :branch_id 
                              WHERE employee_id = :employee_id');
            $this->db->bind(':branch_id', $data['branch_id']);
            $this->db->bind(':employee_id', $data['employee_id']);
            return $this->db->execute();
        }

        public function addHeadManager($data) {
            $this->db->query('INSERT INTO headmanager (employee_id, user_id, branch_id) 
                              VALUES (:employee_id, :user_id, :branch_id)');
            $this->db->bind(':employee_id', $data['employee_id']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':branch_id', $data['branch_id']);
            return $this->db->execute();
        }

        public function updateHeadManager($data) {
            $this->db->query('UPDATE headmanager SET 
                              branch_id = :branch_id 
                              WHERE employee_id = :employee_id');
            $this->db->bind(':branch_id', $data['branch_id']);
            $this->db->bind(':employee_id', $data['employee_id']);
            return $this->db->execute();
        }

        public function deleteHeadManager($employee_id) {
            $this->db->query('DELETE FROM headmanager WHERE employee_id = :employee_id');
            $this->db->bind(':employee_id', $employee_id);
            return $this->db->execute();
        }
    }

}
?>