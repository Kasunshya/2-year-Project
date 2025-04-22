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
        // Get the search term from the GET request
        $customerName = isset($_GET['customer_name']) ? trim($_GET['customer_name']) : '';

        // Fetch customizations based on the search term
        $customizations = $this->headManagerModel->getCustomizations($customerName);

        $data = [
            'customizations' => $customizations,
            'customer_name' => $customerName
        ];

        $this->view('HeadM/Customization', $data);
    }

    public function viewOrder()
    {
        // Get search and filter parameters from the GET request
        $filters = [
            'customer_name' => isset($_GET['customer_name']) ? trim($_GET['customer_name']) : '',
            'payment_method' => isset($_GET['payment_method']) ? trim($_GET['payment_method']) : '',
            'order_type' => isset($_GET['order_type']) ? trim($_GET['order_type']) : '',
            'branch_id' => isset($_GET['branch_id']) ? trim($_GET['branch_id']) : '',
            'date' => isset($_GET['date']) ? trim($_GET['date']) : '',
            'month' => isset($_GET['month']) ? trim($_GET['month']) : '',
            'year' => isset($_GET['year']) ? trim($_GET['year']) : ''
        ];

        // Fetch orders based on the filters
        $orders = $this->headManagerModel->getOrders($filters);

        // Fetch all branches for the branch dropdown
        $branches = $this->headManagerModel->getAllBranches();

        $data = [
            'orders' => $orders,
            'branches' => $branches,
            'filters' => $filters
        ];

        $this->view('HeadM/ViewOrder', $data);
    }

    public function preOrder()
    {
        // Get search term from GET request
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Get filtered results
        $data['preOrders'] = $this->headManagerModel->getPreOrders($search);
        
        // Load view with data
        $this->view('HeadM/PreOrder', $data);
    }

    public function dailyBranchOrder()
    {
        // Get the selected branch ID from the GET request
        $branchId = isset($_GET['branch_id']) ? trim($_GET['branch_id']) : '';

        // Fetch branch orders based on the selected branch
        $orders = $this->headManagerModel->getDailyBranchOrders($branchId);

        // Fetch all branches for the dropdown
        $branches = $this->headManagerModel->getAllBranches();

        $data = [
            'orders' => $orders,
            'branches' => $branches,
            'branch_id' => $branchId
        ];

        $this->view('HeadM/DailyBranchOrder', $data);
    }

    public function feedback()
    {
        // Enable error reporting for debugging
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $productName = isset($_GET['product_name']) ? trim($_GET['product_name']) : '';
        $data['feedbacks'] = $this->headManagerModel->getFeedbacks($productName);
        
        // Debug data
        error_log("Feedback Data: " . print_r($data, true));
        
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
        die('Branch not found');
    }

    // Fetch branch manager and cashiers
    $branchManager = $this->headManagerModel->getBranchManagerByBranchId($branch_id);
    $cashiers = $this->headManagerModel->getCashiersByBranchId($branch_id);

    // Prepare filters for sales data based on request
    $filters = [];
    
    // Handle date filter (daily report)
    if (isset($_GET['date']) && !empty($_GET['date'])) {
        $filters['date'] = $_GET['date'];
    } 
    // Handle month and year filter (monthly report)
    else if (isset($_GET['month']) && !empty($_GET['month'])) {
        $filters['month'] = $_GET['month'];
        $filters['year'] = isset($_GET['year']) ? $_GET['year'] : date('Y');
    } 
    // Handle year filter (yearly report)
    else if (isset($_GET['year']) && !empty($_GET['year'])) {
        $filters['year'] = $_GET['year'];
    }

    // Fetch sales data with filters
    $salesData = $this->headManagerModel->getSalesByBranch($branch_id, $filters);
    
    // Calculate total sales
    $totalSalesObj = $this->headManagerModel->getTotalSalesByBranch($branch_id, $filters);
    $totalSales = $totalSalesObj ? $totalSalesObj->total_sales : 0;

    $data = [
        'branch' => $branch,
        'branchManager' => $branchManager,
        'cashiers' => $cashiers,
        'salesData' => $salesData,
        'totalSales' => $totalSales,
        'filters' => $filters
    ];

    $this->view('HeadM/Branch', $data);
}

}

?>
