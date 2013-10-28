<?php

/**
 * Name: Theme base
 * Programmer: Liam Kelly
 * Description: The base theme.
 * Date: 09/30/13
 */

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

//Figure out what the user is requesting
if(isset($_REQUEST['p'])){
    $request = $_REQUEST['p'];
}else{
    $request = 'home';
}

//Determine what page the user is looking for
switch($request){

    case 'Login':
        $main_id = 'login';
        $page = 'login.php';
    break;

    case 'home':
        $main_id = 'home';
        $page = 'home.php';
    break;

    case 'tv':
        $main_id = 'home';
        $page = 'tv.php';
    break;

    case 'video':
        $main_id = 'player';
        $page = 'video.php';
        $details = true;
    break;

    case 'settings':
        $main_id = 'settings';
        $page = 'settings.php';
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

    <link href="../styles/styles.css" rel="stylesheet" />

    <link href="./styles/styles.css" rel="stylesheet">
    <link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
    <link rel="stylesheet" href="/includes/libraries/bxslider/jquery.bxslider.css">
    <script src="/includes/libraries/jquery/jquery-1.10.2.min.js"></script>
    <script src="http://vjs.zencdn.net/c/video.js"></script>
    <script src="/includes/libraries/bxslider/jquery.bxslider.min.js"></script>

 
</head>

<body>

    <div id="nav">

        <?php

            require_once('./nav.php')

        ?>

    </div>

    <div id="<?php echo $main_id; ?>">

        <?php

            //Include the main content of the page
            include_once($page);


            //Include additional content if necessary
            if($details == true){
                include('details.php');
            }

         ?>

    </div>

    <div id="footer">

        <p>
            &copy; Copyright 2013 Liam Kelly<br />
            Portions &copy; Copyright 2012-2013 Bluetent Marketing.
        </p>

    </div>

</body>

</html>