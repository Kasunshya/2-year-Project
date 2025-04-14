<?php

class HeadM extends Controller
{
    private $cashierModel;
    private $headManagerModel;

    public function __construct()
    {
        $this->cashierModel = $this->model('M_Cashier');
        $this->headManagerModel = $this->model('M_HeadM');
    }

    /*public function index()
    {
        $totalCashiers = $this->headManagerModel->getTotalCashiers();
        $totalCustomers = $this->headManagerModel->getTotalCustomers();

        $data = [
            'totalCashiers' => $totalCashiers,
            'totalCustomers' => $totalCustomers,
        ];


        $this->view('HeadM/dashboard');
    }*/

    public function supplierManagement()
    {
        $this->view('HeadM/SupplierManagement');
    }

    public function branchManager()
    {
        $branchManagers = $this->headManagerModel->getAllBranchManagers();
        $branches = $this->headManagerModel->getAllBranches();
        $data = [
            'branchManagers' => $branchManagers,
            'branches' => $branches
        ];
        $this->view('HeadM/BranchManagers', $data);
    }

    public function addBranchManager()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'branch_id' => trim($_POST['branch_id']),
                'branchmanager_name' => trim($_POST['branchmanager_name']),
                'address' => trim($_POST['address']),
                'email' => trim($_POST['email']),
                'contact_number' => trim($_POST['contact_number']),
                'password' => trim($_POST['password'])
            ];

            if ($this->headManagerModel->addBranchManager($data)) {
                echo "<script>alert('Branch Manager added successfully!');</script>";
                $this->redirect('HeadM/branchManager');
            } else {
                echo "<script>alert('Something went wrong!');</script>";
            }
        }
    }

    public function editBranchManager()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'branchmanager_id' => $_POST['branchmanager_id'],
                'user_id' => $_POST['user_id'],
                'branch_id' => $_POST['branch_id'],
                'branchmanager_name' => $_POST['branchmanager_name'],
                'address' => $_POST['address'],
                'email' => $_POST['email'],
                'contact_number' => $_POST['contact_number'],
                'password' => $_POST['password']
            ];

            if ($this->headManagerModel->updateBranchManager($data)) {
                $this->redirect('HeadM/branchManager');
            }
        }
        // If not POST request, redirect to branch manager page
        $this->redirect('HeadM/branchManager');
    }
    
    public function deleteBranchManager()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'branchmanager_id' => $_POST['branchmanager_id']
            ];
            if ($this->headManagerModel->deleteBranchManager($data)) {
                echo "<script>alert('Branch Manager deleted successfully!');</script>";
                $this->redirect('HeadM/branchManager');
            } else {
                echo "<script>alert('Something went wrong!');</script>";
            }
        }
    }

    private function redirect($url)
    {
        header('Location: ' . URLROOT . '/' . $url);
        exit();
    }

    public function dashboard()
    {
        $totalCashiers = $this->headManagerModel->getTotalCashiers();
        $totalCustomers = $this->headManagerModel->getTotalCustomers();
        $totalBranchManagers = $this->headManagerModel->getTotalBranchManagers();


        $data = [
            'totalCashiers' => $totalCashiers,
            'totalCustomers' => $totalCustomers,
            'totalBranchManagers' => $totalBranchManagers
        ];
        $this->view('HeadM/Dashboard',$data);
    }

    public function inventoryManagement()
    {
        $this->view('HeadM/InventoryManagement');
    }

    public function cashierManagement()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($search)) {
            $cashiers = $this->headManagerModel->searchCashiers($search);
        } else {
            $cashiers = $this->headManagerModel->getAllCashiers();
        }

        // Debugging: Log the data to check if nic, address, and branch are present
        error_log(print_r($cashiers, true));

        $data = [
            'cashiers' => $cashiers
        ];

        $this->view('HeadM/CashierManagement', $data);
    }

    public function productManagement()
    {
        $this->view('HeadM/ProductManagement');
    }

    public function customization()
    {
        $this->view('HeadM/Customization');
    }

    public function viewOrder()
    {
        $this->view('HeadM/ViewOrder');
    }

    public function preOrder()
    {
        $this->view('HeadM/PreOrder');
    }

    public function dailyBranchOrder()
    {
        $this->view('HeadM/DailyBranchOrder');
    }

    public function feedback()
    {
        $this->view('HeadM/Feedback');
    }

    public function downloadCV($employee_id)
    {
        $cashier = $this->headManagerModel->getCashierById($employee_id);

        if ($cashier && !empty($cashier->cv_upload)) {
            $filePath = UPLOADROOT . '/' . $cashier->cv_upload;

            if (file_exists($filePath)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                readfile($filePath);
                exit;
            } else {
                flash('cashier_message', 'CV file not found on the server', 'alert alert-danger');
                redirect('HeadM/cashierManagement');
            }
        } else {
            flash('cashier_message', 'CV not found in the database', 'alert alert-danger');
            redirect('HeadM/cashierManagement');
        }
    }
}
?>