<?php
/* 
 * I want to recieve any type of request. 
 * This API will parrot back the VERB,
 * the PAYLOAD you sent,
 * and the REQUEST (api/:something/:else/:here will spit out [":something",":else",":here"])
 * as a json object
 */
//$_SERVER is a super global
  $verb = $_SERVER["REQUEST_METHOD"];
  
/* 
 * I like using StdClass in PHP it is the default Object, 
 * instead of object.attribute you use object->attribute.  
 * That is largely because "string1"."string2" is how you concatenate in PHP.
 */
  $response = new StdClass();
  $response->verb = $verb;
  $response->request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
/*
 * $_GET and $_POST are the ways of getting the parameters in the standard case, but 
 * php://input is how you get the JSON data out of PUT, DELETE, PATCH, OPTIONS, etc.
 *
 * $_GET["key"] will spit out "value" if key and value were sent along.
 */
  switch ($verb) {
    case 'GET':    
      $response->payload = $_GET;
      echo json_encode($response);
      break;
    case 'POST':    
      $response->payload = $_POST;
      echo json_encode($response);
      break;
    default:
      parse_str(file_get_contents("php://input"), $response->payload);
      echo json_encode($response);
      break;
  };
?>