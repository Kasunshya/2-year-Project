<?php
require_once '../app/helpers/Session_Helper.php';

class HeadManager extends Controller {
    private $employeeModel;
    
    public function __construct() {
        if (!isLoggedIn() || $_SESSION['user_role'] !== 'headmanager') {
            redirect('users/login');
        }
        $this->employeeModel = $this->model('M_Employee');
    }

    public function profile() {
        // Get employee data using user_id from session
        $employeeData = $this->employeeModel->getEmployeeByUserId($_SESSION['user_id']);
        
        if (!$employeeData) {
            // If no data found, provide default values
            $employeeData = (object)[
                'employee_id' => $_SESSION['user_id'],
                'full_name' => 'Not Set',
                'email' => $_SESSION['user_email'] ?? 'Not Set',
                'contact_no' => 'Not Set',
                'address' => 'Not Set',
                'nic' => 'Not Set',
                'dob' => date('Y-m-d'),
                'gender' => 'Not Set',
                'join_date' => date('Y-m-d'),
                'user_role' => 'headmanager'
            ];
        }

        $data = [
            'title' => 'Head Manager Profile',
            'employee' => $employeeData
        ];

        $this->view('HeadM/v_Profile', $data);
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form data
            $data = [
                'user_id' => $_SESSION['user_id'],
                'contact_no' => trim($_POST['contact_no']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address'])
            ];

            if ($this->employeeModel->updateEmployee($data)) {
                flash('profile_message', 'Profile Updated Successfully');
            } else {
                flash('profile_message', 'Something went wrong', 'alert alert-danger');
            }
        }
        redirect('headmanager/profile');
    }
}
