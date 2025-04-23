<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();}
class Login extends Controller {
    public function indexx() {
        $data = [
            'email' => '',
            'password' => '',
            'errors' => []
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'errors' => []
            ];

            // Validation
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Valid email is required';
            }
            if (empty($data['password'])) {
                $data['errors']['password'] = 'Password is required';
            }

            if (empty($data['errors'])) {
                $userModel = $this->model('User');
                $user = $userModel->findUserByEmail($data['email']);

                // Check if user exists and password matches
                if ($user && password_verify($data['password'], $user->password)) {
                    // Start session and set user data
                    session_start();
                    $_SESSION['user_id'] = $user->user_id;
                    $_SESSION['user_role'] = $user->user_role;
                    
                    // For cashier role, fetch and set the employee_id and branch_id
                    if ($user->user_role === 'cashier') {
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
                    
                    $this->redirectToDashboard($user->user_role);
                } else {
                    $data['errors']['general'] = 'Invalid credentials';
                }
            }
        }

        // Load the login view
        $this->view('users/v_login', $data);
    }
    
    private function redirectToDashboard($role) {
        switch ($role) {
            case 'customer':
              header('Location: ' . URLROOT . '/Customer/customerhomepage');
            break;
            case 'cashier':
              header('Location: ' . URLROOT . '/Cashier/cashierdashboard');
                break;
            case 'branchmanager':
                header('Location: ' . URLROOT . '/BranchM/branchmdashboard');
                break;
            case 'inventorykeeper':
                header('Location: ' . URLROOT . '/Inventorykeeper/viewinventory');
                break;
            case 'headmanager':
                header('Location: ' . URLROOT . '/HeadM/dashboard');
                break;
            case 'admin':
                header('Location: ' . URLROOT . '/SysAdmin/dashboard');
                break;
            default:
                header('Location: /login/unauthorized');
        }
        exit;
    }
    public function logout() {
        // Destroy the session
        session_start();
        session_unset();
        session_destroy();
        echo 'Session destroyed';
        echo 'Session destroyed. Redirecting to login...';


    
        // Redirect to the login page
        header('Location: ' . URLROOT . '/Login/indexx');
        exit;
    }
       
}
