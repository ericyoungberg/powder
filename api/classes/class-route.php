<?php

/*
 ** FILE: classes/class-route.php
 ** CLASS: Route
 ** DEPENDENCIES: (Manifest)
 ** Handles all responsibilities and states of each route defined in the Router file
*/


// We need access to all of the possible controllers for Route::execute
require_once 'controllers/manifest.php';
require_once 'controllers/post.php';


class Route {

  /*--------------------------------------------------------
   ** Properties
  */

  private $_method = '';      // GET, POST, PUT, DELETE
  private $_path = '';        // Full path 
  private $_endpoint = '';    // The identifying factor of the tag
  private $_dynamic = '';     // The dynamic part of the URI if there is one
  private $_controller = '';  // Controller to look on 
  private $_func = '';        // The function on that controller to call


  /*--------------------------------------------------------
   ** Constructor
  */

  // Default parameters are for overloading a blank Route object (needed by Router::handleRequest)
  public function __construct($method = '', $path = '', $controller = '', $func = '') {

    // Parse the string into an endpoint and possibly a dynamic segment
    $path_= explode('/', ltrim($path, '/'));

    $this->_endpoint = array_shift($path_);

    if(array_key_exists(0, $path_) && substr($path_[0], 0) == ':') $_dynamic = $path_[0]; 

    // Store the remaining parameters
    $this->_method = $method;
    $this->_path = $path;
    $this->_controller = $controller;
    $this->_func = $func;
  }
  // (END) __construct

 
  /*--------------------------------------------------------
   ** Getters
  */

  public function getMethod() {
    return $this->_method; 
  }

  public function getPath() {
    return $this->_path; 
  }

  public function getEndpoint() {
    return $this->_endpoint; 
  }

  public function hasDynamicSegment() {
    return ($this->_dynamic != '') ? true : false;
  }


  /*--------------------------------------------------------
   ** Public Methods
  */

  // Executes the referenced function passing in the data
  // sent from the client
  public function execute() {
    if(is_callable($this->_controller, $this->_func)) {
      call_user_func(array($this->_controller, $this->_func)); 
    } else {
      Network::respond("Route::execute(): $this->_controller isn't found. Please check your controllers/manifest!", 500); 
    }
  }
  // (END) execute


  /*--------------------------------------------------------
   ** Private Methods
  */

  private function buildDynamicSegment() {
  
  }
}

?>
