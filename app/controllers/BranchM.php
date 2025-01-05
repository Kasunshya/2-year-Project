<?php 
class BranchM extends Controller {
    public function __construct() {
        $this->CashierModel = $this->model('M_Cashier');
        $this->UserModel = $this->model('User'); 
        $this->branchMModel = $this->model('M_BranchM');

    }

    public function index() {
        // Pass the data to the view
        // Initialize $data with default empty values
        $data = [
            'Name' => '',
            'Contact' => '',
            'Address' => '',
            'Email' => '',
            'Join_Date' => '',
            'Password' => '',
            'Name_err' => '',
            'Contact_err' => '',
            'Address_err' => '',
            'Email_err' => '',
            'Join_Date_err' => '',
            'Password_err' => ''
           
        ];
        $this->view('BranchM/v_addCashier', $data);
    }
    public function addCashier() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'cashier_name' => trim($_POST['cashier_name']),
                'contacts' => trim($_POST['contacts']),
                'address' => trim($_POST['address']),
                'join_date' => trim($_POST['join_date']),
                'branch_name' => trim($_POST['branch_name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'cashier_name_err' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate inputs
            if (empty($data['cashier_name'])) $data['cashier_name_err'] = 'Cashier name is required';
            if (empty($data['email'])) $data['email_err'] = 'Email is required';
            //if (empty($data['password'])) $data['password_err'] = 'Password is required';



            if (empty($data['cashier_name_err']) && empty($data['email_err']) && empty($data['password_err'])) {
                // Add user to users table
                $userId = $this->UserModel->addUser([
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'role' => 'cashier'
                ]);

                if ($userId) {
                    // Add cashier details to cashier table
                    $data['id'] = $userId; // Pass the user's id as foreign key
                    if ($this->CashierModel->addCashier($data)) {
                        header('location: ' . URLROOT . '/BranchM/addCashier?success=true');
                    } else {
                        die('Failed to add cashier to cashier table.');
                    }
                } else {
                    die('Failed to add cashier to users table.');
                }
            } else {
                $this->view('BranchM/v_addCashier', $data);
            }
        } else {
            // Load empty form
            $data = [
                'cashier_name' => '',
                'contacts' => '',
                'address' => '',
                'join_date' => '',
                'branch_name' => '',
                'email' => '',
                'password' => '',
                'cashier_name_err' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->view('BranchM/v_addCashier', $data);
}
}

public function viewCashiers() {
    // Get all cashiers from the model
    $cashiers = $this->CashierModel->getCashiers();

    // Pass data to the view
    $data = [
        'cashiers' => $cashiers
    ];

    $this->view('BranchM/v_editTable',$data);
}
public function DailyOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            // Populate $data array with sanitized inputs
            $data = [
                'branchid' => trim($_POST['branchid']),
                'branchname' => trim($_POST['branchname']),
                'date' => trim($_POST['date']),
                'orderdescription' => trim($_POST['orderdescription']),
                'branchid_err' => '',
                'branchname_err' => '',
                'date_err' => '',
                'orderdescription_err' => ''
            ];
    
            // Validate each input
            if (empty($data['branchid'])) {
                $data['branchid_err'] = 'Please enter the branch ID';
            }
            if (empty($data['branchname'])) {
                $data['branchname_err'] = 'Please enter the branch name';
            }
            if (empty($data['date'])) {
                $data['date_err'] = 'Please select a date';
            }
            if (empty($data['orderdescription'])) {
                $data['orderdescription_err'] = 'Please provide an order description';
            }
    
            // Check for no errors
            if (empty($data['branchid_err']) && empty($data['branchname_err']) && empty($data['date_err']) && empty($data['orderdescription_err'])) {
                // Perform database action if needed
                {
                    die('Something went wrong while saving the order');
                }
            } else {
                // Reload form with errors and input data
                $this->view('BranchM/v_DailyOrder', $data);
            }
        } else {
            // Load the form with default values for a GET request
            $data = [
                'branchid' => '',
                'branchname' => '',
                'date' => '',
                'orderdescription' => '',
                'branchid_err' => '',
                'branchname_err' => '',
                'date_err' => '',
                'orderdescription_err' => ''
            ];
            $this->view('BranchM/v_DailyOrder', $data);
        }

    }
public function salesReport() {

    // Pass the data to the view
    $this->view('BranchM/v_salesReport');
}
public function updateCashier($cashierId) {
    // Fetch cashier details by ID
    $cashier = $this->CashierModel->getCashierById($cashierId); // Corrected to use the model's method

    if ($cashier) {
        // Prepare data for the view
        $data = [
            'cashier_id' => $cashier->cashier_id,  // Pass cashier_id to the view
            'cashier_name' => $cashier->cashier_name,
            'contacts' => $cashier->contacts,
            'address' => $cashier->address,
            'join_date' => $cashier->join_date,
            'branch_name' => $cashier->branch_name,
        ];

        // Load the update cashier view with the data
        $this->view('BranchM/v_updateCashier', $data);
    } else {
        // Redirect if cashier not found
        redirect('BranchM/viewCashiers');
    }
}

public function updateCashierSubmit($cashierId) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and prepare POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'cashier_id' => $cashierId,
            'cashier_name' => trim($_POST['cashier_name']),
            'address' => trim($_POST['address']),
            'contacts' => trim($_POST['contact']),
            'join_date' => trim($_POST['join_date']),
            'branch_name' => trim($_POST['branch_name']),
        ];

        // Update the cashier in the database using the model
        if ($this->branchMModel->updateCashier($data)) {
            // Redirect after success
            header('Location: ' . URLROOT . '/BranchM/viewCashiers?success=true');
        } else {
            // Handle failure
            die('Failed to update cashier');
        }
    }
}

public function deleteCashier($cashier_id) {
    // Ensure the user has confirmation before deletion
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Delete the cashier using the model
        if ($this->CashierModel->deleteCashier($cashier_id)) {
            // Redirect after successful deletion
            header('location: ' . URLROOT . '/BranchM/viewCashiers?success=true');
            exit;
        } else {
            die('Something went wrong.');
        }
    }
}
public function branchmdashboard(){
    $this->view('BranchM/v_BranchMdashboard');
}

}
?>