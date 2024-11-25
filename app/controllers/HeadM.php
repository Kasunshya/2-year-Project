<?php
class HeadM extends Controller {
    private $cashierModel;

    public function __construct() {
        $this->cashierModel = $this->model('M_Cashier');
    }

    public function customermanagement() {
        $this->view('HeadM/CustomerManagement');
    }

    public function supplierManagement() {
        $this->view('HeadM/SupplierManagement');
    }

    public function branchManager() {
        $this->view('HeadM/BranchManagers');
    }

    public function dashboard() {
        $this->view('HeadM/Dashboard');
    }

    public function inventoryManagement() {
        $this->view('HeadM/InventoryManagement');
    }

    public function cashierManagement() {
        $this->view('HeadM/CashierManagement');
    }
}
?>