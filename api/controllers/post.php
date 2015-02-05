<?php 

require_once 'classes/class-network.php';

class PostController {
  public static function find() {

    $data = Network::analyzeRequest();

    if($data) {
      Network::respond($data, 200);
    } else {
      Network::respond('{}', 404);  
    }
  }
}

?>
