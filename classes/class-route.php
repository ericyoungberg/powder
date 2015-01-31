<?php


class Route {

  private $_method = '';    // GET, POST, PUT, DELETE
  private $_path = '';      // Full path 
  private $_endpoint = '';  // The identifying factor of the tag
  private $_dynamic = '';   // The dynamic part of the URI if there is one
  private $_class = '';           // Function to call 
  private $_func = '';

  // Constructor
  // Default parameters are for overloading a blank Route object
  public function __construct($method = '', $path = '', $class = '', $func = '') {

    // Parse the string into an endpoint and possibly a dynamic segment
    $path_= explode('/', ltrim($path, '/'));

    $_endpoint = array_shift($path_);

    if(array_key_exists(0, $path_) && substr($path_[0], 0) == ':') $_dynamic = $path_[0]; 

    // Store the remaining parameters
    $this->_method = $method;
    $this->_path = $path;
    $this->_class = $class;
    $this->_func = $func;
  }

 
  // Getters
  // =======
  public function getMethod() {

    error_log("METHOD ROUTE CALL: $this->_method");

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

  // Executes the referenced function passing in the data
  // sent from the client
  public function execute() {
    if(is_callable($this->_class, $this->_func)) {
      call_user_func(array($this->_class, $this->_func)); 
    }
  }


  // Private methods
  // ===============

  private function buildDynamicSegment() {
  
  }
}

?>
