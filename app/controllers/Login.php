<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Login extends Controller {
    public function indexx() {
        // Display any registration success message
        if (isset($_SESSION['registration_success'])) {
            $registration_success = true;
            unset($_SESSION['registration_success']);
        } else {
            $registration_success = false;
        }
        
        $data = [
            'email' => '',
            'password' => '',
            'errors' => [],
            'registration_success' => $registration_success
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Add detailed logging
            error_log("LOGIN: Processing login form submission");
            
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'errors' => [],
                'registration_success' => $registration_success
            ];

            error_log("LOGIN: Attempt for email: " . $data['email']);
            
            // Validation
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Valid email is required';
                error_log("LOGIN: Invalid email format");
            }
            if (empty($data['password'])) {
                $data['errors']['password'] = 'Password is required';
                error_log("LOGIN: Empty password");
            }

            if (empty($data['errors'])) {
                $userModel = $this->model('User');
                $user = $userModel->findUserByEmail($data['email']);

                error_log("LOGIN: User lookup result: " . ($user ? "Found" : "Not found"));

                if ($user) {
                    error_log("LOGIN: Verifying password for user ID: " . $user->user_id);
                    
                    // Verify password
                    if (password_verify($data['password'], $user->password)) {
                        error_log("LOGIN: Password verified successfully");
                        
                        // Set up session data
                        $_SESSION['user_id'] = $user->user_id;
                        $_SESSION['user_email'] = $user->email;
                        $_SESSION['user_role'] = $user->user_role;
                        
                        error_log("LOGIN: Session initialized - User ID: " . $_SESSION['user_id'] . ", Role: " . $_SESSION['user_role']);
                        
                        // For customer role, set customer_id in session
                        if ($user->user_role === 'customer') {
                            $customerModel = $this->model('Customer');
                            $customer = $customerModel->getCustomerByUserId($user->user_id);
                            
                            if ($customer) {
                                $_SESSION['customer_id'] = $customer->customer_id;
                                $_SESSION['customer_name'] = $customer->customer_name;
                                error_log("LOGIN: Customer data set - ID: " . $_SESSION['customer_id'] . ", Name: " . $_SESSION['customer_name']);
                            } else {
                                error_log("LOGIN: WARNING - No customer record found for user ID: " . $user->user_id);
                            }
                        }
                        // For cashier role, fetch and set the employee_id and branch_id
                        elseif ($user->user_role === 'cashier') {
                            // First try to get from cashier table directly
                            $this->db = new Database();
                            $this->db->query("SELECT c.cashier_id, c.employee_id, c.branch_id 
                                             FROM cashier c 
                                             WHERE c.user_id = :user_id");
                            $this->db->bind(':user_id', $user->user_id);
                            $cashier = $this->db->single();
                            
                            if ($cashier && $cashier->branch_id) {
                                $_SESSION['cashier_id'] = $cashier->cashier_id;
                                $_SESSION['employee_id'] = $cashier->employee_id;
                                $_SESSION['branch_id'] = $cashier->branch_id;
                                error_log("Login - Found cashier record with cashier_id: " . $cashier->cashier_id . 
                                          ", employee_id: " . $cashier->employee_id . ", branch_id: " . $cashier->branch_id);
                            } else {
                                // If not found in cashier table or branch_id is null, try employee table
                                $this->db->query("SELECT e.employee_id, b.branch_id 
                                                 FROM employee e 
                                                 LEFT JOIN branch b ON e.branch = b.branch_name
                                                 WHERE e.user_id = :user_id AND e.user_role = 'cashier'");
                                $this->db->bind(':user_id', $user->user_id);
                                $employee = $this->db->single();
                                
                                if ($employee) {
                                    $_SESSION['employee_id'] = $employee->employee_id;
                                    $_SESSION['branch_id'] = $employee->branch_id;
                                    error_log("Login - Found employee with ID: " . $employee->employee_id . ", branch_id: " . $employee->branch_id);
                                } else {
                                    // Set default values as fallback
                                    $_SESSION['employee_id'] = 6;
                                    $_SESSION['branch_id'] = 1;
                                    error_log("Login - Using default values - employee_id: 6, branch_id: 1");
                                }
                            }
                        }
                        // For branch manager role, fetch and set the employee_id, branch_id, and branch manager_id
                        elseif ($user->user_role === 'branchmanager') {
                            $this->db = new Database();
                            $this->db->query("SELECT bm.branchmanager_id, bm.employee_id, bm.branch_id 
                                             FROM branchmanager bm 
                                             WHERE bm.user_id = :user_id");
                            $this->db->bind(':user_id', $user->user_id);
                            $manager = $this->db->single();
                            
                            if ($manager) {
                                $_SESSION['branchmanager_id'] = $manager->branchmanager_id;
                                $_SESSION['employee_id'] = $manager->employee_id;
                                $_SESSION['branch_id'] = $manager->branch_id;
                                error_log("Login - Found branch manager record with id: " . $manager->branchmanager_id . 
                                         ", employee_id: " . $manager->employee_id . ", branch_id: " . $manager->branch_id);
                            } else {
                                // If not found in branchmanager table, try employee table
                                $this->db->query("SELECT e.employee_id, b.branch_id 
                                                 FROM employee e 
                                                 LEFT JOIN branch b ON e.branch = b.branch_name
                                                 WHERE e.user_id = :user_id AND e.user_role = 'branchmanager'");
                                $this->db->bind(':user_id', $user->user_id);
                                $employee = $this->db->single();
                                
                                if ($employee) {
                                    $_SESSION['employee_id'] = $employee->employee_id;
                                    $_SESSION['branch_id'] = $employee->branch_id;
                                    error_log("Login - Found branch manager employee with ID: " . $employee->employee_id . ", branch_id: " . $employee->branch_id);
                                }
                            }
                        }
                        
                        // Debug redirect
                        $redirectUrl = $this->getRedirectUrl($user->user_role);
                        error_log("LOGIN: Redirecting to: " . $redirectUrl);
                        
                        // Perform redirect
                        header('Location: ' . $redirectUrl);
                        exit;
                    } else {
                        error_log("LOGIN: Password verification failed");
                        // Replace inline error with SweetAlert
                        $_SESSION['sweet_alert'] = [
                            'type' => 'error',
                            'title' => 'Authentication Failed',
                            'text' => 'Invalid password. Please try again.'
                        ];
                    }
                } else {
                    error_log("LOGIN: Email not found");
                    // Also convert email not found error to SweetAlert for consistency
                    $_SESSION['sweet_alert'] = [
                        'type' => 'error',
                        'title' => 'Authentication Failed',
                        'text' => 'Email not found. Please check your credentials.'
                    ];
                }
            }
        }

        // Load the login view
        $this->view('users/v_login', $data);
    }
    
    private function getRedirectUrl($role) {
        switch ($role) {
            case 'customer':
                return URLROOT . '/Customer/customerhomepage';
            case 'cashier':
                return URLROOT . '/Cashier/cashierdashboard';
            case 'branchmanager':
                return URLROOT . '/BranchM/branchmdashboard';
            case 'inventorykeeper':
                return URLROOT . '/Inventorykeeper/viewinventory';
            case 'headmanager':
                return URLROOT . '/HeadM/dashboard';
            case 'admin':
                return URLROOT . '/SysAdmin/dashboard';
            default:
                return URLROOT . '/login/unauthorized';
        }
    }
    
    private function redirectToDashboard($role) {
        header('Location: ' . $this->getRedirectUrl($role));
        exit;
    }
    
}
