<?php
class Inventorykeeper extends Controller {
    private $InventoryModel;

    public function __construct() { 
        // Load the Inventory Model
        $this->InventoryModel = $this->model('M_Inventory');
    }

    // Add Inventory
    public function addinventory() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data
            $data = [
                'name' => trim($_POST['name']),
                'quantity_available' => trim($_POST['quantity_available']),
                'Price_per_kg' => trim($_POST['Price_per_kg']),
                'Expiry_date' => trim($_POST['Expiry_date']),
                'name_err' => '',
                'quantity_available_err' => '',
                'Price_per_kg_err' => '',
                'Expiry_date_err' => ''
            ];

            // Validate inputs
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a product name.';
            }

            if (empty($data['quantity_available']) || !is_numeric($data['quantity_available'])) {
                $data['quantity_available_err'] = 'Please enter a valid quantity.';
            }

            if (empty($data['Price_per_kg']) || !is_numeric($data['Price_per_kg'])) {
                $data['Price_per_kg_err'] = 'Please enter a valid price.';
            }

            if (empty($data['Expiry_date'])) {
                $data['Expiry_date_err'] = 'Please select an expiry date.';
            }

            // Check for errors
            if (empty($data['name_err']) && empty($data['quantity_available_err']) && empty($data['Price_per_kg_err']) && empty($data['Expiry_date_err'])) {
                // Add Inventory
                if ($this->InventoryModel->addinventory($data)) {
                    header('Location: ' . URLROOT . '/Inventorykeeper/addinventory');
                    exit;
                } else {
                    die('Something went wrong.');
                }
            } else {
                // Load view with errors
                $this->view('Inventorykeeper/v_addinventory', $data);
            }
        } else {
            // Load empty form
            $data = [
                'name' => '',
                'quantity_available' => '',
                'Price_per_kg' => '',
                'Expiry_date' => '',
                'name_err' => '',
                'quantity_available_err' => '',
                'Price_per_kg_err' => '',
                'Expiry_date_err' => ''
            ];
            $this->view('Inventorykeeper/v_addinventory', $data);
        }
    }

    // Update Inventory
public function updateInventory() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Prepare data
        $data = [
            'inventory_id' => trim($_POST['inventory_id']),
            'update_inventory_name' => trim($_POST['update_inventory_name']),
            'update_quantity' => trim($_POST['update_quantity']),
            'update_price' => trim($_POST['update_price']),
            'update_expiry_date' => trim($_POST['update_expiry_date']),
            'inventory_id_err' => '',
            'update_inventory_name_err' => '',
            'update_quantity_err' => '',
            'update_price_err' => '',
            'update_expiry_date_err' => ''
        ];

        // Validate inputs
        if (empty($data['inventory_id'])) {
            $data['inventory_id_err'] = 'Please enter the Inventory ID.';
        }

        if (!empty($data['update_quantity']) && !is_numeric($data['update_quantity'])) {
            $data['update_quantity_err'] = 'Quantity must be numeric.';
        }

        if (!empty($data['update_price']) && !is_numeric($data['update_price'])) {
            $data['update_price_err'] = 'Price must be numeric.';
        }

        // Check for errors
        if (empty($data['inventory_id_err']) && empty($data['update_inventory_name_err']) &&
            empty($data['update_quantity_err']) && empty($data['update_price_err']) && 
            empty($data['update_expiry_date_err'])) {

            // Update Inventory
            if ($this->InventoryModel->updateInventory($data)) {
                header('Location: ' . URLROOT . '/Inventorykeeper/manageInventory');
                exit;
            } else {
                die('Something went wrong.');
            }
        } else {
            // Load view with errors
            $this->view('Inventorykeeper/v_updateinventory', $data);
        }
    } else {
        // Load empty form
        $data = [
            'inventory_id' => '',
            'update_inventory_name' => '',
            'update_quantity' => '',
            'update_price' => '',
            'update_expiry_date' => '',
            'inventory_id_err' => '',
            'update_inventory_name_err' => '',
            'update_quantity_err' => '',
            'update_price_err' => '',
            'update_expiry_date_err' => ''
        ];

        $this->view('Inventorykeeper/v_updateinventory', $data);
    }
}

// Delete Inventory
public function deleteInventory() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Get the Inventory ID
        $data = [
            'delete_inventory_id' => trim($_POST['delete_inventory_id']),
            'delete_inventory_id_err' => ''
        ];

        // Validate the Inventory ID
        if (empty($data['delete_inventory_id'])) {
            $data['delete_inventory_id_err'] = 'Please enter the Inventory ID.';
        } elseif (!is_numeric($data['delete_inventory_id'])) {
            $data['delete_inventory_id_err'] = 'Inventory ID must be numeric.';
        }

        // Check for errors
        if (empty($data['delete_inventory_id_err'])) {
            // Attempt to delete inventory
            if ($this->InventoryModel->deleteInventory($data['delete_inventory_id'])) {
                header('Location: ' . URLROOT . '/Inventorykeeper/manageInventory');
                exit;
            } else {
                die('Something went wrong.');
            }
        } else {
            // Load view with errors
            $this->view('Inventorykeeper/v_deleteinventory', $data);
        }
    } else {
        // Load empty form
        $data = [
            'delete_inventory_id' => '',
            'delete_inventory_id_err' => ''
        ];

        $this->view('Inventorykeeper/v_deleteinventory', $data);
    }
}

// View Inventory
public function viewInventory() {
    // Fetch inventory data
    $inventory = $this->InventoryModel->getInventory();

    // Fetch storage statistics
    $stats = $this->InventoryModel->getInventoryStorageStats();

    // Prepare data for the view
    $data = [
        'inventory' => $inventory,
        'low_storage' => $stats->low_storage,
        'sufficient_storage' => $stats->sufficient_storage,
    ];

    // Load the view
    $this->view('Inventorykeeper/v_viewinventory', $data);
}


}