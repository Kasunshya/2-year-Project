<?php
class Branches extends Controller {
    public function __construct() {
        $this->branchModel = $this->model('M_Branch');
    }

    public function index() {
        $branches = $this->branchModel->getAllBranches();
        $data = [
            'branches' => $branches
        ];
        $this->view('SysAdmin/BranchManagement', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'branch_name' => trim($_POST['branch_name']),
                'branch_address' => trim($_POST['branch_address']),
                'branch_contact' => trim($_POST['branch_contact'])
            ];

            if ($this->branchModel->addBranch($data)) {
                flash('branch_message', 'Branch Added');
                redirect('sysadmin/branchmanagement');
            } else {
                die('Something went wrong');
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'branch_id' => trim($_POST['branch_id']),
                'branch_name' => trim($_POST['branch_name']),
                'branch_address' => trim($_POST['branch_address']),
                'branch_contact' => trim($_POST['branch_contact'])
            ];

            // Add error logging
            error_log('Updating branch: ' . print_r($data, true));

            if ($this->branchModel->updateBranch($data)) {
                flash('branch_message', 'Branch Updated');
                redirect('sysadmin/branchmanagement');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('sysadmin/branchmanagement');
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->branchModel->deleteBranch($id)) {
                flash('branch_message', 'Branch Removed');
                redirect('sysadmin/branchmanagement');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('sysadmin/branchmanagement');
        }
    }
}
?>