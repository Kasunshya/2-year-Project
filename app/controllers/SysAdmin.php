<?php
class SysAdmin extends Controller {
    private $sysAdminModel;

    public function __construct() {
        $this->sysAdminModel = $this->model('M_SysAdmin');
    }

    public function dashboard() {
        $this->view('SysAdmin/Dashboard');
    }

    // Customer Management Methods
    public function customerManagement() {
        $customers = $this->sysAdminModel->getAllCustomers();
        $data = [
            'customers' => $customers
        ];
        $this->view('SysAdmin/CustomerManagement', $data);
    }

    public function addCustomer() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'full_name' => trim($_POST['full_Name']),
                'address' => trim($_POST['address']),
                'contact_no' => trim($_POST['contact_No']),
                'email' => trim($_POST['email'])
            ];

            if ($this->sysAdminModel->addCustomer($data)) {
                echo "<script>alert('Customer added successfully!');</script>";
                $this->redirect('SysAdmin/customerManagement');
            } else {
                echo "<script>alert('Something went wrong!');</script>";
            }
        }
    }

    public function editCustomer() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'customer_id' => $_POST['customer_ID'],
                'full_name' => trim($_POST['full_Name']),
                'address' => trim($_POST['address']),
                'contact_no' => trim($_POST['contact_No']),
                'email' => trim($_POST['email'])
            ];

            if ($this->sysAdminModel->updateCustomer($data)) {
                $this->redirect('SysAdmin/customerManagement');
            }
        }
    }

    public function deleteCustomer() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['customer_ID'];
            if ($this->sysAdminModel->deleteCustomer($id)) {
                echo "<script>alert('Customer deleted successfully!');</script>";
                $this->redirect('SysAdmin/customerManagement');
            }
        }
    }

    // Product Management Methods
    public function productManagement() {
        $products = $this->sysAdminModel->getAllProducts();
        $data = [
            'products' => $products
        ];
        $this->view('SysAdmin/ProductManagement', $data);
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'product_name' => trim($_POST['product_name']),
                'price' => trim($_POST['price']),
                'quantity' => trim($_POST['quantity'])
            ];

            if ($this->sysAdminModel->addProduct($data)) {
                echo "<script>alert('Product added successfully!');</script>";
                $this->redirect('SysAdmin/ProductManagement');
            }
        }
    }

    public function editProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'product_id' => $_POST['product_id'],
                'product_name' => trim($_POST['product_name']),
                'price' => trim($_POST['price']),
                'quantity' => trim($_POST['quantity'])
            ];

            if ($this->sysAdminModel->updateProduct($data)) {
                $this->redirect('SysAdmin/ProductManagement');
            }
        }
    }

    public function deleteProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['product_id'];
            if ($this->sysAdminModel->deleteProduct($id)) {
                echo "<script>alert('Product deleted successfully!');</script>";
                $this->redirect('SysAdmin/ProductManagement');
            }
        }
    }

    // User Management Methods
    public function userManagement() {
        $users = $this->sysAdminModel->getAllUsers();
        $data = [
            'users' => $users
        ];
        $this->view('SysAdmin/UserManagement', $data);
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'full_name' => trim($_POST['full_name']),
                'address' => trim($_POST['address']),
                'contact_no' => trim($_POST['contact_no']),
                'user_role' => trim($_POST['user_role'])
            ];

            if ($this->sysAdminModel->addUser($data)) {
                echo "<script>alert('User added successfully!');</script>";
                $this->redirect('SysAdmin/UserManagement');
            }
        }
    }

    public function editUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'employee_id' => $_POST['employee_id'],
                'full_name' => trim($_POST['full_name']),
                'address' => trim($_POST['address']),
                'contact_no' => trim($_POST['contact_no']),
                'user_role' => trim($_POST['user_role'])
            ];

            if ($this->sysAdminModel->updateUser($data)) {
                $this->redirect('SysAdmin/UserManagement');
            }
        }
    }

    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['employee_id'];
            if ($this->sysAdminModel->deleteUser($id)) {
                echo "<script>alert('User deleted successfully!');</script>";
                $this->redirect('SysAdmin/UserManagement');
            }
        }
    }

    private function redirect($url) {
        header('Location: ' . URLROOT . '/' . $url);
        exit();
    }
}
