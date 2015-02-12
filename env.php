<?php

/*
 ** FILE: config.php
 ** DEPENDENCIES: [*]
 ** Where the developer defines all global variables used throughout
 ** the API.
*/


/*
 * ENVIRONMENT
 */
define("ROOT", '');                 // Root of your app
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


/*
 * SANITIZATION
 */
define('S_UTF8', true);             // Filters out UTF-8 characters, can be good for SEO
define('S_HTML', true);             // Filters out HTML
define('S_NEWLINE', true);          // Filters out newline characters
define('S_SPECIAL', true);          // Filters out all non-alphanumerics

?>
