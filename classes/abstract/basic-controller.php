<?php 

/*
 ** FILE: classes/abstract/basic-controller.php
 ** DEPENDENCIES: Network, Database
 **
 ** Declares the BasicController abstract class.
*/

require_once 'classes/class-network.php';
require_once 'classes/class-database.php';


/**
 *  The BasicController is extended by all other controllers that are defined
 *  by the developer. As long as the developer isn't doing anything differently, 
 *  the BasicController's methods can handle all requests out of the box.
 *  All public methods send data back over to the client after the database query
 *  completes.
 */
abstract class BasicController {

  /*--------------------------------------------------------
    ** Public methods
  */

  /**
   * Finds all records of the extended controllers entity.
   */
  public static function find() {
    $entity = BasicController::parseEntity(get_called_class());

    $dbh = Database::connect();

    $stmt = $dbh->prepare('SELECT * FROM '.$entity);  
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_OBJ);

    $data = array();
    while($row = $stmt->fetch()) {
      $data[] = $row;
    }

    $dbh = null;

    Network::respond($data, 200);
  }
  // (END) find


  /**
   * Finds only one record of the extended controller's entities based upon
   * a dynamic identifier passed in the request.
   */
  public static function findOne() {
    $entity = BasicController::parseEntity(get_called_class()); // Figure out which table

    // Grab the GLOBALS defined in @class Router::handleRequest() for dynamic segments
    $column = $GLOBALS['POW_DYN_column'];
    $identifier = $GLOBALS['POW_DYN_identifier'];

    // Connect and bind
    $dbh = Database::connect();
    $stmt = $dbh->prepare("SELECT * FROM $entity WHERE $column=:$column LIMIT 1");
    $stmt->bindParam($column, $identifier);

    // Make sure the statement executes
    if($stmt->execute()) {

      $stmt->setFetchMode(PDO::FETCH_OBJ);  // We only want to fetch objects

      // If we fetch a row successfully, send it to the client
      if($row = $stmt->fetch()) {
        return Network::respond($row, 200);
      } 

      // If not, report that the record isn't found
      Network::respond('Could not find a record with '.$column.' as '.$identifier, 404);
    } else {
      Network::respond('BasicController::findOne(): Could not connect to the database. Sorry!', 500); 
    }
  }
  // (END) findOne
  

  /**
   * Creates a new record of the extended controller's entity.
   *
   * NOTE: SQL dates are not supported in this method. If you want to store dates with this method,
   * store them as strings. If you need to work with dates directly, then you have to write 
   * your own method on your controller.
   */
  public static function create() {

    $entity = BasicController::parseEntity(get_called_class()); // Figure out which table name
    $data = Network::analyzeRequest();                          // Grab the data from the request
    $dbh = Database::connect();                                 // Connect to the database

    // Start the base of the query string
    $query = 'INSERT INTO '.$entity.' (';
    $values = ' VALUES (';

    $firstKey = true; // Flag for the loop below to make sure we don't concat extra commas

    // Look through the data that was sent to build the column names
    foreach($data as $k => $v) {
      if(!$firstKey) {
        $query .= ', '; 
        $values .= ', ';
      } else {
        $firstKey = false; 
      }

      $query .= $k;
      $values .= ':'.$k;
    }

    // Close the strings
    $query .= ')';
    $values .= ')';
    
    // Insert the built query string
    $stmt = $dbh->prepare($query . $values);

    // Make sure that the statement executed properly
    if($stmt->execute($data)) {
      Network::respond($data, 200);
    } else {
      Network::respond("The data passed to the server was not correctly formatted for the table in the database!", 500); 
    }
  }
  // (END) create


  /**
   * Deletes a record from the table of the extended controller's entity.
   */
  public static function remove() {
    $entity = BasicController::parseEntity(get_called_class());

    // Grab the GLOBALS defined in @class Router::handleRequest() for dynamic segments
    $column = $GLOBALS['POW_DYN_column'];
    $identifier = $GLOBALS['POW_DYN_identifier'];

    // Connect and bind
    $dbh = Database::connect();
    $stmt = $dbh->prepare("DELETE FROM $entity WHERE $column=:$column");
    $stmt->bindParam($column, $identifier);

    // Make sure the statement executes
    if($stmt->execute()) {
      Network::respond("POW_REMOVED", 200);
    } else {
      Network::respond('BasicController::remove(): Could not connect to the database. Sorry!', 500); 
    }

  }
  // (END) remove


  /**
   * Updates a current record or set of records of the extended controller's entity.
   */
  public static function update() {
    $entity = BasicController::parseEntity(get_called_class());
    $data = Network::analyzeRequest();
    
    $column = $GLOBALS['POW_DYN_column'];
    $identifier = $GLOBALS['POW_DYN_identifier'];

    $dbh = Database::connect();

    $query = "UPDATE $entity SET ";
    
    $firstKey = true;

    foreach($data as $k => $v) {
      if($firstKey) {
        $firstKey = false; 
      } else {
        $query .= ', '; 
      } 
      $query .= "$k = :$k";
    } 

    $query .= " WHERE $column = :$column";

    $stmt = $dbh->prepare($query);

    $data[$column] = $identifier;

    if($stmt->execute($data)) {
      Network::respond("POW_UPDATED", 200);
    } else {
      Network::respond("BasicController::update(): Could not update $entity!", 500); 
    }
  }
  // (END) update



  /*--------------------------------------------------------
    ** Private methods
  */

  /**
   * Figures out the automatic entity based upon the Powder naming conventions
   * for extended controllers.
   * We have to pass the get_called_class() function as {@param $class} else
   * we will always return 'basic'.
   * @example { $entity = BasicController::parseEntity(get_called_class()); }
   *
   * @param string $class
   * @return string
   */
  private static function parseEntity($class) {
    return strtolower(substr($class, 0, strlen('Controller')*-1));
  }
  // (END) getEntity
}

?>
