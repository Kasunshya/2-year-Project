<?php
class Products extends Controller {
    public function __construct() {
        $this->productModel = $this->model('M_Product');
        $this->categoryModel = $this->model('M_Category');
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getAllCategories();
        
        $data = [
            'products' => $products,
            'categories' => $categories
        ];

        $this->view('SysAdmin/ProductManagement', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_name' => trim($_POST['product_name']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'available_quantity' => trim($_POST['available_quantity']),
                'category_id' => trim($_POST['category_id']),
                'status' => isset($_POST['status']) ? 1 : 0
            ];

            if ($this->productModel->addProduct($data)) {
                flash('product_message', 'Product Added Successfully');
                redirect('products/index');
            } else {
                die('Something went wrong');
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_id' => $_POST['product_id'],
                'product_name' => trim($_POST['product_name']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'available_quantity' => trim($_POST['available_quantity']),
                'category_id' => trim($_POST['category_id']),
                'status' => isset($_POST['status']) ? 1 : 0
            ];

            if ($this->productModel->updateProduct($data)) {
                flash('product_message', 'Product Updated Successfully');
                redirect('products/index');
            } else {
                die('Something went wrong');
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->productModel->deleteProduct($id)) {
                flash('product_message', 'Product Removed');
                redirect('products/index');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('products/index');
        }
    }

    public function search() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['term'])) {
            $searchTerm = trim($_GET['term']);
            $products = $this->productModel->searchProducts($searchTerm);
            echo json_encode($products);
        }
    }
}