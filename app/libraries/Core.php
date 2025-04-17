<?php
class Core
{
    protected $currentController = 'SysAdmin'; // Default controller
    protected $currentMethod = 'index'; // Default method
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Look in controllers for the first value
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            error_log('Loading controller: ' . ucwords($url[0])); // Debugging
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        } else {
            error_log('Controller not found: ' . ucwords($url[0])); // Debugging
            die('Controller not found.');
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instantiate the controller class
        $this->currentController = new $this->currentController;

        // Check for the second part of the URL
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // Get parameters
        $this->params = $url ? array_values($url) : [];

        // Call the callback with the parameters
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
?>