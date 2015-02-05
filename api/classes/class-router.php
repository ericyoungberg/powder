<?php

/*
 ** FILE: classes/class-router.php
 ** CLASS: Router
 ** DEPENDENCIES: Route
 ** Creates an expandble router that handles possible connections when
 ** declared when the app starts up.
*/

require_once 'class-route.php';


class Router {

  /*--------------------------------------------------------
    ** Properties
  */

  private $_routes = Array();  // Holds Route objects to iterate through


  /*--------------------------------------------------------
    ** Public Methods
  */

  // Finds the correct Route based upon the method and URI
  public function handleRequest() {

    $candidate = new Route();   // The most likely path

    // Strip the API from the front
    $URI = substr($_SERVER['REQUEST_URI'], strlen('/api'));

    $arguments = explode('/', ltrim($URI, '/'));

    // Strip any query string that may have been sent in the URI
    $endpoint = preg_replace('/[?].*/', '', array_shift($arguments));

    // Find the right route
    foreach($this->_routes as $route) {
      if($endpoint == $route->getEndpoint() && $_SERVER['REQUEST_METHOD'] == $route->getMethod()) {

        // If there is a dynamic segment, make sure that the route is looking for a dynamic segment
        if(array_key_exists(0, $arguments) && !$route->hasDynamicSegment()) continue;

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


  /*--------------------------------------------------------
    ** HTTP Verbs
  */

  /*
   * These are mainly helper methods to wrap the addRoute method with defaults. 
  */
  
  public function get($path, $controller, $func = 'find') {
    $this->addRoute('GET', $path, $controller, $func);
  }

  public function post($path, $controller, $func = 'create') {
    $this->addRoute('POST', $path, $controller); 
  }

  public function delete($path, $controller, $func = 'remove') {
    $this->addRoute('DELETE', $path, $controller, $func); 
  }

  public function put($path, $controller, $func = 'update') {
    $this->addRoute('PUT', $path, $controller, $func);  
  }


  /*--------------------------------------------------------
    ** Private Methods
  */

  // Sanitizes and adds a new Route to the routes array
  private function addRoute($method, $path, $controller, $func) {

    // Make sure that the path has been formatted correctly
    if(substr($path, 1) != '/') $path = '/'.$path;

    $this->_routes[] = new Route($method, rtrim($path, '/'), $controller, $func);
  }
  // (END) addRoute

}


?>
