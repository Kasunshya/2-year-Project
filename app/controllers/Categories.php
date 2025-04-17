<?php
class Categories extends Controller
{
    public function __construct()
    {
        $this->categoryModel = $this->model('M_Category');
    }

    public function index()
    {
        // Fetch all categories from the database
        $categories = $this->categoryModel->getAllCategories();

        // Pass data to the view
        $data = [
            'categories' => $categories
        ];

        $this->view('SysAdmin/CategoryManagement', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'category_name' => trim($_POST['category_name']),
                'description' => trim($_POST['description'])
            ];
            if ($this->categoryModel->addCategory($data)) {
                flash('category_message', 'Category successfully added');
                redirect('categories/index');
            } else {
                die('Something went wrong.');
            }
        } else {
            redirect('categories/index');
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            // Prepare data
            $data = [
                'category_id' => $id,
                'category_name' => trim($_POST['category_name']),
                'description' => trim($_POST['description'])
            ];

            // Update category in the database
            if ($this->categoryModel->updateCategory($data)) {
                flash('category_message', 'Category successfully updated');
                redirect('categories/index');
            } else {
                die('Something went wrong while updating the category.');
            }
        } else {
            redirect('categories/index');
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Add error logging
            error_log('Attempting to delete category with ID: ' . $id);
            
            if ($this->categoryModel->deleteCategory($id)) {
                flash('category_message', 'Category Deleted Successfully');
                redirect('categories/index');  // Changed from sysadmin/categorymanagement
            } else {
                flash('category_message', 'Failed to delete category. It may be in use.', 'alert alert-danger');
                redirect('categories/index');
            }
        } else {
            redirect('categories/index');
        }
    }
}
?>