<?php
class InventoryKeeper extends Controller {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = $this->model('M_Inventory');
    }
public function index(){
    $data = [
        
    ];
    $this->view('Inventorykeeper/v_viewinventory');
}
    // View Inventory
    public function viewinventory() {
        $inventory = $this->inventoryModel->getInventory();
        $data = ['inventory' => $inventory];
        $this->view('Inventorykeeper/v_viewinventory', $data);
    }

    public function addinventory() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check what data is being receive
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            // Prepare data
            $data = [
                'name' => trim($_POST['name']),
                'quantity_available' => trim($_POST['quantity_available']),
                'Expiry_date' => trim($_POST['Expiry_date']),
                'Price_per_kg' => trim($_POST['Price_per_kg']),
                'name_err' => '',
                'quantity_available_err' => '',
                'Price_per_kg_err' => '',
                'Expiry_date_err' => ''
            ];
    
            // Validate Inventory Name
            if (empty($data['name'])) {
                $data['name_err'] = 'Inventory name is required.';
            } elseif (strlen($data['name']) < 3) {
                $data['name_err'] = 'Inventory name must be at least 3 characters.';
            }
    
            // Validate Quantity
            if (empty($data['quantity_available'])) {
                $data['quantity_available_err'] = 'Quantity is required.';
            } elseif (!is_numeric($data['quantity_available']) || $data['quantity_available'] <= 0) {
                $data['quantity_available_err'] = 'Quantity must be a positive number.';
            }
    
            // Validate Price
            if (empty($data['Price_per_kg'])) {
                $data['Price_per_kg_err'] = 'Price is required.';
            } elseif (!is_numeric($data['Price_per_kg']) || $data['Price_per_kg'] <= 0) {
                $data['Price_per_kg_err'] = 'Price must be a positive number.';
            }
    
            // Validate Expiry Date
            if (empty($data['Expiry_date'])) {
                $data['Expiry_date_err'] = 'Expiry date is required.';
            } elseif (strtotime($data['Expiry_date']) < time()) {
                $data['Expiry_date_err'] = 'Expiry date must be a future date.';
            }
    
            // Check if all validations passed
            if (empty($data['name_err']) && empty($data['quantity_available_err']) && empty($data['Price_per_kg_err']) && empty($data['Expiry_date_err'])) {
                // Add Inventory
                if ($this->inventoryModel->addInventory($data)) {
                    header('Location: ' . URLROOT . '/Inventorykeeper/viewinventory?success=true');
                    exit;
                } else {
                    die('Something went wrong.');
                }
            } else {
                // Reload the addinventory view with error messages
                $this->view('Inventorykeeper/v_addinventory', $data);
            }
        } else {
            // Load the empty form
            $data = [
                'name' => '',
                'quantity_available' => '',
                'Expiry_date' => '',
                'Price_per_kg' => '',
                'name_err' => '',
                'quantity_available_err' => '',
                'Price_per_kg_err' => '',
                'Expiry_date_err' => ''
            ];
    
            $this->view('Inventorykeeper/v_addinventory', $data);
        }
    }
    

    // Update Inventory
    public function updateinventory($id = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'inventory_id' => $id,
                'update_inventory_name' => trim($_POST['update_inventory_name']),
                'update_quantity' => trim($_POST['update_quantity']),
                'update_price' => trim($_POST['update_price']),
                'update_expiry_date' => trim($_POST['update_expiry_date']),
                'name_err' => '',
                'quantity_err' => '',
                'price_err' => '',
                'expiry_date_err' => ''
            ];

            // Validate Inventory Name
            if (empty($data['update_inventory_name'])) {
                $data['name_err'] = 'Inventory name is required.';
            } elseif (strlen($data['update_inventory_name']) < 3) {
                $data['name_err'] = 'Inventory name must be at least 3 characters long.';
            }

            // Validate Quantity
            if (empty($data['update_quantity'])) {
                $data['quantity_err'] = 'Quantity is required.';
            } elseif (!is_numeric($data['update_quantity']) || $data['update_quantity'] <= 0) {
                $data['quantity_err'] = 'Quantity must be a positive number.';
            }

            // Validate Price
            if (empty($data['update_price'])) {
                $data['price_err'] = 'Price is required.';
            } elseif (!is_numeric($data['update_price']) || $data['update_price'] <= 0) {
                $data['price_err'] = 'Price must be a positive number.';
            }

            // Validate Expiry Date
            if (empty($data['update_expiry_date'])) {
                $data['expiry_date_err'] = 'Expiry date is required.';
            } elseif (strtotime($data['update_expiry_date']) < time()) {
                $data['expiry_date_err'] = 'Expiry date must be a future date.';
            }

            // Check if all validations passed
            if (empty($data['name_err']) && empty($data['quantity_err']) && empty($data['price_err']) && empty($data['expiry_date_err'])) {
                if ($this->inventoryModel->updateInventory($data)) {
                    header('Location: ' . URLROOT . '/Inventorykeeper/viewinventory');
                    exit;
                } else {
                    die('Something went wrong while updating the inventory.');
                }
            } else {
                $data['inventory'] = $this->inventoryModel->getInventoryById($id);
                $this->view('Inventorykeeper/v_updateinventory', $data);
            }
        } else {
            $inventory = $this->inventoryModel->getInventoryById($id);

            if (!$inventory) {
                die('Inventory not found.');
            }

            $data = [
                'inventory_id' => $id,
                'update_inventory_name' => $inventory->name,
                'update_quantity' => $inventory->quantity_available,
                'update_price' => $inventory->Price_per_kg,
                'update_expiry_date' => $inventory->Expiry_date,
                'name_err' => '',
                'quantity_err' => '',
                'price_err' => '',
                'expiry_date_err' => ''
            ];

            $this->view('Inventorykeeper/v_updateinventory', $data);
        }
    }

    // Delete Inventory
    public function deleteinventory($inventory_id) {
        if ($this->inventoryModel->deleteInventory($inventory_id)) {
            header('Location: ' . URLROOT . '/Inventorykeeper/viewinventory?success=true');
        } else {
            die('Something went wrong');
}
}
}
