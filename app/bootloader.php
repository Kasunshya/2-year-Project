<?php
// Start session
session_start();

// Load libraries and helpers
require_once 'libraries/Core.php';
require_once 'libraries/Controller.php';
require_once 'libraries/Database.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/url_helper.php';

//load configuration
require_once 'config/config.php';

// Initialize the Core class
$init = new Core();
?>