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

    // Default method for SysAdmin controller
    public function index() {
        // Redirect to the dashboard or any default view
        $this->view('SysAdmin/Dashboard');
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

            // Handle CV upload
            $cvFileName = null;
            if (!empty($_FILES['cv_upload']['name'])) {
                $cvFileName = time() . '_' . $_FILES['cv_upload']['name']; // Add a timestamp to avoid duplicate file names
                $cvFilePath = UPLOADROOT . '/' . $cvFileName;

                if (!move_uploaded_file($_FILES['cv_upload']['tmp_name'], $cvFilePath)) {
                    flash('employee_message', 'Failed to upload CV', 'alert alert-danger');
                    redirect('sysadmin/employeeManagement');
                }
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
                'cv_upload' => $cvFileName, // Save the file name in the database
                'branch' => trim($_POST['branch']),
                'user_id' => null, // Set this based on your logic
                'user_role' => trim($_POST['user_role'])
            ];

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
        redirect('products/index');
    }

    public function branchmanagement() {
        $branchModel = $this->model('M_Branch');
        $branches = $branchModel->getAllBranches();
        
        $data = [
            'branches' => $branches
        ];
        
        $this->view('SysAdmin/BranchManagement', $data);
    }

 

    public function categorymanagement() {
        $this->view('SysAdmin/CategoryManagement');
    }
}
?>