<?php
//database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bakery');

//approot
define('APPROOT',dirname(dirname(__FILE__)));

//url root
define ('URLROOT','http://localhost/Bakery');

//website name
define('SITENAME','Bakery');

// Upload Root
define('UPLOADROOT', dirname(APPROOT) . '/public/uploads');
?>