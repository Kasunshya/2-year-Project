<?php 
class BranchM extends Controller {
    public function __construct() {
        $this->BranchMModel = $this->model('M_BranchM');
    }

    public function index() {
        
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

            // Populate $data array with sanitized inputs
            $data = [
                'Name' => trim($_POST['Name']),
                'Contact' => trim($_POST['Contact']),
                'Address' => trim($_POST['Address']),
                'Email' => trim($_POST['Email']),
                'Join_Date' => trim($_POST['Join_Date']),
                'Password' => trim($_POST['Password']),
                'Name_err' => '',
                'Contact_err' => '',
                'Address_err' => '',
                'Email_err' => '',
                'Join_Date_err' => '',
                'Password_err' => ''
            ];

            // Validate each input
            if (empty($data['Name'])) {
                $data['Name_err'] = 'Please enter a name';
            }
            if (empty($data['Contact'])) {
                $data['Contact_err'] = 'Please enter contact details';
            }
            if (empty($data['Address'])) {
                $data['Address_err'] = 'Please enter an address';
            }
            if (empty($data['Email'])) {
                $data['Email_err'] = 'Please enter an email address';
            }
            if (empty($data['Join_Date'])) {
                $data['Join_Date_err'] = 'Please enter a join date';
            }
            if (empty($data['Password'])) {
                $data['Password_err'] = 'Please enter a password';
            }

            // Check for no errors
            if (empty($data['Name_err']) && empty($data['Contact_err']) && empty($data['Address_err']) && empty($data['Email_err']) && empty($data['Join_Date_err']) && empty($data['Password_err'])) {
                // Save data to database
                if ($this->BranchMModel->addCashier($data)) {
                    // Redirect on success
                    header('Location: ' . URLROOT . '/BranchM/index');
                    exit;
                } else {
                    die('Something went wrong');
                }
            } else {
                // Reload form with errors and input data
                $this->view('BranchM/v_addCashier', $data);
            }
        } else {
            // Load the form with default values for a GET request
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
                if ($this->BranchMModel->DailyOrder($data)) {
                    // Redirect on success
                    header('Location: ' . URLROOT . '/BranchM/DailyOrder?success=true');
                    exit;
                } else {
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
    // Example routing for editTable
public function editTable() {
    // Fetch cashiers data
    $cashiers = $this->BranchMModel->getCashiers();
    // Prepare the data array to pass to the view
    $data = [
        'cashiers' => $cashiers // Pass the cashiers array here
    ];

    // Your edit logic goes here
    $this->view('BranchM/v_editTable',$data);
}
public function updateCashier($id) {
    // Fetch existing cashier data from the database
    $cashier = $this->BranchMModel->getCashierById($id);

    // Check if the data was fetched
    if ($cashier) {
        // Prepare the data array to pass to the view
        $data = [
            'ID' => $cashier->ID,
            'Name' => $cashier->Name,
            'Contact' => $cashier->Contact,
            'Address' => $cashier->Address,
            'Email' => $cashier->Email,
            'Join_Date' => $cashier->Join_Date,
            'Password' => $cashier->Password
        ];

        // Load the update view and pass the data
        $this->view('BranchM/v_updateCashier', $data);
    } else {
        // If no data is found, redirect to the index page
        header('Location: ' . URLROOT . '/BranchM/index');
        exit();
    }
}

public function updateCashierSubmit($id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Populate $data array with sanitized inputs
        $data = [
            'ID' => $id,
            'Name' => trim($_POST['name']),
            'Contact' => trim($_POST['contact']),
            'Address' => trim($_POST['address']),
            'Email' => trim($_POST['email']),
            'Join_Date' => trim($_POST['join_date']),
            'Password' => trim($_POST['password']),
            
        ];

        // Update cashier in the database
        if ($this->BranchMModel->updateCashier($data)) {
            // Redirect to the cashier list page after successful update
            header('Location: ' . URLROOT . '/BranchM/index');
            exit();
        } else {
            die('Something went wrong while updating the cashier.');
        }
    }
}public function deleteCashier($id) {
    // Check if the ID is valid
    if ($this->BranchMModel->deleteCashierById($id)) {
        // Redirect to the index page after deletion
        header('Location: ' . URLROOT . '/BranchM/index');
        exit();
    } else {
        die('Something went wrong. Could not delete the cashier.');
    }
}
public function salesReport() {

    // Pass the data to the view
    $this->view('BranchM/v_salesReport');
}

   
}
?>