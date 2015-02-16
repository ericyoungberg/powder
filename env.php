<?php

/*
 ** FILE: config.php
 ** DEPENDENCIES: [*]
 ** Where the developer defines all global variables used throughout the API.
*/


/*
 * ENVIRONMENT
 */
define('LOCAL_SALT', 'himalayan');  // The constant salt used for hashing


/*
 * DATABASE
 */
define('DB_HOST', 'localhost');     // Where your DB is hosted
define('DB_NAME', 'testdb');        // The name of your DB
define('DB_USERNAME', 'hob');       // Username with access to above DB
define('DB_PASSWORD', 'testpass');  // Password to identify above username


/*
 * CONFIGURATION
 */
define("HTACCESS_ENABLED", true);   // Set this to false if you can't use .htaccess files. See README.
define("CROSS_ORIGIN", true);       // Whether you want CORS

?>
