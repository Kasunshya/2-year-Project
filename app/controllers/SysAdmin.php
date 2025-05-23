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

        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }
    }

    public function dashboard() {
        if(!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }
        // Get all dashboard statistics
        $stats = $this->sysAdminModel->getDashboardStats();
        
        $data = [
            'totalCustomers' => $stats['totalCustomers'] ?? 0,
            'totalEmployees' => $stats['totalEmployees'] ?? 0,
            'totalCategories' => $stats['totalCategories'] ?? 0,
            'totalProducts' => $stats['totalProducts'] ?? 0,
            'activeBranches' => $stats['activeBranches'] ?? 0,
            'title' => 'Dashboard'
        ];

        $this->view('SysAdmin/Dashboard', $data);
    }

    public function profile() {
        // Get the user_id from session
        $user_id = $_SESSION['user_id'] ?? null;
        
        if (!$user_id) {
            flash('profile_message', 'User not found', 'alert alert-danger');
            redirect('sysadmin/dashboard');
        }

        // Get employee data by user_id
        $employee = $this->sysAdminModel->getEmployeeByUserId($user_id);
        
        if (!$employee) {
            flash('profile_message', 'Employee data not found', 'alert alert-danger');
            redirect('sysadmin/dashboard');
        }

        $data = [
            'employee' => $employee
        ];

        $this->view('SysAdmin/Profile', $data);
    }

    public function employeeManagement() {
        // Process search parameters
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $branchId = isset($_GET['branch_id']) ? $_GET['branch_id'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : 'active'; // Default to active employees
        
        // Get filtered employees
        $employees = $this->sysAdminModel->searchEmployees($search, $branchId, $status);
        $branches = $this->sysAdminModel->getAllBranches();
        
        $data = [
            'employees' => $employees,
            'branches' => $branches
        ];
        
        $this->view('SysAdmin/EmployeeManagement', $data);
    }

    public function addEmployee() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Validate branch_id
            if (empty($_POST['branch_id'])) {
                flash('employee_message', 'Please select a branch.', 'alert alert-danger');
                redirect('sysadmin/employeeManagement');
            }

            // Handle CV upload
            $cvFileName = '';
            if (!empty($_FILES['cv_upload']['name'])) {
                $cvFileName = $_FILES['cv_upload']['name'];
                move_uploaded_file($_FILES['cv_upload']['tmp_name'], UPLOADROOT . '/' . $cvFileName);
            }

            $data = [
                'full_name' => trim($_POST['full_name']),
                'address' => trim($_POST['address']),
                'contact_no' => trim($_POST['contact_no']),
                'nic' => trim($_POST['nic']),
                'dob' => trim($_POST['dob']),
                'gender' => trim($_POST['gender']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'join_date' => trim($_POST['join_date']),
                'cv_upload' => $cvFileName, // Use the uploaded CV file name
                'branch_id' => trim($_POST['branch_id']), // Ensure branch_id is included
                'user_role' => trim($_POST['user_role'])
            ];

            // Check for duplicate email BEFORE trying to insert
            $emailExists = !$this->sysAdminModel->isEmailUnique($data['email']);
            if ($emailExists) {
                flash('employee_message', 'Email already exists. Please use a different email.', 'alert alert-danger');
                redirect('sysadmin/employeeManagement');
                return; // Important: Stop execution here
            }

            if ($this->sysAdminModel->addEmployee($data)) {
                flash('employee_message', 'Employee added successfully');
                redirect('sysadmin/employeeManagement');
            } else {
                flash('employee_message', 'Something went wrong', 'alert alert-danger');
                redirect('sysadmin/employeeManagement');
            }
        } else {
            $this->view('SysAdmin/EmployeeManagement');
        }
    }

    public function editEmployee() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Validate branch_id
            if (empty($_POST['branch_id'])) {
                flash('employee_message', 'Please select a branch.', 'alert alert-danger');
                redirect('sysadmin/employeeManagement');
            }

            // Get current employee data to keep the CV file name if no new file is uploaded
            $currentEmployee = $this->sysAdminModel->getEmployeeById($_POST['employee_id']);

            // Use the existing CV file name if no new file is uploaded
            $cvFileName = $currentEmployee->cv_upload;

            // If a new file is uploaded, use its name
            if (!empty($_FILES['cv_upload']['name'])) {
                $cvFileName = $_FILES['cv_upload']['name'];
                move_uploaded_file($_FILES['cv_upload']['tmp_name'], UPLOADROOT . '/' . $cvFileName);
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
                'branch_id' => trim($_POST['branch_id']),
                'user_role' => trim($_POST['user_role']),
                'user_id' => trim($_POST['user_id'])
            ];

            // Check if the email is unique for other employees (excluding current employee)
            if (!$this->sysAdminModel->isEmailUnique($data['email'], $data['user_id'])) {
                flash('employee_message', 'Email already exists. Please use a different email.', 'alert alert-danger');
                redirect('sysadmin/employeeManagement');
            }

            if ($this->sysAdminModel->updateEmployee($data)) {
                // Update related table based on user_role
                if ($data['user_role'] === 'cashier') {
                    $this->sysAdminModel->updateCashier($data);
                } elseif ($data['user_role'] === 'branchmanager') {
                    $this->sysAdminModel->updateBranchManager($data);
                } elseif ($data['user_role'] === 'headmanager') {
                    $this->sysAdminModel->updateHeadManager($data);
                }

                flash('employee_message', 'Employee Updated');
                redirect('sysadmin/employeeManagement');
            } else {
                flash('employee_message', 'Failed to update employee', 'alert alert-danger');
                redirect('sysadmin/employeeManagement');
            }
        } else {
            redirect('sysadmin/employeeManagement');
        }
    }

    public function updateEmployee() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Existing code to process POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $cvFileName = '';
            if (!empty($_FILES['cv_upload']['name'])) {
                $cvFileName = $_FILES['cv_upload']['name'];
                move_uploaded_file($_FILES['cv_upload']['tmp_name'], UPLOADROOT . '/' . $cvFileName);
            }
            $userId= $this->sysAdminModel->getEmployeeById($_POST['employee_id'])->user_id;
            $data = [
                'employee_id' => trim($_POST['employee_id']),
                'full_name' => trim($_POST['full_name']),
                'address' => trim($_POST['address']),
                'contact_no' => trim($_POST['contact_no']),
                'nic' => trim($_POST['nic']),
                'dob' => trim($_POST['dob']),
                'gender' => trim($_POST['gender']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'join_date' => trim($_POST['join_date']),
                'cv_upload' => $cvFileName,
                'branch_id' => trim($_POST['branch_id']),
                'user_role' => trim($_POST['user_role']),
                'user_id' => $userId
            ];
            
            // After creating the $data array, add this check:
            // Check if the email is unique for other employees (excluding current employee)
            if (!$this->sysAdminModel->isEmailUnique($data['email'], $data['user_id'])) {
                flash('employee_message', 'Email already exists. Please use a different email.', 'alert alert-danger');
                redirect('sysadmin/employeeManagement');
                return; // Important: Stop execution here to prevent the update
            }
            
            if ($this->sysAdminModel->updateEmployee($data)) {
                flash('employee_message', 'Employee updated successfully');
                redirect('sysadmin/employeeManagement');
            } else {
                flash('employee_message', 'Something went wrong', 'alert alert-danger');
                redirect('sysadmin/employeeManagement');
            }
        } else {
            redirect('sysadmin/employeeManagement');
        }
    }

    public function downloadCV($employee_id) {
        $employee = $this->sysAdminModel->getEmployeeById($employee_id);

        if ($employee && !empty($employee->cv_upload)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="CV_' . $employee->full_name . '.pdf"');
            echo $employee->cv_upload;
            exit;
        } else {
            flash('employee_message', 'CV not found', 'alert alert-danger');
            redirect('sysadmin/employeeManagement');
        }
    }

    public function deleteEmployee($id = null) {
        if ($id) {
            // Get the employee to find the user_id and user_role before deletion
            $employee = $this->sysAdminModel->getEmployeeById($id);

            if ($employee) {
                $user_id = $employee->user_id;
                $user_role = $employee->user_role;

                // Delete from related table based on user_role
                if ($user_role === 'cashier') {
                    $this->sysAdminModel->deleteCashier($id);
                } elseif ($user_role === 'branchmanager') {
                    $this->sysAdminModel->deleteBranchManager($id);
                } elseif ($user_role === 'headmanager') {
                    $this->sysAdminModel->deleteHeadManager($id);
                }

                // Delete from employee table
                if ($this->sysAdminModel->deleteEmployee($id)) {
                    // Then delete from users table if user_id exists
                    if ($user_id) {
                        $this->sysAdminModel->deleteUser($user_id);
                    }

                    flash('employee_message', 'Employee deleted successfully');
                    redirect('sysadmin/employeeManagement');
                } else {
                    flash('employee_message', 'Failed to delete employee', 'alert alert-danger');
                    redirect('sysadmin/employeeManagement');
                }
            }
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

    public function getEmployeeDetails($id) {
        $employee = $this->sysAdminModel->getEmployeeById($id);

        if ($employee) {
            echo json_encode($employee);
        } else {
            echo json_encode(['error' => 'Employee not found']);
        }
    }

    public function getBranches() {
        $branches = $this->sysAdminModel->getAllBranches();
        echo json_encode($branches);
    }

    public function checkEmailExists($email) {
        $email = urldecode($email);
        $exists = $this->sysAdminModel->findEmployeeByEmail($email);
        
        header('Content-Type: application/json');
        echo json_encode(['exists' => $exists]);
    }

    public function checkNicExists($nic)
    {
        // URL decode the NIC
        $nic = urldecode($nic);
        
        // Check if NIC exists
        $exists = $this->employeeModel->findEmployeeByNIC($nic);
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode(['exists' => !empty($exists)]);
    }

    public function checkBranchManagerExists($branchId)
    {
        // Check if branch manager exists for this branch
        $exists = $this->employeeModel->findBranchManagerByBranchId($branchId);
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode(['exists' => !empty($exists)]);
    }

    public function checkEmailExistsExcept($email, $employeeId) {
        $email = urldecode($email);
        $exists = $this->sysAdminModel->findEmployeeByEmailExcept($email, $employeeId);
        
        header('Content-Type: application/json');
        echo json_encode(['exists' => $exists]);
    }

    public function checkNicExistsExcept($nic, $employeeId)
    {
        // URL decode the NIC
        $nic = urldecode($nic);
        
        // Check if NIC exists except for this employee
        $exists = $this->employeeModel->findEmployeeByNICExcept($nic, $employeeId);
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode(['exists' => !empty($exists)]);
    }

    public function checkBranchManagerExistsExcept($branchId, $employeeId)
    {
        // Check if branch manager exists for this branch except for this employee
        $exists = $this->employeeModel->findBranchManagerByBranchIdExcept($branchId, $employeeId);
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode(['exists' => !empty($exists)]);
    }

    public function deactivateEmployee($id = null) {
        if ($id) {
            if ($this->sysAdminModel->deactivateEmployee($id)) {
                flash('employee_message', 'Employee deactivated successfully');
            } else {
                flash('employee_message', 'Failed to deactivate employee', 'alert alert-danger');
            }
        }
        redirect('sysadmin/employeeManagement');
    }

    public function reactivateEmployee($id = null) {
        if ($id) {
            if ($this->sysAdminModel->reactivateEmployee($id)) {
                flash('employee_message', 'Employee reactivated successfully');
            } else {
                flash('employee_message', 'Failed to reactivate employee', 'alert alert-danger');
            }
        }
        redirect('sysadmin/employeeManagement');
    }
}
?>
