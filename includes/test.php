<?php
// This page is just a 'stub' for trying things with curl interacting with the IDP
// Get a valid session id from the fssessionid cookie and set it here
$sessionId = 'd72dfbf8-1a53-4faf-9745-dd5f9935853b-prod';

// Then view source of this page to see the response
// view-source:https://beta.familysearch.org/wiki/mediawiki/extensions/FsSignin/includes/test.php

// or change to the directory and call it from the CLI
// root@fswiki:/opt/htdocs/wiki/mediawiki/extensions/FsSignin/includes# php -f test.php

$ch = curl_init("https://ident.familysearch.org/cis-public-api/v4/session/$sessionId");
// When we curl_exec, return a string rather than output directly
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
// Ask for JSON instead of XML
$headers = ["Accept: application/json"];
curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
// Send our session cookie in the request
curl_setopt ($ch, CURLOPT_COOKIE, "fssessionid=$sessionId");
$json = curl_exec($ch);
curl_close($ch);
$objJson = json_decode($json);

var_dump($objJson);


/**
 
object(stdClass)#1 (3) {
  ["authentication"]=>
  NULL
  ["session"]=>
  object(stdClass)#3 (7) {
    ["assuranceData"]=>
    object(stdClass)#2 (4) {
      ["level"]=>
      string(3) "1.1"
      ["protocol"]=>
      string(6) "cisApi"
      ["provider"]=>
      string(3) "cis"
      ["dataAsString"]=>
      string(14) "1.1 cisApi cis"
    }
    ["id"]=>
    string(41) "d0f5a93d-49bc-4f4c-b610-131e05be4231-prod"
    ["ipAddress"]=>
    string(11) "73.159.7.52"
    ["developerKey"]=>
    string(39) "3Z3L-Z4GK-J7ZS-YT3Z-Q4KY-YN66-ZX5K-176R"
    ["proxyId"]=>
    NULL
    ["proxyType"]=>
    NULL
    ["values"]=>
    array(0) {
    }
  }
  ["users"]=>
  array(0) {
  }
}


object(stdClass)#1 (3) {
  ["authentication"]=>
  NULL
  ["session"]=>
  object(stdClass)#3 (7) {
    ["assuranceData"]=>
    object(stdClass)#2 (4) {
      ["level"]=>
      string(3) "1.1"
      ["protocol"]=>
      string(6) "cisApi"
      ["provider"]=>
      string(3) "cis"
      ["dataAsString"]=>
      string(14) "1.1 cisApi cis"
    }
    ["id"]=>
    string(41) "d0f5a93d-49bc-4f4c-b610-131e05be4231-prod"
    ["ipAddress"]=>
    string(11) "73.159.7.52"
    ["developerKey"]=>
    string(39) "3Z3L-Z4GK-J7ZS-YT3Z-Q4KY-YN66-ZX5K-176R"
    ["proxyId"]=>
    NULL
    ["proxyType"]=>
    NULL
    ["values"]=>
    array(0) {
    }
  }
  ["users"]=>
  array(0) {
  }
}

 */			