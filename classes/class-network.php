<?php

/*
 ** FILE: classes/class-network.php
 ** CLASS: Network
 ** DEPENDENCIES: (env)
 ** Utility functions for parsing and communicating over the wire
*/

require_once 'env.php';

class Network {

  /**
   * Figures out which method was used on the request so we can pull
   * the data off of the proper global.
   *
   * @return Array(*) $data
   */
  public static function analyzeRequest() {

    $data = Array();

    switch(Network::parseRequestMethod()) {
      case 'DELETE':
      case 'POST':
        $data = $_POST;
        break;
      case 'PUT':
        parse_str(file_get_contents("php://input"), $data);   // This is the only way of getting PUT data...
        break;
      case 'GET':
        $data = $_GET;

        // If we passed the URI in the query string, we need to make sure to remove since
        // it shouldn't be included in the data that was passed from the client.
        if(!HTACCESS_ENABLED) unset($data['restful']);

        break;
      default:
        Network::respond("Could not parse HTTP method", 405);
        return;
    }

    Network::sanitize($data);

    return $data;
  }
  // (END) prepareData


  /**
   * Filters out unwanted characters/strings from the data passed.
   *
   * @param Array(*) &$data
   */
  public static function sanitize(&$data) {

  }
  // (END) sanitize

  
  /**
   * Figures out the method that was used in the request.
   * PUT and DELETE get buried in POST cause the web is so pragmatic.
   *
   * @return string $method;
   */
  public static function parseRequestMethod() {

    $method = $_SERVER['REQUEST_METHOD'];

    // Check if PUT or DELETE were used
    if($method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
      $method = $_SERVER['HTTP_X_HTTP_METHOD']; 
    }

    return $method;
  }
  // (END) parseRequestMethod


  /**
   * Preps and sends the data back to the client.
   *
   * @param Array(*)|string $data
   * @param int $code
   */
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

}
// (END) Network

?>
