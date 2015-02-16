<?php

/*
 ** FILE: router.php
 ** DEPENDENCIES: Router
 ** Instantiates the Router. This is where the developer should declare
 ** their application routes.
*/


// Import the Router
require_once 'lib/class-router.php';
$router = new Router();


/*--------------------------------------------------------
  ** Routes
*/
/* 
 * Declare your routes here.
 * See documentation/README for details about how to set up routes.
 */




/*----------------------------------------------------------
*/
/*
 * After all of the routes are declared, figure out which 
 * route we need to execute.
 */
$router->handleRequest();

?>
