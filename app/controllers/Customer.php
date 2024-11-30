<?php
class Customer extends Controller {

    public function __construct() {
        
    }


    public function customerhomepage(){
        $data = [];

        $this->view('Customer/CustomerHomepage');

    }

    public function customerprofile(){
        $data = [];

        $this->view('Customer/CustomerProfile');

    }

    public function customercustomisation(){
        $data = [];

        $this->view('Customer/CustomerCustomisation');

    }

    public function customercart(){
        $data = [];

        $this->view('Customer/CustomerCart');

    }

    public function customercheckout(){
        $data = [];

        $this->view('Customer/CustomerCheckout');

    }
    
    public function customerfeedback(){
        $data = [];

        $this->view('Customer/CustomerFeedback');

    }

    public function customerproducts(){
        $data = [];

        $this->view('Customer/CustomerProducts');

    }
}
?>
