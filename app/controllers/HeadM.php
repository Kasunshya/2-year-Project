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

    public function branchManager() {
        // Get the search query from the GET request
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Fetch branch managers based on the search query
        $branchManagers = $this->headManagerModel->getAllBranchManagers($search);

        $data = [
            'branchManagers' => $branchManagers
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
        // Get search parameters from the GET request
        $productName = isset($_GET['product_name']) ? trim($_GET['product_name']) : '';
        $branchId = isset($_GET['branch_id']) ? trim($_GET['branch_id']) : '';

        // Fetch inventory data based on the search parameters
        $inventoryData = $this->headManagerModel->getInventoryData($productName, $branchId);

        // Fetch all branches for the branch dropdown
        $branches = $this->headManagerModel->getAllBranches();

        $data = [
            'inventoryData' => $inventoryData,
            'branches' => $branches,
            'product_name' => $productName,
            'branch_id' => $branchId
        ];

        $this->view('HeadM/InventoryManagement', $data);
    }

    public function cashierManagement()
    {
        // Get search parameters from the GET request
        $nameEmail = isset($_GET['name_email']) ? trim($_GET['name_email']) : '';
        $branchId = isset($_GET['branch_id']) ? trim($_GET['branch_id']) : '';

        // Fetch cashiers based on the search parameters
        $cashiers = $this->headManagerModel->getCashiers($nameEmail, $branchId);

        // Fetch all branches for the branch dropdown
        $branches = $this->headManagerModel->getAllBranches();

        $data = [
            'cashiers' => $cashiers,
            'branches' => $branches,
            'name_email' => $nameEmail,
            'branch_id' => $branchId
        ];

        $this->view('HeadM/CashierManagement', $data);
    }

    public function productManagement() {
        $productName = isset($_GET['product_name']) ? trim($_GET['product_name']) : '';
        $categoryId = isset($_GET['category_id']) ? trim($_GET['category_id']) : '';
        $minPrice = isset($_GET['min_price']) ? trim($_GET['min_price']) : '';
        $maxPrice = isset($_GET['max_price']) ? trim($_GET['max_price']) : '';

        $products = $this->headManagerModel->searchProducts($productName, $categoryId, $minPrice, $maxPrice);
        $categories = $this->headManagerModel->getAllCategories();

        $data = [
            'products' => $products,
            'categories' => $categories
        ];

        $this->view('HeadM/ProductManagement', $data);
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_name' => trim($_POST['product_name']),
                'price' => trim($_POST['price']),
                'description' => trim($_POST['description']),
                'category_id' => trim($_POST['category_id']),
                'available_quantity' => trim($_POST['available_quantity'])
            ];

            if ($this->headManagerModel->addProduct($data)) {
                flash('product_message', 'Product added successfully');
                redirect('HeadM/productManagement');
            } else {
                flash('product_message', 'Something went wrong', 'alert alert-danger');
                redirect('HeadM/productManagement');
            }
        } else {
            redirect('HeadM/productManagement');
        }
    }

    public function editProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_id' => trim($_POST['product_id']),
                'product_name' => trim($_POST['product_name']),
                'price' => trim($_POST['price']),
                'description' => trim($_POST['description']),
                'category_id' => trim($_POST['category_id']),
                'available_quantity' => trim($_POST['available_quantity'])
            ];

            if ($this->headManagerModel->editProduct($data)) {
                flash('product_message', 'Product updated successfully');
                redirect('HeadM/productManagement');
            } else {
                flash('product_message', 'Something went wrong', 'alert alert-danger');
                redirect('HeadM/productManagement');
            }
        } else {
            redirect('HeadM/productManagement');
        }
    }

    public function getProductById($productId) {
        $product = $this->headManagerModel->getProductById($productId);
        echo json_encode($product);
    }

    public function deleteProduct($productId) {
        if ($this->headManagerModel->deleteProductById($productId)) {
            flash('product_message', 'Product deleted successfully');
            redirect('HeadM/productManagement');
        } else {
            flash('product_message', 'Something went wrong', 'alert alert-danger');
            redirect('HeadM/productManagement');
        }
    }

    public function customization()
    {
        // Fetch all customizations
        $customizations = $this->headManagerModel->getAllCustomizations();

        $data = [
            'customizations' => $customizations
        ];

        $this->view('HeadM/Customization', $data);
    }

    public function viewOrder() {
    // Get the search query from the GET request
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Fetch orders based on the search query
    $orders = $this->headManagerModel->getAllOrders($search);

    $data = [
        'orders' => $orders
    ];

    $this->view('HeadM/ViewOrder', $data);
}

    public function preOrder()
    {
        // Fetch all preorders
        $preOrders = $this->headManagerModel->getAllPreOrders();

        $data = [
            'preOrders' => $preOrders
        ];

        $this->view('HeadM/PreOrder', $data);
    }

    public function dailyBranchOrder() {
    // Fetch daily branch orders from the model
    $orders = $this->headManagerModel->getDailyBranchOrders();

    // Pass the data to the view
    $data = [
        'orders' => $orders
    ];

    $this->view('HeadM/DailyBranchOrder', $data);
}

    public function feedback() {
    // Get the search query from the GET request
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Fetch feedbacks based on the search query
    $feedbacks = $this->headManagerModel->getAllFeedbacks($search);

    $data = [
        'feedbacks' => $feedbacks
    ];

    $this->view('HeadM/Feedback', $data);
}

    public function downloadCV($employee_id) {
        // Fetch employee details using the model
        $employee = $this->headManagerModel->getEmployeeById($employee_id);
    
        if ($employee && !empty($employee->cv_upload)) {
            $filePath = UPLOADROOT . '/' . $employee->cv_upload;
    
            if (file_exists($filePath)) {
                // Serve the file for download
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($employee->cv_upload) . '"');
                header('Content-Length: ' . filesize($filePath));
                readfile($filePath);
                exit;
            }
        }
    
        // Redirect back if the CV file doesn't exist or there's an error
        flash('cv_error', 'CV file not found', 'alert alert-danger');
        redirect('HeadM/branchManager');
    }

    public function branches() {
        // Fetch all branches
        $branches = $this->headManagerModel->getAllBranches();
    
        $data = [
            'branches' => $branches
        ];
    
        $this->view('HeadM/Branches', $data);
    }

    public function branch($branch_id) {
    // Fetch branch details
    $branch = $this->headManagerModel->getBranchById($branch_id);

    // Check if branch exists
    if (!$branch) {
        die('Branch not found'); // Handle error if branch does not exist
    }

    // Fetch branch manager
    $branchManager = $this->headManagerModel->getBranchManagerByBranchId($branch_id);

    // Fetch cashiers related to the branch
    $cashiers = $this->headManagerModel->getCashiersByBranchId($branch_id);

    // Fetch sales data
    $filter = [
        'year' => $_GET['year'] ?? null,
        'month' => $_GET['month'] ?? null,
        'date' => $_GET['date'] ?? null
    ];
    $salesData = $this->headManagerModel->getSalesByBranch($branch_id, $filter);
    $totalSales = $this->headManagerModel->getTotalSalesByBranch($branch_id, $filter);

    $data = [
        'branch' => $branch,
        'branchManager' => $branchManager,
        'cashiers' => $cashiers,
        'salesData' => $salesData,
        'totalSales' => $totalSales->total_sales ?? 0
    ];

    $this->view('HeadM/Branch', $data); // Load the Branch view
}

}

?>
