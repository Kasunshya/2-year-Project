<?php
class Customer extends Controller {
    public function __construct() {
        $this->customerModel = $this->model('M_Customer');
    }

    public function index() {
        $customers = $this->customerModel->getAllCustomers();
        $data = [
            'customers' => $customers
        ];
        $this->view('Customer/v_customerList', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'full_name' => trim($_POST['full_name']),
                'address' => trim($_POST['address']),
                'contact_no' => trim($_POST['contact_no']),
                'errors' => []
            ];

            // Validate inputs
            if (empty($data['full_name'])) {
                $data['errors']['full_name'] = 'Please enter the full name.';
            }
            if (empty($data['address'])) {
                $data['errors']['address'] = 'Please enter the address.';
            }
            if (empty($data['contact_no'])) {
                $data['errors']['contact_no'] = 'Please enter the contact number.';
            }

            if (empty($data['errors'])) {
                if ($this->customerModel->addCustomer($data)) {
                    redirect('Customer');
                } else {
                    die('Something went wrong.');
                }
            } else {
                $this->view('Customer/v_addCustomer', $data);
            }
        } else {
            $data = [
                'full_name' => '',
                'address' => '',
                'contact_no' => '',
                'errors' => []
            ];
            $this->view('Customer/v_addCustomer', $data);
        }
    }

    public function delete($id) {
        if ($this->customerModel->deleteCustomer($id)) {
            redirect('Customer');
        } else {
            die('Something went wrong.');
        }
    }

    public function customer(){
        $this->view('BranchM/v_BranchMdashboard');
    }
}
?>
