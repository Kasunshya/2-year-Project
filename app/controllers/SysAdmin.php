<?php
require_once APPROOT . '/helpers/session_helper.php';

class SysAdmin extends Controller {
    private $sysAdminModel;

    public function __construct() {
        $this->sysAdminModel = $this->model('M_SysAdmin');
        
        // Make sure the upload directory exists
        if (!file_exists(UPLOADROOT)) {
            mkdir(UPLOADROOT, 0755, true);
        }
    }

    public function dashboard() {
        $this->view('SysAdmin/Dashboard');
    }

    public function employeeManagement() {
        $employees = $this->sysAdminModel->getAllEmployees();
        $data = [
            'employees' => $employees
        ];
        $this->view('SysAdmin/EmployeeManagement', $data);
    }

    public function addEmployee() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Fetch user_id from the users table based on email
            $user = $this->sysAdminModel->getUserByEmail(trim($_POST['email']));
            $user_id = $user ? $user->user_id : null;

            // If user does not exist, add to users table
            if (!$user_id) {
                $userData = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']), // Assuming password is provided in the form
                    'user_role' => trim($_POST['user_role'])
                ];
                $this->sysAdminModel->addUser($userData);
                $user = $this->sysAdminModel->getUserByEmail(trim($_POST['email']));
                $user_id = $user->user_id;
            }

            $data = [
                'full_name' => trim($_POST['full_name']),
                'address' => trim($_POST['address']),
                'contact_no' => trim($_POST['contact_no']),
                'nic' => trim($_POST['nic']),
                'dob' => trim($_POST['dob']),
                'gender' => trim($_POST['gender']),
                'email' => trim($_POST['email']),
                'join_date' => trim($_POST['join_date']),
                'cv_upload' => trim($_FILES['cv_upload']['name']),
                'branch' => trim($_POST['branch']),
                'user_id' => $user_id,
                'user_role' => trim($_POST['user_role'])
            ];

            if ($this->sysAdminModel->addEmployee($data)) {
                move_uploaded_file($_FILES['cv_upload']['tmp_name'], UPLOADROOT . '/' . $data['cv_upload']);
                flash('employee_message', 'Employee Added');
                redirect('sysadmin/employeeManagement');
            } else {
                die('Something went wrong');
            }
        } else {
            $data = [
                'full_name' => '',
                'address' => '',
                'contact_no' => '',
                'nic' => '',
                'dob' => '',
                'gender' => '',
                'email' => '',
                'join_date' => '',
                'cv_upload' => '',
                'branch' => '',
                'user_id' => '',
                'user_role' => ''
            ];

            $this->view('SysAdmin/EmployeeManagement', $data);
        }
    }

    public function editEmployee() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Get current employee data to keep the CV file name if no new file is uploaded
            $currentEmployee = $this->sysAdminModel->getEmployeeById($_POST['employee_id']);
            
            // Use the existing CV file name if no new file is uploaded
            $cvFileName = $currentEmployee->cv_upload;
            
            // If a new file is uploaded, use its name
            if (!empty($_FILES['cv_upload']['name'])) {
                $cvFileName = $_FILES['cv_upload']['name'];
            }

            $data = [
                'employee_id' => trim($_POST['employee_id']),
                'full_name' => trim($_POST['full_name']),
                'address' => trim($_POST['address']),
                'contact_no' => trim($_POST['contact_no']),
                'nic' => trim($_POST['nic']),
                'dob' => trim($_POST['dob']),
                'gender' => trim($_POST['gender']),
                'email' => trim($_POST['email']),
                'join_date' => trim($_POST['join_date']),
                'cv_upload' => $cvFileName,
                'branch' => trim($_POST['branch']),
                'user_role' => trim($_POST['user_role']),
                'user_id' => trim($_POST['user_id'])
            ];

            if ($this->sysAdminModel->updateEmployee($data) && $this->sysAdminModel->updateUser($data)) {
                if (!empty($_FILES['cv_upload']['name']) && !empty($_FILES['cv_upload']['tmp_name'])) {
                    move_uploaded_file($_FILES['cv_upload']['tmp_name'], UPLOADROOT . '/' . $cvFileName);
                }
                flash('employee_message', 'Employee Updated');
                redirect('sysadmin/employeeManagement');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('sysadmin/employeeManagement');
        }
    }

    public function downloadCV($filename = null) {
        if ($filename) {
            $file_path = UPLOADROOT . '/' . $filename;
            
            if (file_exists($file_path)) {
                // Set headers to force download
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                header('Content-Length: ' . filesize($file_path));
                
                // Read the file and output it to the browser
                readfile($file_path);
                exit;
            } else {
                flash('employee_message', 'CV file not found', 'alert alert-danger');
                redirect('sysadmin/employeeManagement');
            }
        } else {
            flash('employee_message', 'No filename specified', 'alert alert-danger');
            redirect('sysadmin/employeeManagement');
        }
    }

    public function deleteEmployee($id = null) {
        if($id) {
            // Get the employee to find the user_id before deletion
            $employee = $this->sysAdminModel->getEmployeeById($id);
            
            if($employee) {
                $user_id = $employee->user_id;
                
                // First delete from employee table
                if($this->sysAdminModel->deleteEmployee($id)) {
                    // Then delete from users table if user_id exists
                    if($user_id) {
                        $this->sysAdminModel->deleteUser($user_id);
                    }
                    
                    flash('employee_message', 'Employee deleted successfully');
                    // Return JSON response for AJAX requests
                    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                        echo json_encode(['success' => true]);
                        return;
                    }
                } else {
                    flash('employee_message', 'Failed to delete employee', 'alert alert-danger');
                    // Return JSON response for AJAX requests
                    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                        echo json_encode(['success' => false]);
                        return;
                    }
                }
            }
        }
        
        // Redirect for non-AJAX requests
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            redirect('sysadmin/employeeManagement');
        }
    }

    public function customermanagement() {
        $this->view('SysAdmin/CustomerManagement');
    }

    public function productmanagement() {
        $this->view('SysAdmin/ProductManagement');
    }

    public function branchmanagement() {
        $this->view('SysAdmin/BranchManagement');
    }

 

    public function categorymanagement() {
        $this->view('SysAdmin/CategoryManagement');
    }
}
?>