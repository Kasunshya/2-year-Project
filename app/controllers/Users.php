<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';
class Users extends Controller {
    public function __construct() {
        $this->userModel = $this->model('M_Users');
    }
    public function index() {
        $data = [
            'users' => $this->userModel->getUsers() // Example function to retrieve user data
        ];
        
        $this->view('pages/v_index', $data);
    }
    

    public function register() {
        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
                'password' => isset($_POST['password']) ? trim($_POST['password']) : '',
                'confirm_password' => isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Name is required';
            }

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Email is required';
            } else {
                // Check if email already exists
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already registered';
                }
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm the password';
            } else if ($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match';
            }

            // Check for errors
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash the password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register the user
                if ($this->userModel->register($data)) {
                    redirect('Users/login');
                } else {
                    die('Something went wrong during registration');
                }
            } else {
                // Load view with errors
                $this->view('users/v_register', $data);
            }
        } else {
            // Initialize data for GET requests
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Load the registration view
            $this->view('users/v_register', $data);
        }
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //form is submiting
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''

            ];
            //validate email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }else{
                //check if email exists
                if($this->userModel->findUserByEmail($data['email']) > 0){
                    //user is found
                    
                }
                else{
                    //user is not found
                    $data['email_err'] = 'User not found';
                }
            }
            //validate password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }
            //if no error found the login user
            if(empty($data['email_error']) && empty($data['password_err'])){
                //log the user
                $loggedUser = $this->userModel->login( $data['email'],$data['password']);

                if($loggedUser){
                   //create user sessions
                    $this->createUserSession($loggedUser);

                }else{
                    $data['password_err'] = 'Incorrect password';
                    //load view again with errors
                    $this->view('users/v_login', $data);
                }
            }else{
                //load view again with errors
                $this->view('users/v_login', $data);
            }
        }
        else{
            $data =[
                'email' => '',
                'password' => '',

                'email_err' => '',
                'password_err' => ''
            ];

            //load view
            $this->view('users/v_login', $data);
        }
    }
    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;

        redirect('Pages/index');

    }
    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();
        redirect('Users/login');

    }
    public function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
        else{
            return false;
        }

    }
    public function forgotPassword() {
        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $email = trim($_POST['email']);
            $email_err = '';
        
            // Validate email
            if (empty($email)) {
                $email_err = 'Please enter your email address';
            } elseif (!$this->userModel->findUserByEmail($email)) {
                $email_err = 'Email not found';
            }
        
            if (empty($email_err)) {
                // Generate a reset token and expiration time
                $token = bin2hex(random_bytes(50)); // Generate a random token
        
                // Store the token and expiration in the database
                if ($this->userModel->storePasswordResetToken($email, $token)) {
                    // Send the reset link using PHPMailer
                    $resetLink = URLROOT . "/Users/resetPassword/$token";
                    
                    // Create a new PHPMailer instance
                    $mail = new PHPMailer(true);
                    try {
                        //Server settings
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to send through (Gmail in this example)
                        $mail->SMTPAuth = true;
                        $mail->Username = '2022is042@stu.ucsc.cmb.ac.lk'; // Your email address
                        $mail->Password = 'wgcj mhtk gbwc eviv'; // Your email password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                    
                        //Recipients
                        $mail->setFrom('2022is042@stu.ucsc.cmb.ac.lk', 'kasu');
                        $mail->addAddress($email); // Add the recipient's email
                    
                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Password Reset Request';
                        $mail->Body    = "Please click the link below to reset your password:<br><a href=\"$resetLink\">Reset Password</a>";
                        $mail->AltBody = "Please click the link below to reset your password: $resetLink";
                    
                        $mail->send();
                        $this->view('users/v_forgotPassword', ['success_msg' => 'A password reset link has been sent to your email.']);
                    } catch (Exception $e) {
                        $this->view('users/v_forgotPassword', ['email_err' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
                    }
                } else {
                    die('Something went wrong while processing your request.');
                }
            } else {
                $this->view('users/v_forgotPassword', ['email_err' => $email_err]);
            }
        } else {
            // Display the forgot password form
            $this->view('users/v_forgotPassword');
        }
    }

    public function resetPassword($token) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            
            // Logging
            error_log("resetPassword - Token: $token, Password: $password, Confirm Password: $confirm_password");
            
            // Validate the passwords
            $password_err = '';
            $confirm_password_err = '';
    
            if (empty($password)) {
                $password_err = 'Please enter a password';
            } elseif (strlen($password) < 6) {
                $password_err = 'Password must be at least 6 characters long';
            }
    
            if (empty($confirm_password)) {
                $confirm_password_err = 'Please confirm your password';
            } elseif ($password !== $confirm_password) {
                $confirm_password_err = 'Passwords do not match';
            }
    
            if (empty($password_err) && empty($confirm_password_err)) {
                // Check if the token is valid
                $user = $this->userModel->findUserByToken($token);
                
                // Logging
                error_log("resetPassword - User found: " . ($user ? "Yes" : "No"));
                if ($user) {
                    error_log("resetPassword - User email: " . $user->email . ", Reset expires: " . $user->reset_expires);
                }
    
                if ($user && strtotime($user->reset_expires) > time()) {
                    // Hash the new password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    
                    if ($this->userModel->updatePassword($user->email, $hashedPassword)) {
                        // Clear the reset token
                        $this->userModel->clearResetToken($user->email);
                        
                        // Logging
                        error_log("resetPassword - Password updated for email: " . $user->email);
    
                        // Pass success message and redirect to login page
                        $_SESSION['success_message'] = 'Your password has been successfully reset.';
                        redirect('Users/login');
                    } else {
                        error_log("resetPassword - Failed to update password for email: " . $user->email);
                        die('Something went wrong while resetting your password.');
                    }
                } else {
                    error_log("resetPassword - Invalid or expired token: $token");
                    $this->view('users/resetPassword', [
                        'token' => $token,
                        'token_err' => 'Invalid or expired token'
                    ]);
                }
            } else {
                $this->view('users/resetPassword', [
                    'token' => $token,
                    'password_err' => $password_err,
                    'confirm_password_err' => $confirm_password_err
                ]);
            }
        } else {
            $this->view('users/resetPassword', ['token' => $token]);
        }
    }
}  
?>
