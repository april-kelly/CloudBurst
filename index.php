<?php

/**
 * Name: Theme Base
 * Programmer: Liam Kelly
 * Description: The base theme.
 * Date: 09/30/13
 */

//includes
if(!(defined('ABSPATH'))){
    require_once('./path.php');
}
include_once(ABSPATH.'includes/controllers/get_ip.php');

//Setup the user's Session
if(!(isset($_SESSION))){
    session_start();
}

//Define variables

    //Page Title
    $title = '';

    //Main div id
    $main_id = '';

    //Video details enable
    $details = false;

    //Page to include
    $page = '';

    //Enable/Disable the nav bar
    $nav = true;

//Figure out what the user is requesting
if(isset($_REQUEST['p'])){
    $request = $_REQUEST['p'];
}else{
    $request = 'home';
}
$request = str_replace('/', '', $request);

//Send error messages to pages
if(isset($_REQUEST['e'])){
    $_SESSION['e'] = $_REQUEST['e'];

}

//Figure out if the user is on the local area network
if(!(is_local())){
    if(!(isset($_SESSION['user_id']))){
        if(!($request == 'login')){
            header('location: ./?p=login');
        }
        //Destroy an existing local session if outside local network
    }elseif($_SESSION['user_id'] == '0'){
        if(!($request == 'login')){
            header('location: ./?p=login');
        }
    }
}

//Determine what page the user is looking for
switch($request){

    case 'login':
        $main_id = 'login';
        $page = 'login_form.php';
        $nav = false;
    break;

    case 'home':
        $main_id = 'home';
        $page = 'home.php';
    break;

    case 'tv':
        $main_id = 'home';
        $page = 'home.php';
    break;

    case 'live':
        $main_id = 'live';
        $page = 'live.php';
    break;

    case 'video':
        $main_id = 'player';
        $page = 'player.php';
        $details = true;
        $_SESSION['video_id'] = $_REQUEST['id'];
    break;

    case 'settings':
        $main_id = 'settings';
        $page = 'settings.php';
    break;

    case 'logout':
        $main_id = 'login';
        $page = 'login_form.php';
        $nav = false;
        session_destroy();
    break;

    default:
        $main_id = 'fourohfour';
        $page = './errors/404.php';
    break;
}

?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>

    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link href="./includes/views/styles/styles.css" rel="stylesheet" />

    <link href="./includes/libraries/jquery/video-js.css" rel="stylesheet">
    <link rel="stylesheet" href="/includes/libraries/bxslider/jquery.bxslider.css">
    <script src="./includes/libraries/jquery/jquery-1.10.2.min.js"></script>
    <script src="./includes/libraries/video-js/video.js"></script>
    <script src="./includes/libraries/bxslider/jquery.bxslider.min.js"></script>

    <link href="http://bxslider.com/lib/jquery.bxslider.css" rel="stylesheet" />

    <link href="./styles/styles.css" rel="stylesheet">
    <link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/c/video.js"></script>

</head>

<body>

    <?php
        if($nav == true){
    ?>

        <div id="nav">

            <?php

                require_once(ABSPATH.'/includes/views/nav.php')

            ?>

        </div>

    <?php
        }
    ?>

    <div id="<?php echo $main_id; ?>">

        <?php

            //Include the main content of the page
            include_once(ABSPATH.'/includes/views/'.$page);


            //Include additional content if necessary
            if($details == true){
                include(ABSPATH.'/includes/views/details.php');
            }

         ?>

    </div>

    <div id="footer">

        <p>
            &copy; Copyright 2013 Liam Kelly<br />
            For more information please see the LICENSE.md file.
        </p>

    </div>

</body>

</html>