<?php
class SysAdminP extends Controller {
    private $sysAdminModel;

    public function __construct() {
        // Initialize only the M_SysAdminP model
        $this->sysAdminModel = $this->model('M_SysAdminP');
    }

    public function index() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        redirect('sysadminp/profile');
    }

    public function categoryManagement() {
        $categories = $this->sysAdminModel->getAllCategories();
        
        $data = [
            'categories' => $categories,
            'name' => '',
            'name_err' => '',
            'description' => '',
            'description_err' => '',
            'image_err' => '',
            'title' => 'Category Management'
        ];
        
        $this->view('SysAdmin/CategoryManagement', $data);
    }

    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => '',
                'description_err' => '',
                'image_err' => '',
                'categories' => $this->sysAdminModel->getAllCategories() // Add this to maintain table data
            ];

            // Check if category name already exists
            if ($this->sysAdminModel->getCategoryByName($data['name'])) {
                $data['name_err'] = 'Category name already exists';
                // Return to the same page with error
                return $this->view('SysAdmin/CategoryManagement', $data);
            }

            // Handle image upload only if no errors
            if (empty($data['name_err'])) {
                $imageFile = $_FILES['category_image'] ?? null;
                $imagePath = null;
                
                if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
                    $imagePath = $this->sysAdminModel->uploadCategoryImage($imageFile);
                    if (!$imagePath) {
                        $data['image_err'] = 'Error uploading image';
                        return $this->view('SysAdmin/CategoryManagement', $data);
                    }
                }
                
                $data['image_path'] = $imagePath;

                if ($this->sysAdminModel->addCategory($data)) {
                    flash('category_message', 'Category Added Successfully');
                    redirect('sysadminp/categoryManagement');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('SysAdmin/CategoryManagement', $data);
            }
        } else {
            redirect('sysadminp/categoryManagement');
        }
    }

    public function updateCategory() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Handle image upload
                $data = [
                    'category_id' => $_POST['category_id'],
                    'name' => trim($_POST['name']),
                    'description' => trim($_POST['description']),
                    'image_path' => null
                ];

                // Handle image upload if provided
                if (!empty($_FILES['category_image']['name'])) {
                    $uploadDir = APPROOT . '/../public/img/categories/';
                    $fileName = time() . '_' . $_FILES['category_image']['name'];
                    $uploadPath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES['category_image']['tmp_name'], $uploadPath)) {
                        $data['image_path'] = $fileName;
                    }
                }

                if ($this->sysAdminModel->updateCategory($data)) {
                    // Fetch the updated category data
                    $updatedCategory = $this->sysAdminModel->getCategoryById($data['category_id']);
                    
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'category' => $updatedCategory
                    ]);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to update category'
                    ]);
                }
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
            exit;
        }
    }

    public function deleteCategory($id) {
        // Check if id exists
        if($id) {
            // Try to delete the category
            if($this->sysAdminModel->deleteCategory($id)) {
                flash('category_message', 'Category Deleted Successfully');
            } else {
                flash('category_message', 'Failed to delete category', 'alert alert-danger');
            }
        }
        
        // Redirect back to category management
        redirect('sysadminp/categoryManagement');
    }

    public function productManagement() {
        // Get all products and categories
        $products = $this->sysAdminModel->getAllProducts();
        $categories = $this->sysAdminModel->getAllCategories();
        
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        
        $this->view('SysAdmin/ProductManagement', $data);
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle file upload
            $image_path = '';
            
            // Check if the directory exists and is writable    
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
                //Define the APP_ROOT and join it with the image relative path
                $upload_dir = APP_ROOT.'/public/img/products/';
                $image_path = time() . '_' . $_FILES['product_image']['name'];
                //After uploading the image,it is sent to the tmp file of php and kept for a while and will be deleted (successfully receive or not it will be cleared from tmp file after a while)
                move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_dir . $image_path);
                

            }

            $data = [
                'product_name' => trim($_POST['product_name']),
                'description' => trim($_POST['description']),
                'price' => floatval($_POST['price']),
                'available_quantity' => intval($_POST['available_quantity']),
                'category_id' => intval($_POST['category_id']),
                'expiry_date' => !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null
            ];

            if ($this->sysAdminModel->addProduct($data, $image_path)) {
                flash('product_message', 'Product added successfully');
                redirect('SysAdminP/productManagement');
            } else {
                die('Something went wrong');
            }
        }
    }

    public function updateProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle file upload
            $image_path = null;
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
                $upload_dir = 'public/img/products/';
                $image_path = time() . '_' . $_FILES['product_image']['name'];
                move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_dir . $image_path);
            }

            $data = [
                'product_id' => $_POST['product_id'],
                'product_name' => trim($_POST['product_name']),
                'description' => trim($_POST['description']),
                'price' => floatval($_POST['price']),
                'available_quantity' => intval($_POST['available_quantity']),
                'category_id' => intval($_POST['category_id']),
                'expiry_date' => !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null
            ];

            if ($this->sysAdminModel->updateProduct($data, $image_path)) {
                flash('product_message', 'Product updated successfully');
                redirect('SysAdminP/productManagement');
            } else {
                die('Something went wrong');
            }
        }
    }

    public function deleteProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($this->sysAdminModel->deleteProduct($id)) {
                flash('product_message', 'Product deleted successfully');
                redirect('SysAdminP/productManagement');
            } else {
                die('Something went wrong');
            }
        }
    }

    public function searchProduct() {
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Get both products and categories for the view
        $products = $this->sysAdminModel->searchProducts($searchTerm);
        $categories = $this->sysAdminModel->getAllCategories();
        
        $data = [
            'products' => $products,
            'categories' => $categories,
            'search' => $searchTerm
        ];
        
        $this->view('SysAdmin/ProductManagement', $data);
    }

    public function branchManagement() {
        $branches = $this->sysAdminModel->getAllBranches();
        $data = [
            'branches' => $branches
        ];
        $this->view('SysAdmin/BranchManagement', $data);
    }

    public function addBranch() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize and validate input
            $data = [
                'branch_name' => trim($_POST['branch_name'] ?? ''),
                'branch_address' => trim($_POST['branch_address'] ?? ''),
                'branch_contact' => trim($_POST['branch_contact'] ?? '')
            ];

            // Validate required fields
            if (empty($data['branch_name']) || empty($data['branch_address']) || empty($data['branch_contact'])) {
                flash('branch_message', 'All fields are required', 'alert alert-danger');
                redirect('SysAdminP/branchManagement');
                return;
            }

            try {
                if ($this->sysAdminModel->addBranch($data)) {
                    flash('branch_message', 'Branch added successfully');
                } else {
                    flash('branch_message', 'Failed to add branch', 'alert alert-danger');
                }
            } catch (Exception $e) {
                flash('branch_message', 'Error: ' . $e->getMessage(), 'alert alert-danger');
            }
            
            redirect('SysAdminP/branchManagement');
        }
    }

    public function updateBranch() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize and validate input
            $data = [
                'branch_id' => $_POST['branch_id'] ?? null,
                'branch_name' => trim($_POST['branch_name'] ?? ''),
                'branch_address' => trim($_POST['branch_address'] ?? ''),
                'branch_contact' => trim($_POST['branch_contact'] ?? '')
            ];

            // Validate required fields
            if (!$data['branch_id'] || empty($data['branch_name']) || empty($data['branch_address']) || empty($data['branch_contact'])) {
                flash('branch_message', 'All fields are required', 'alert alert-danger');
                redirect('SysAdminP/branchManagement');
                return;
            }

            try {
                if ($this->sysAdminModel->updateBranch($data)) {
                    flash('branch_message', 'Branch updated successfully');
                } else {
                    flash('branch_message', 'Failed to update branch', 'alert alert-danger');
                }
            } catch (Exception $e) {
                flash('branch_message', 'Error: ' . $e->getMessage(), 'alert alert-danger');
            }
            
            redirect('SysAdminP/branchManagement');
        }
    }

    public function deleteBranch($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->sysAdminModel->deleteBranch($id)) {
                flash('branch_message', 'Branch deleted successfully');
                redirect('SysAdminP/branchManagement');
            } else {
                die('Something went wrong');
            }
        }
    }

    public function updateBranchStatus($branchId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = json_decode(file_get_contents("php://input"));
                
                if (!$data || !isset($data->status)) {
                    throw new Exception('Invalid data received');
                }
                
                // Convert boolean to string status
                $status = $data->status ? 'active' : 'inactive';
                
                if ($this->sysAdminModel->updateBranchStatus($branchId, $status)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Branch status updated successfully'
                    ]);
                } else {
                    throw new Exception('Failed to update branch status');
                }
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function customerManagement() {
        $customers = $this->sysAdminModel->getAllCustomers();
        $data = [
            'customers' => $customers
        ];
        $this->view('SysAdmin/CustomerManagement', $data);
    }

    public function promotionManagement() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle form submissions
            if (isset($_POST['promotion_id'])) {
                // This is an update request
                $this->updatePromotion();
            } else {
                // This is an add request
                $this->addPromotion();
            }
        }

        // Get all promotions and display the view
        $promotions = $this->sysAdminModel->getAllPromotions();
        $data = [
            'promotions' => $promotions
        ];
        $this->view('SysAdmin/PromotionManagement', $data);
    }

    public function addPromotion() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Initialize image name as empty
            $image_name = '';
            
            // Handle image upload
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // Create upload directory if it doesn't exist
                $uploadDir = APPROOT . '/../public/img/promotions/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Generate unique filename
                $imageFileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadPath = $uploadDir . $imageFileName;
                
                // Attempt to upload file
                if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $image_name = $imageFileName;
                } else {
                    flash('promotion_message', 'Failed to upload image', 'alert alert-danger');
                    redirect('SysAdminP/promotionManagement');
                    return;
                }
            }

            // Prepare data for database
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'discount_percentage' => floatval($_POST['discount_percentage']),
                'start_date' => trim($_POST['start_date']),
                'end_date' => trim($_POST['end_date']),
                'image_path' => $image_name,
                'is_active' => 1
            ];

            // Add promotion to database
            if($this->sysAdminModel->addPromotion($data)) {
                flash('promotion_message', 'Promotion Added Successfully');
            } else {
                flash('promotion_message', 'Something went wrong', 'alert alert-danger');
            }
            redirect('SysAdminP/promotionManagement');
        }
    }

    public function updatePromotion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the existing promotion to check current image
            $existingPromotion = $this->sysAdminModel->getPromotionById($_POST['id']);
            
            $data = [
                'id' => trim($_POST['id']),
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'discount_percentage' => floatval($_POST['discount_percentage']),
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'image_path' => $existingPromotion->image_path // Keep existing image path as default
            ];
            
            // Handle image upload if new image is provided
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = APPROOT . '/../public/img/promotions/';
                
                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $imageFileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadPath = $uploadDir . $imageFileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    // Delete old image if exists
                    if ($existingPromotion->image_path) {
                        $oldImagePath = $uploadDir . $existingPromotion->image_path;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $data['image_path'] = $imageFileName;
                } else {
                    flash('promotion_message', 'Failed to upload new image', 'alert alert-danger');
                    redirect('SysAdminP/promotionManagement');
                    return;
                }
            }
            
            // Update promotion in database
            if ($this->sysAdminModel->updatePromotion($data)) {
                flash('promotion_message', 'Promotion Updated Successfully');
            } else {
                flash('promotion_message', 'Something went wrong', 'alert alert-danger');
            }
            redirect('SysAdminP/promotionManagement');
        }
    }

    public function deletePromotion($id) {
        $promotion = $this->sysAdminModel->getPromotionById($id);
        if($promotion) {
            // Delete image if exists
            if($promotion->image_path) {
                $image_path = dirname(dirname(dirname(__FILE__))) . '/public/img/promotions/' . $promotion->image_path;
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            
            if($this->sysAdminModel->deletePromotion($id)) {
                flash('promotion_message', 'Promotion Removed Successfully');
            } else {
                flash('promotion_message', 'Something went wrong', 'error');
            }
        }
        redirect('SysAdminP/promotionManagement');
    }

    public function updatePromotionStatus($promotionId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the status from POST data
            $data = json_decode(file_get_contents("php://input"));
            
            if ($this->sysAdminModel->updatePromotionStatus($promotionId, $data->is_active)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    // Add this method to your SysAdminP class
    private function handleImageUpload($file, $folder = 'products') {
        $upload_dir = dirname(dirname(dirname(__FILE__))) . '/public/img/' . $folder . '/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!in_array($file['type'], $allowed_types)) {
            flash('promotion_message', 'Invalid file type. Only JPG, PNG and GIF are allowed.', 'error');
            return false;
        }

        // Generate unique filename
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $file_extension;
        $target_path = $upload_dir . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            return $filename;
        }

        return false;
    }

    public function profile() {
        // Check for logged in user
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        // Get user data
        $employee = $this->sysAdminModel->getEmployeeById($_SESSION['user_id']);
        
        $data = [
            'employee' => $employee,
            'title' => 'My Profile'
        ];

        $this->view('SysAdmin/Profile', $data);
    }
}
?>