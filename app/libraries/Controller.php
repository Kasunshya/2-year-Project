<?php
  /*
   * Base Controller
   * Loads the models and views
   */
  class Controller {
    // Load model
    public function model($model){
      // Debug model loading
      error_log("Loading model: " . $model);
      
      // Require model file
      require_once '../app/models/' . $model . '.php';

      // Instantiate model
      $modelInstance = new $model();
      
      error_log("Model " . $model . " loaded successfully");
      return $modelInstance;
    }

    // Load view
    public function view($view, $data = []){
      // Check for view file
      if(file_exists('../app/views/' . $view . '.php')){
        require_once '../app/views/' . $view . '.php';
      } else {
        error_log("View not found: " . $view);
        // View does not exist
        die('View does not exist');
      }
    }
  }
?>