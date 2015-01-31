<?php

/*
 ** CLASS: Network
 ** DEPENDENCIES: N/A
 ** Utility functions for parsing and communicating over the wire
*/

class Network {

  // Figures out whether to pull the data sent over POST/GET
  public static function prepareData() {

    $data = Array();

    switch($_SERVER['REQUEST_METHOD']) {
      case 'DELETE':
      case 'PUT':
      case 'POST':
        $data = $_POST;
        break;
      case 'GET':
        $data = $_GET;
        break;
      default:
        Network::respond('Could not parse HTTP method', 405);
        return;
    }

    Network::sanitize($data);

    return $data;
  }
  // (END) prepareData


  // Filters out the bad stuff that a user can enter
  public static function sanitize($data) {
    return $data;
  }
  // (END) sanitize


  // Preps and send the data back to the client
  public static function respond($data, $code) {

    // Parse the code passed
    switch($code) {
      case 200:
        return 'OK';
        break;
      case 404:
        return 'Not Found';
        break;
      case 405:
        return 'Method Not Allowed';
        break;
      default:
        return 'Internal Server Error';
        break;
    }

    // Prep and send
    header('HTTP/1.1:'.$code.' '.$status); 
    echo json_encode($data);
  }
  // (END) respond

}
// (END) Network

?>
