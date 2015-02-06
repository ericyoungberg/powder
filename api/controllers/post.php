<?php 

require_once 'classes/class-network.php';
require_once 'classes/class-database.php';

class PostController {
  public static function find() {

    $dbh = Database::connect();

    $stmt = $dbh->prepare('SELECT * FROM posts');  
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_OBJ);

    $data = array();
    while($row = $stmt->fetch()) {
      $data[] = $row;
    }

    Network::respond($data, 200);
  }
}

?>
