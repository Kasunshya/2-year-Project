<?php
class Unregisteredcustomer extends Controller {

    public function __construct() {
        
    }


    public function unregisteredcustomerhomepage(){
        $data = [];

        $this->view('UnregisteredCustomer/unregisteredcustomerhomepage');

    }

    public function unregisteredcustomerproducts(){
        $data = [];

        $this->view('UnregisteredCustomer/unregisteredcustomerproducts');

    }

    public function unregisteredcustomercart(){
        $data = [];

        $this->view('UnregisteredCustomer/unregisteredcustomercart');

    }

    
}