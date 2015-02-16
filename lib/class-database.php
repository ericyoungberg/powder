<?php

/*
 ** FILE: lib/class-database.php
 ** CLASS: Database
 ** DEPENDENCIES: Network, (env)
 ** Utility functions for communicating with a SQL database
*/

require_once 'class-network.php';
require_once 'env.php';

/**
 * The Database class will save you the hassle of having to write your database 
 * connections each time that you write a new method for your controllers. I hope to 
 * expand the use of this class.
 */
class Database {

  /**
   * Creates a PDO connection and returns it the the user.
   *
   * @return PDO $dbh
   */
  public static function connect() {
    $dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
    
    // Make sure we connected successfully
    if($dbh) return $dbh;

    Network::respond('Server could not connect to the database. Sorry!', 500);
  }
  // (END) connect


  /**
   * Creates a new hash. Basically a wrapper for the built in password_hash function but might change
   * over time if needed. If you use the wrapper, you won't have to change your whole codebase if this 
   * changes as security standards do all the time...
   *
   * @param string $str
   * @return string|bool
   */
  public static function hash($str) {
    return password_hash(LOCAL_SALT . $str, PASSWORD_DEFAULT);
  }
  // (END) hash


  /**
   * Verifies an existing hash created with ::hash. A wrapper just like ::hash is for the same reason.
   *
   * @param string $str
   * @param string $hash
   * @return bool
   */
  public static function verify_hash($str, $hash) {
    return password_verify(LOCAL_SALT . $str, $hash);
  }
  // (END) verify_hash


  /**
   * Creates a variable length unique ID based upon random numbers and the current time.
   *
   * @param int $size
   * @return string $uid
   */
  public static function uid($size) {

    $uid = ''; 
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGJKLMNOPQRSTUVWXYZ0123456789';
    $len = strlen($characters);
    
    while(strlen($uid) != $size) {
      $uid .= $characters[mt_rand(0, $len - 1)]; 
    }

    $uid .= time();

    return $uid;
  }
  // (END) uid

}

?>
