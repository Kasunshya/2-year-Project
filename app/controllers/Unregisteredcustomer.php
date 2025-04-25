<?php
class Unregisteredcustomer extends Controller {
    private $unregisteredCustomerModel;

    public function __construct() {
        $this->unregisteredCustomerModel = $this->model('UnregisteredCustomerModel');
    }

    // Add this index method
    public function index() {
        // Redirect to homepage by default
        redirect('unregisteredcustomer/unregisteredcustomerhomepage');
    }

    public function unregisteredcustomerhomepage() {
        $latestProducts = $this->unregisteredCustomerModel->getLatestProducts();
        $activePromotions = $this->unregisteredCustomerModel->getActivePromotions();
        
        $data = [
            'products' => $latestProducts,
            'promotions' => $activePromotions
        ];

        $this->view('UnregisteredCustomer/unregisteredcustomerhomepage', $data);
    }

    public function unregisteredcustomerproducts() {
        $filters = [
            'category' => isset($_GET['category']) ? $_GET['category'] : null,
            'min_price' => isset($_GET['min_price']) ? $_GET['min_price'] : null,
            'max_price' => isset($_GET['max_price']) ? $_GET['max_price'] : null
        ];
        
        $products = $this->unregisteredCustomerModel->getAllProducts($filters);
        $categories = $this->unregisteredCustomerModel->getCategories();
        
        $data = [
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters
        ];
        
        $this->view('UnregisteredCustomer/unregisteredcustomerproducts', $data);
    }

    public function unregisteredcustomercart(){
        $data = [];

        $this->view('UnregisteredCustomer/unregisteredcustomercart');

    }

    public function submitEnquiry() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email_address' => trim($_POST['email_address']),
                'phone_number' => trim($_POST['phone_number']),
                'message' => trim($_POST['message'])
            ];

            if ($this->unregisteredCustomerModel->submitEnquiry($data)) {
                $response = [
                    'status' => 'success',
                    'message' => 'Your enquiry has been submitted successfully!'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Something went wrong. Please try again.'
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
}