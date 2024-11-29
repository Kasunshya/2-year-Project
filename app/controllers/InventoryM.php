<?php
class InventoryM extends Controller {
    private $inventoryModel;
    
    public function __construct() {
        $this->inventoryModel = $this->model('M_InventoryM');
    }

    public function inventoryItems() {
        $this->view('InventoryM/InventoryItems');
    }
}
?>