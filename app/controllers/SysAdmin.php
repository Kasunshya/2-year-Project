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

    public function updateEmployee() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $cvFileName = '';
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
                'password' => trim($_POST['password']), // Optional
                'join_date' => trim($_POST['join_date']),
                'cv_upload' => $cvFileName, // Optional
                'branch_id' => trim($_POST['branch_id']),
                'user_role' => trim($_POST['user_role']),
            ];

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
}
?>