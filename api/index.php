<?php
/**
 * Name:        CloudBurst api request handler
 * Description: Sends requests to the correct api version
 * Date:        11/16/13
 * Programmer:  Liam Kelly
 */

//Fetch the request
$url = $_REQUEST['url'];

//Determine the api version and format
$array = explode('/', $_REQUEST['url']);
$version = $array[1];
$format = $array[2];

//Get rid of the api version and format
unset($array[1]);
unset($array[2]);
$url = implode('/', $array);

if(file_exists('api.'.$version.'.php')){

    //The api version exists, invoke it
    define('url', $url);
    define('format', $format);
    require_once('api.'.$version.'.php');


}else{

    //The requested api version does not exist
    header($_SERVER['SERVER_PROTOCOL'].'500 Internal Server Error');

}