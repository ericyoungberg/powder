<?php

/*
 ** FILE: classes/class-router.php
 ** CLASS: Router
 ** DEPENDENCIES: Route
 ** Creates an expandble router that handles possible connections when
 ** declared when the app starts up.
*/

// Dependencies
// ============
require_once('class-route.php');
require_once('class-network.php');


class Router {

  private $_routes = Array();  // Holds Route objects to iterate through


  // Public action methods
  // ====================

  // Finds the correct Route based upon the method and URI
  public function handleRequest() {

    $candidate = new Route();   // The most likely path

    // Strip the API from the front
    $URI = substr($_SERVER['REQUEST_URI'], strlen('/api'));

    $arguments = explode('/', ltrim($URI, '/'));

    $endpoint = array_shift($arguments);

    error_log("METHOD: ".$_SERVER['REQUEST_METHOD']);

    // Find the right route
    foreach($this->_routes as $route) {
      if($endpoint == $route->getEndpoint() && $_SERVER['REQUEST_METHOD'] == $route->getMethod()) {

        // If there is a dynamic segment, make sure that the route is looking for a dynamic segment
        if(array_key_exists(0, $arguments) && !$route->hasDynamicSegment()) continue;

        error_log("FOUND!");

        // This is now the most likely path
        $candidate = $route;
      }
    } // (END) foreach 

    // Make sure we found a matched route
    if(gettype($candidate) == NULL) {
      // HANDLE ERROR   
      return;
    }

    // Execute the Controller method tied to this route
    $candidate->execute();
  }
  // (END) handleRequest


  
  // Public HTTP Verbs
  // =================

  /*
   * These are mainly methods to wrap the addRoute method. 
  */
  
  public function get($path, $class, $func = 'find') {
    $this->addRoute('GET', $path, $class, $func);
  }

  public function post($path, $class) {
    $this->addRoute('POST', $path, $class); 
  }

  public function delete($path, $func) {
    $this->addRoute('DELETE', $path, $func); 
  }

  public function put($path, $func) {
    $this->addRoute('PUT', $path, $func);  
  }


  // Private methods
  // ===============

  // Sanitizes and adds a new Route to the routes array
  private function addRoute($method, $path, $class, $func) {

    // Make sure that the path has been formatted correctly
    if(substr($path, 1) != '/') $path = '/'.$path;

    $this->_routes[] = new Route($method, rtrim($path, '/'), $class, $func);
  }
  // (END) addRoute

}


?>
