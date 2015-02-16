<?php

/*
 ** FILE: lib/class-router.php
 ** CLASS: Router
 ** DEPENDENCIES: Route, Network, (env)
 ** Creates an expandable router that handles possible connections when
 ** declared after the app starts up.
*/

require_once 'class-route.php';
require_once 'class-network.php';
require_once 'env.php';

/**
 * The Router is the bulk of how Powder works. It's responsible for 
 * finding the Route that has been specified in the router.php file 
 * then executing the supplied method that the route has been declared
 * with. 
 */
class Router {

  /*--------------------------------------------------------
    ** Properties
  */

  private $_routes = Array();  // Holds Route objects to iterate through


  /*--------------------------------------------------------
    ** Constructor
  */

  public function __constructor() {

    // Set up our headers when instantiating our Router
    if(CROSS_ORIGIN) header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-type: application/json"); 
  }


  /*--------------------------------------------------------
    ** Public Methods
  */

  /**
   * Parses the Request URI and finds a matching Route to handle
   * the request.
   *
   * @return NULL
   */
  public function handleRequest() {

    $prefix = (ROOT) ? '/'.ROOT : '';
    $prefix .= '/api';

    $method = Network::parseRequestMethod();

    // We find the URI in the query string if the server doesn't allow .htaccess files or mod_rewrite
    $URI = (HTACCESS_ENABLED) ? substr($_SERVER['REQUEST_URI'], strlen($prefix)) : $_GET['restful'];

    $arguments = explode('/', trim($URI, '/'));

    // Strip any query string that may have been sent in the URI
    $endpoint = preg_replace('/[?].*/', '', array_shift($arguments));

    // Find the right route
    foreach($this->_routes as $route) {
      if($endpoint == $route->getEndpoint() && $method == $route->getMethod()) {

        // If there is a dynamic segment, make sure that the route is looking for a dynamic segment
        if(array_key_exists(0, $arguments)) {

          if(!$route->hasDynamicSegment()) continue;  // If this route isn't aware of dynamics, move on.

          // Assign the global variables to be referenced from any method that handles dynamic segments
          $GLOBALS['POW_DYN_column'] = $route->getDynamicSegment();
          $GLOBALS['POW_DYN_identifier'] = $arguments[0];
        } 

        // This is now the most likely path
        return $route->execute();
      } else {
        unset($route);  // Free up some memory then 
      }
    } // (END) foreach 
  }
  // (END) handleRequest


  /*--------------------------------------------------------
    ** HTTP Verbs
  */

  /**
   * These are mainly helper methods to wrap the addRoute method with defaults. 
   * 
   * @param string $path
   * @param string $controller
   * @param string $func
   */
  public function get($path, $controller, $func = 'find') {
    $this->addRoute('GET', $path, $controller, $func);
  }

  public function post($path, $controller, $func = 'create') {
    $this->addRoute('POST', $path, $controller, $func); 
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

  /**
   * Adds a new Route to the routes array. Only called
   * by the HTTP Verb methods defined above.
   *
   * @param string $method
   * @param string $path
   * @param string $controller
   * @param string $func
   */
  private function addRoute($method, $path, $controller, $func) {
    $this->_routes[] = new Route($method, rtrim($path, '/'), $controller, $func);
  }
  // (END) addRoute

}


?>
