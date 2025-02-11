<?php
class SysAdmin extends Controller {
    private $sysAdminModel;

    public function __construct() {
        $this->sysAdminModel = $this->model('M_SysAdmin');
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