<?php
class InventoryM extends Controller {
    public function __construct() {
        $this->inventoryModel = $this->model('M_InventoryM');
    
    }

    public function inventoryItems() {
        $this->view('InventoryM/InventoryItems');
    }

}
?>