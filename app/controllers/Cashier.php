<?php 
class Cashier extends Controller {
  
    public function __construct() {
        $this->CashierModel = $this->model('M_Cashier');
    }
    public function payment() {
      $this->view('Cashier/v_Payment');
  }
  public function transaction(){
    $this->view('Cashier/v_Transaction');
  }
  public function servicedesk(){
    $this->view('Cashier/v_Servicedesk');
  }
  public function cashierdashboard(){
    $this->view('Cashier/v_CashierDashboard');
  }
  }