<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Register extends Controller {
    public function signup() {
        $data = [
            'customer_name' => '',
            'email' => '',
            'contact_number' => '',
            'address' => '',
            'password' => '',
            'confirm_password' => '',
            'errors' => []
        ];

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Add debug logging
            error_log("Processing registration form submission");
            
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Get form data
            $data = [
                'customer_name' => trim($_POST['customer_name']),
                'email' => trim($_POST['email']),
                'contact_number' => trim($_POST['contact_number'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'errors' => []
            ];

            // Debug form data
            error_log("Form data - Name: " . $data['customer_name'] . ", Email: " . $data['email']);

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
                $existingUser = $userModel->findUserByEmail($data['email']);
                if ($existingUser) {
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

            // Validate contact number (optional field)
            if (!empty($data['contact_number']) && !preg_match('/^[0-9]{10,15}$/', $data['contact_number'])) {
                $data['errors']['contact_number'] = 'Please enter a valid contact number';
            }
            
            // If there are errors, set a SweetAlert message
            if (!empty($data['errors'])) {
                // Get the first error message for SweetAlert
                $firstError = reset($data['errors']);
                $_SESSION['sweet_alert'] = [
                    'type' => 'error',
                    'title' => 'Validation Error',
                    'text' => $firstError
                ];
            }

            // Proceed if there are no errors
            if (empty($data['errors'])) {
                $userModel = $this->model('User');
                $customerModel = $this->model('Customer');

                // Hash the password
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

                // Debug password hash
                error_log("Password successfully hashed");

                // Insert user into `users` table
                $userId = $userModel->createUser($data['email'], $hashedPassword, 'customer');
                
                if ($userId) {
                    error_log("User created with ID: $userId");
                    
                    // Insert customer into `customer` table
                    if ($customerModel->createCustomer($data['customer_name'], $userId, $data['contact_number'], $data['address'])) {
                        error_log("Customer creation successful");
                        
                        // Set success message in session for SweetAlert
                        $_SESSION['sweet_alert'] = [
                            'type' => 'success',
                            'title' => 'Success!',
                            'text' => 'Registration successful! Please login.'
                        ];
                        
                        // Redirect to login
                        redirect('login/indexx');
                    } else {
                        error_log("Customer creation failed");
                        
                        // Set error message in session for SweetAlert
                        $_SESSION['sweet_alert'] = [
                            'type' => 'error',
                            'title' => 'Registration Error',
                            'text' => 'Error creating customer record'
                        ];
                        
                        // Since user was created but customer failed, we should clean up
                        $this->db = new Database();
                        $this->db->query('DELETE FROM users WHERE user_id = :id');
                        $this->db->bind(':id', $userId);
                        $this->db->execute();
                    }
                } else {
                    error_log("User creation failed - email may already exist");
                    
                    // Set error message in session for SweetAlert
                    $_SESSION['sweet_alert'] = [
                        'type' => 'error',
                        'title' => 'Registration Error',
                        'text' => 'Email already exists or system error occurred'
                    ];
                }
            }
        }

        // Load the signup view
        $this->view('users/v_register', $data);
    }
}
