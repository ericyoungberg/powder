<?php

/*
 ** FILE: router.php
 ** DEPENDENCIES: Router
 ** Instantiates the Router. This is where the developer should declare
 ** their application routes.
*/


// Import the Router
require_once 'classes/class-router.php';
$router = new Router();


/*--------------------------------------------------------
  ** Routes
*/
/* 
 * Declare your routes here.
 * See documentation/README for details about how to set up routes.
 */

// Posts
$router->get('/posts', 'PostsController');
$router->get('/posts/:title', 'PostsController', 'findOne');
$router->post('/posts', 'PostsController');
$router->delete('/posts/:title', 'PostsController');
$router->put('/posts/:title', 'PostsController');







/*----------------------------------------------------------
*/
/*
 * After all of the routes are declared, we need to figure out which 
 * route we need to execute.
 */
$router->handleRequest();

?>
