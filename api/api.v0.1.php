<?php
/**
 * Name:        CloudBurst API Version 0.1
 * Date:        11/16/13
 * Programmer:  Liam Kelly
 */

//Includes
if(!(defined('ABSPATH'))){
    require_once('../path.php');
}
require_once(ABSPATH.'includes/models/video.php');

//Handel Options
$options = json_decode(options);


//Define routes
switch(url){

    case '/fetch/video/':

        $video = new video;
        $response = $video->fetch_video($options->id);

    break;

    default:
        $response['status'] = 'Error invalid request.';
        header($_SERVER['SERVER_PROTOCOL'].'404 Not Found!');
    break;

}

//Send the response

    //for json
    if(format == 'json'){

        echo json_encode($response);

    }
