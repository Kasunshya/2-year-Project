<?php
class Profile extends Controller {
    private $db;
    private $employeeModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/Login/indexx');
            exit;
        }
        
        $this->db = new Database();
        $this->employeeModel = $this->model('M_Employee');
    }

    public function index() {
        $userId = $_SESSION['user_id'];
        $userRole = $_SESSION['user_role'];
        
        if ($userRole === 'branchmanager') {
            // Get branch manager details including branch information
            $manager = $this->employeeModel->getBranchManagerDetails($userId);
            
            if (!$manager) {
                // Log error and handle gracefully
                error_log("Failed to fetch branch manager details for user_id: " . $userId);
                $manager = new stdClass();
                $manager->full_name = 'N/A';
                $manager->employee_id = 'N/A';
                // Set other default values
            }
            
            $data = [
                'manager' => $manager,
                'title' => 'Branch Manager Profile'
            ];
            
            $this->view('BranchM/v_Profile', $data);
        } 
        elseif ($userRole === 'cashier') {
            // For cashier users
            $employeeId = $_SESSION['employee_id'];
            $employee = $this->employeeModel->getEmployeeById($employeeId);
            
            $data = [
                'employee' => $employee,
                'title' => 'Cashier Profile'
            ];
            
            $this->view('Cashier/v_Profile', $data);
        } 
        else {
            header('Location: ' . URLROOT . '/Login/redirectToDashboard');
            exit;
        }
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Log the received data
            error_log('Profile update requested for user: ' . $_SESSION['user_id']);
            error_log('POST data: ' . print_r($_POST, true));

            $data = [
                'contact_no' => trim($_POST['contact_no']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address']),
                'errors' => []
            ];

            // Validate input
            if (empty($data['contact_no'])) {
                $data['errors'][] = 'Contact number is required';
            }
            if (empty($data['email'])) {
                $data['errors'][] = 'Email is required';
            }
            if (empty($data['address'])) {
                $data['errors'][] = 'Address is required';
            }

            if (empty($data['errors'])) {
                // Attempt to update profile
                if ($this->employeeModel->updateProfile($_SESSION['user_id'], $data)) {
                    $_SESSION['success_message'] = 'Profile updated successfully';
                    error_log('Profile updated successfully for user: ' . $_SESSION['user_id']);
                } else {
                    $_SESSION['error_message'] = 'Failed to update profile';
                    error_log('Failed to update profile for user: ' . $_SESSION['user_id']);
                }
            } else {
                $_SESSION['error_message'] = 'Please fix the errors in your form';
                error_log('Validation errors in profile update: ' . print_r($data['errors'], true));
            }

            // Redirect back to profile page
            header('Location: ' . URLROOT . '/Profile/index');
            exit();
        }
    }

    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $userId = $_SESSION['user_id'];
            
            $data = [
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'errors' => []
            ];
            
            // Password validation
            if (empty($data['current_password'])) {
                $data['errors']['current_password'] = 'Please enter your current password';
            }
            
            if (empty($data['new_password'])) {
                $data['errors']['new_password'] = 'Please enter a new password';
            } elseif (strlen($data['new_password']) < 6) {
                $data['errors']['new_password'] = 'Password must be at least 6 characters';
            }
            
            if ($data['new_password'] !== $data['confirm_password']) {
                $data['errors']['confirm_password'] = 'Passwords do not match';
            }
            
            if (empty($data['errors'])) {
                // Get user password
                $userModel = $this->model('User');
                $user = $userModel->findUserById($userId);
                
                // Verify current password
                if ($user && password_verify($data['current_password'], $user->password)) {
                    // Hash new password
                    $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
                    
                    // Update password
                    if ($userModel->updatePassword($userId, $data['new_password'])) {
                        $_SESSION['password_success'] = 'Password updated successfully';
                    } else {
                        $_SESSION['password_error'] = 'Failed to update password';
                    }
                } else {
                    $_SESSION['password_error'] = 'Current password is incorrect';
                }
            } else {
                $_SESSION['password_errors'] = $data['errors'];
            }
            
            // Redirect back to profile page
            header('Location: ' . URLROOT . '/Profile/index');
            exit;
        } else {
            // Redirect if not POST request
            header('Location: ' . URLROOT . '/Profile/index');
            exit;
        }
    }
}
