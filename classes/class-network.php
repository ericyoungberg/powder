<?php

/*
 ** FILE: classes/class-network.php
 ** CLASS: Network
 ** DEPENDENCIES: N/A
 ** Utility functions for parsing and communicating over the wire
*/

class Network {

  // Figures out whether to pull the data sent over POST/GET
  public static function analyzeRequest() {

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
        Network::respond("Could not parse HTTP method", 405);
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
        $status = 'OK';
        break;
      case 404:
        $status = 'Not Found';
        break;
      case 405:
        $status = 'Method Not Allowed';
        break;
      default:
        $status = 'Internal Server Error';
        $code = 500;
    }

    // Prep and send
    header('HTTP/1.1: '.$code.' '.$status); 
    echo json_encode($data);
  }
  // (END) respond


  // Figures out which method is used, then grabs the URI from the query string.
  // This is only used if they can't utilize the .htaccess file
  public static function parseQueryURI() {
    return ($_SERVER['REQUEST_METHOD'] == 'GET') ? $_GET['restful'] : $_POST['restful']; 
  }
  // (END) parseAltURI

}
// (END) Network

?>
