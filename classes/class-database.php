<?php

/*
 ** FILE: classes/class-database.php
 ** CLASS: Database
 ** DEPENDENCIES: Network, (env)
 ** Utility functions for communicating with a SQL database
*/

require_once 'class-network.php';
require 'env.php';

/**
 * The Database class will save you the hassle of having to write your database 
 * connections each time that you write a new method for your controllers. I hope to 
 * expand the use of this class.
 */
class Database {

  // Creates a PDO connection and returns it the the user
  public static function connect() {
    $dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
    
    if($dbh) return $dbh;

    Network::respond('Server could not connect to the database. Sorry!', 500);
  }
  // (END) connect

}

?>
