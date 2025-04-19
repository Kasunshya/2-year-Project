<?php
class Profile extends Controller {
    private $profileModel;

    public function __construct() {
        // Check if user is logged in using session
        if(!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }
        $this->profileModel = $this->model('M_Profile');
    }

    public function index() {
        // Get employee data
        $employeeData = $this->profileModel->getEmployeeByUserId($_SESSION['user_id']);
        
        $data = [
            'employee' => $employeeData
        ];

        $this->view('Cashier/v_Profile', $data);
    }

    public function updateProfile() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'contact_no' => trim($_POST['contact_no']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address']),
                'user_id' => $_SESSION['user_id']
            ];

            if($this->profileModel->updateEmployee($data)) {
                flash('profile_message', 'Profile Updated Successfully');
            } else {
                flash('profile_message', 'Error Updating Profile', 'alert alert-danger');
            }
        }
        redirect('profile/index');
    }

    public function changePassword() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'user_id' => $_SESSION['user_id']
            ];

            if($this->profileModel->updatePassword($data)) {
                flash('profile_message', 'Password Changed Successfully');
            } else {
                flash('profile_message', 'Invalid Current Password', 'alert alert-danger');
            }
        }
        redirect('profile/index');
    }
}
