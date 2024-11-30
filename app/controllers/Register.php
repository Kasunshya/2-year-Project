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
            if (empty($data['password']) || strlen($data['password']) < 8) {
                $data['errors']['password'] = 'Password must be at least 6 characters';
            }
            if ($data['password'] != $data['confirm_password']) {
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
