<?php

require_once 'models/User.php';

class UserController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function index()
    {
        $users = $this->userModel->getAllUsers();
        include 'views/userManagement.php';
    }
}
