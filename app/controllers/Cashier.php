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
    //$this->view('Cashier/v_Servicedesk');
    $products = $this->CashierModel->getProducts(); // Fetch products from the model
    $this->view('Cashier/v_Servicedesk', ['products' => $products]); // Pass to view
  }
  public function cashierdashboard(){
    $this->view('Cashier/v_CashierDashboard');
  }

  // Add this to your Cashier.php controller
public function search() {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
      $searchTerm = trim($_POST['search']);
      $products = $this->CashierModel->searchProducts($searchTerm);
      $this->view('Cashier/v_Servicedesk', ['products' => $products]);
  } else {
      $this->servicedesk();
  }
}


}