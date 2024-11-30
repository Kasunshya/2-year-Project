<?php
class SysAdmin extends Controller {
    private $customerModel;

    public function dashboard()
    {
        $this->view('SysAdmin/Dashboard');
    }

    public function customerManagement()
    {
        $this->view('SysAdmin/CustomerManagement');
    }

    public function productManagement()
    {
        $this->view('SysAdmin/ProductManagement');
    }

    public function UserManagement()
    {
        $this->view('SysAdmin/UserManagement');
    }
}
