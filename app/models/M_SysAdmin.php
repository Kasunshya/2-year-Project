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
            $this->db->query('
                SELECT 
                    e.employee_id, 
                    e.full_name, 
                    e.address, 
                    e.contact_no, 
                    e.nic, 
                    e.dob, 
                    e.gender, 
                    e.email, 
                    e.join_date, 
                    e.cv_upload, 
                    e.user_id, 
                    e.user_role,
                    b.branch_name AS branch_name
                FROM 
                    employee e
                LEFT JOIN 
                    branch b ON e.branch = b.branch_id
                ORDER BY 
                    e.employee_id DESC
            ');
            return $this->db->resultSet();
        }

        public function addEmployee($data) {
            // Insert into users table
            $this->db->query('INSERT INTO users (email, password, user_role) VALUES (:email, :password, :user_role)');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            $this->db->bind(':user_role', $data['user_role']);

            if ($this->db->execute()) {
                $user_id = $this->db->lastInsertId();

                // Insert into employee table
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
                $this->db->bind(':cv_upload', $data['cv_upload']);
                $this->db->bind(':branch', $data['branch_id']); // Ensure branch_id is passed here
                $this->db->bind(':user_id', $user_id);
                $this->db->bind(':user_role', $data['user_role']);

                if ($this->db->execute()) {
                    $employee_id = $this->db->lastInsertId();

                    // Insert into the related table based on user_role
                    if ($data['user_role'] === 'cashier') {
                        $this->db->query('INSERT INTO cashier (employee_id, user_id, branch_id) VALUES (:employee_id, :user_id, :branch_id)');
                        $this->db->bind(':employee_id', $employee_id);
                        $this->db->bind(':user_id', $user_id);
                        $this->db->bind(':branch_id', $data['branch_id']);
                    } elseif ($data['user_role'] === 'branchmanager') {
                        $this->db->query('INSERT INTO branchmanager (employee_id, user_id, branch_id) VALUES (:employee_id, :user_id, :branch_id)');
                        $this->db->bind(':employee_id', $employee_id);
                        $this->db->bind(':user_id', $user_id);
                        $this->db->bind(':branch_id', $data['branch_id']);
                    } elseif ($data['user_role'] === 'headmanager') {
                        $this->db->query('INSERT INTO headmanager (employee_id, user_id, branch_id) VALUES (:employee_id, :user_id, :branch_id)');
                        $this->db->bind(':employee_id', $employee_id);
                        $this->db->bind(':user_id', $user_id);
                        $this->db->bind(':branch_id', $data['branch_id']);
                    }

                    return $this->db->execute();
                }
            }

            return false;
        }

        public function getUserByEmail($email)
        {
            $this->db->query('SELECT user_id FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            return $this->db->single();
        }

        public function getEmployeeById($employee_id) {
            $this->db->query('SELECT * FROM employee WHERE employee_id = :employee_id');
            $this->db->bind(':employee_id', $employee_id);
            return $this->db->single();
        }
        public function getEmployeeByUserId($user_id) {
            $this->db->query('SELECT * FROM employee WHERE user_id = :user_id');
            $this->db->bind(':user_id', $user_id);
            return $this->db->single();
        }

        public function updateEmployee($data) {
            // Update users table
            $this->db->query('UPDATE users SET email = :email, user_role = :user_role' .
                             (!empty($data['password']) ? ', password = :password' : '') .
                             ' WHERE user_id = :user_id');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':user_role', $data['user_role']);
            if (!empty($data['password'])) {
                $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            }
            $result1 = $this->db->execute();

            // Get the current user role from the employee table
            $this->db->query('SELECT user_role FROM employee WHERE employee_id = :employee_id');
            $this->db->bind(':employee_id', $data['employee_id']);
            $currentRole = $this->db->single()->user_role;

            // Remove the employee from the previous role's table if the role has changed
            if ($currentRole !== $data['user_role']) {
                if ($currentRole === 'cashier') {
                    $this->db->query('DELETE FROM cashier WHERE employee_id = :employee_id');
                    $this->db->bind(':employee_id', $data['employee_id']);
                    $this->db->execute();
                } elseif ($currentRole === 'branchmanager') {
                    $this->db->query('DELETE FROM branchmanager WHERE employee_id = :employee_id');
                    $this->db->bind(':employee_id', $data['employee_id']);
                    $this->db->execute();
                } elseif ($currentRole === 'headmanager') {
                    $this->db->query('DELETE FROM headmanager WHERE employee_id = :employee_id');
                    $this->db->bind(':employee_id', $data['employee_id']);
                    $this->db->execute();
                }
            }

            // Update employee table
            $this->db->query('UPDATE employee SET 
                              full_name = :full_name, 
                              address = :address, 
                              contact_no = :contact_no, 
                              nic = :nic, 
                              dob = :dob, 
                              gender = :gender, 
                              email = :email, 
                              branch = :branch, 
                              user_role = :user_role, 
                              join_date = :join_date' .
                              (!empty($data['cv_upload']) ? ', cv_upload = :cv_upload' : '') .
                              ' WHERE employee_id = :employee_id');
            $this->db->bind(':employee_id', $data['employee_id']);
            $this->db->bind(':full_name', $data['full_name']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':contact_no', $data['contact_no']);
            $this->db->bind(':nic', $data['nic']);
            $this->db->bind(':dob', $data['dob']);
            $this->db->bind(':gender', $data['gender']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':branch', $data['branch_id']);
            $this->db->bind(':user_role', $data['user_role']);
            $this->db->bind(':join_date', $data['join_date']);
            if (!empty($data['cv_upload'])) {
                $this->db->bind(':cv_upload', $data['cv_upload']);
            }
            $result2 = $this->db->execute();

            // Add the employee to the new role's table if the role has changed
            if ($currentRole !== $data['user_role']) {
                if ($data['user_role'] === 'cashier') {
                    $this->db->query('INSERT INTO cashier (employee_id, user_id, branch_id) VALUES (:employee_id, :user_id, :branch_id)');
                    $this->db->bind(':employee_id', $data['employee_id']);
                    $this->db->bind(':user_id', $data['user_id']);
                    $this->db->bind(':branch_id', $data['branch_id']);
                    $this->db->execute();
                } elseif ($data['user_role'] === 'branchmanager') {
                    $this->db->query('INSERT INTO branchmanager (employee_id, user_id, branch_id) VALUES (:employee_id, :user_id, :branch_id)');
                    $this->db->bind(':employee_id', $data['employee_id']);
                    $this->db->bind(':user_id', $data['user_id']);
                    $this->db->bind(':branch_id', $data['branch_id']);
                    $this->db->execute();
                } elseif ($data['user_role'] === 'headmanager') {
                    $this->db->query('INSERT INTO headmanager (employee_id, user_id, branch_id) VALUES (:employee_id, :user_id, :branch_id)');
                    $this->db->bind(':employee_id', $data['employee_id']);
                    $this->db->bind(':user_id', $data['user_id']);
                    $this->db->bind(':branch_id', $data['branch_id']);
                    $this->db->execute();
                }
            }

            return $result1 && $result2;
        }

        public function deleteEmployee($id) {
            // Get the employee details
            $this->db->query('SELECT user_id, user_role FROM employee WHERE employee_id = :id');
            $this->db->bind(':id', $id);
            $employee = $this->db->single();

            if ($employee) {
                $user_id = $employee->user_id;
                $user_role = $employee->user_role;

                // Delete from related table based on user_role
                if ($user_role === 'cashier') {
                    $this->db->query('DELETE FROM cashier WHERE employee_id = :id');
                    $this->db->bind(':id', $id);
                    $this->db->execute();
                } elseif ($user_role === 'branchmanager') {
                    $this->db->query('DELETE FROM branchmanager WHERE employee_id = :id');
                    $this->db->bind(':id', $id);
                    $this->db->execute();
                } elseif ($user_role === 'headmanager') {
                    $this->db->query('DELETE FROM headmanager WHERE employee_id = :id');
                    $this->db->bind(':id', $id);
                    $this->db->execute();
                }

                // Delete from employee table
                $this->db->query('DELETE FROM employee WHERE employee_id = :id');
                $this->db->bind(':id', $id);
                $result1 = $this->db->execute();

                // Delete from users table
                $this->db->query('DELETE FROM users WHERE user_id = :user_id');
                $this->db->bind(':user_id', $user_id);
                $result2 = $this->db->execute();

                return $result1 && $result2;
            }

            return false;
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

        public function isEmailUnique($email, $excludeUserId = null) {
            $query = 'SELECT COUNT(*) as count FROM users WHERE email = :email';
            if ($excludeUserId) {
                $query .= ' AND id != :excludeUserId';
            }
            $this->db->query($query);
            $this->db->bind(':email', $email);
            if ($excludeUserId) {
                $this->db->bind(':excludeUserId', $excludeUserId);
            }
            $result = $this->db->single();
            return $result->count == 0;
        }


        public function getAllBranches() {
            $this->db->query('SELECT branch_id, branch_name FROM branch');
            return $this->db->resultSet();
}
        public function getDashboardStats() {

            try {
                $stats = [];
                
                // Get total customers (no status filter needed)
                $this->db->query('SELECT COUNT(*) as total FROM customer');
                $result = $this->db->single();
                $stats['totalCustomers'] = $result ? $result->total : 0;
                
                // Get total employees (assuming no status column, count all)
                $this->db->query('SELECT COUNT(*) as total FROM employee');
                $result = $this->db->single();
                $stats['totalEmployees'] = $result ? $result->total : 0;
                
                // Get total categories (no status filter needed)
                $this->db->query('SELECT COUNT(*) as total FROM category');
                $result = $this->db->single();
                $stats['totalCategories'] = $result ? $result->total : 0;
                
                // Get total products (no status filter needed)
                $this->db->query('SELECT COUNT(*) as total FROM product');
                $result = $this->db->single();
                $stats['totalProducts'] = $result ? $result->total : 0;
                
                // Get total branches (assuming status column exists in branch table)
                $this->db->query('SELECT COUNT(*) as total FROM branch WHERE status = "active"');
                $result = $this->db->single();
                $stats['activeBranches'] = $result ? $result->total : 0;
                
                return $stats;
                
            } catch (Exception $e) {
                error_log("Error in getDashboardStats: " . $e->getMessage());
                return [
                    'totalCustomers' => 0,
                    'totalEmployees' => 0,
                    'totalCategories' => 0,
                    'totalProducts' => 0,
                    'activeBranches' => 0
                ];
            }

        }
    }
}
?>