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
require_once(ABSPATH.'includes/models/users.php');

//Handel Options
$options = json_decode(options);


//Define routes
switch(url){

    /**
     * User related routes
     */

    case '/users/login/':

        //Make sure both username and password are sent
        if(isset($options->username) && isset($options->password)){

            $users = new users;
            $result = $users->login($options->username, $options->password);

            //Make sure we got a good result
            if($result == true){

                $response = $users;

            }else{

                //Bad login
                return false;

            }

        }else{

            //Let the user know of a bad combo
            $response = false;

        }

    break;

    case '/users/logout/':

        //Destroy the session
        session_destroy();

        $response = true;

    break;

    /**
     * End user routes
     */

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
