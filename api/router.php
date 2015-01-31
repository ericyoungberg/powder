<?php

/*
 ** FILE: api/router.php
 ** DEPENDENCIES: Router, [*]
 ** Instantiates the Router. This is where the developer should declare
 ** their application routes.
*/

// Import the Router
require_once('../classes/class-router.php');
$router = new Router();

// Routes
// ======
/* 
 * Declare your routes here
 */

// Posts
$router->get('/posts', 'PostController', 'find');


// Route the request accordingly
$router->handleRequest();

?>
