<?php
class HeadM extends Controller {

    public function __construct() {
        $this->cashierModel = $this->model('M_Cashier');
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

    public function productManagement() {
        $this->view('HeadM/ProductManagement');
    }

    public function customization() {
        $this->view('HeadM/Customization');
    }

    public function viewOrder() {
        $this->view('HeadM/ViewOrder');
    }

    public function preOrder() {
        $this->view('HeadM/PreOrder');
    }

    public function dailyBranchOrder() {
        $this->view('HeadM/DailyBranchOrder');
    }

    public function feedback() {
        $this->view('HeadM/Feedback');
    }
}
?>