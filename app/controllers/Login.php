<?php
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
                    // Start session and redirect based on role
                    session_start();
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['user_role'] = $user->user_role;

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
              header('Location: ' . URLROOT . 'Customer/customerhomepage');
            break;
            case 'cashier':
              header('Location: ' . URLROOT . '/Cashier/cashierdashboard');
                break;
            case 'branchmanager':
                header('Location: ' . URLROOT . '/BranchM/branchmdashboard');
                break;
            case 'inventorykeeper':
                header('Location: ' . URLROOT . '/Inventorykeeper/viewInventory');
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
