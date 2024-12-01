<?php
class Register extends Controller {
    public function signup() {
        $data = [];

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Get form data
            $data = [
                'customer_name' => trim($_POST['customer_name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'errors' => []
            ];

            // Validate input
            if (empty($data['customer_name'])) {
                $data['errors']['customer_name'] = 'Customer name is required';
            }
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Valid email is required';
            }
            else{
                // Check if the email already exists
                $userModel = $this->model('User');
                if ($userModel->findUserByEmail($data['email'])) {
                    $data['errors']['email'] = 'Email is already registered';
                }
            }
            // Validate password
            if (empty($data['password'])) {
                $data['errors']['password'] = 'Password is required';
            } elseif (strlen($data['password']) < 8) {
                $data['errors']['password'] = 'Password must be at least 8 characters';
            } elseif (!preg_match('/[A-Z]/', $data['password'])) {
                $data['errors']['password'] = 'Password must include at least one uppercase letter';
            } elseif (!preg_match('/[a-z]/', $data['password'])) {
                $data['errors']['password'] = 'Password must include at least one lowercase letter';
            } elseif (!preg_match('/[0-9]/', $data['password'])) {
                $data['errors']['password'] = 'Password must include at least one number';
            } elseif (!preg_match('/[\W_]/', $data['password'])) {
                $data['errors']['password'] = 'Password must include at least one special character';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['errors']['confirm_password'] = 'Please confirm your password';
            } elseif ($data['password'] !== $data['confirm_password']) {
                $data['errors']['confirm_password'] = 'Passwords do not match';
            }


            
            // Proceed if there are no errors
            if (empty($data['errors'])) {
                $userModel = $this->model('User');
                $customerModel = $this->model('Customer');

                // Hash the password
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

                // Insert user into `users` table
                $userId = $userModel->createUser($data['email'], $hashedPassword, 'customer');
                if ($userId) {
                    // Insert customer into `customers` table
                    if ($customerModel->createCustomer($data['customer_name'], $userId)) {
                        // Redirect to login or another page
                        redirect('login/indexx');
                    } else {
                        $data['errors']['general'] = 'Error creating customer';
                    }
                } else {
                    $data['errors']['email'] = 'Email already exists';
                }
            }
        }

        // Load the signup view
        $this->view('users/v_register', $data);
    }
}
