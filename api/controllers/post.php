<?php 

require_once('../classes/class-network.php');

class PostController {
  public static function find() {

    $callback = function() {
      // Fetch the data that was sent with the request
      $data = Network::prepareData();

      Network::respond("Nothing here yet", 200);
    };

    return $callback;
  }
}

?>
