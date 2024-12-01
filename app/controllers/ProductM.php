<?php

require_once 'models/Product.php';

class ProductController
{
    private $productModel;

    public function __construct($db)
    {
        $this->productModel = new Product($db);
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();
        include 'views/productManagement.php';
    }
}
