<?php
class SysAdmin extends Controller {
    private $sysAdminModel;

    public function __construct() {
        $this->sysAdminModel = $this->model('M_SysAdmin');
    }

    // Default method for SysAdmin controller
    public function index() {
        // Redirect to the dashboard or any default view
        $this->view('SysAdmin/Dashboard');
    }

    public function dashboard() {
        $this->view('SysAdmin/Dashboard');
    }

    public function employeemanagement() {
        $this->view('SysAdmin/EmployeeManagement');
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