<?php

//Start the session
if(!(isset($_SESSION))){
    session_start();
}

//Start output buffering
ob_start();

/*

//Includes
require_once('./path.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/fetch.php');

//See if the video id is set
if(isset($_REQUEST['id'])){
    $dbc = new db;
    $dbc->connect();
    $id = $dbc->sanitize($_REQUEST['id']);
    $results = $dbc->query('SELECT * FROM `tv_shows` WHERE `index` = '.$id.'');
    $dbc->close();
}else{
    echo 'Malformed Request: Missing the video id.';
}

//The video exists
if(!(empty($results))){
*/
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title><?php echo $results[0]['name']; ?></title>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
        article, aside, figure, footer, header, hgroup,
        menu, nav, section { display: block; }
    </style>
    <style type="text/css">
        .container {
            width: 80%;
            margin: 0px auto;
        }
        video {
            max-width: 100%;
            height: auto;
        }
    </style>

    <link href="./styles/styles.css" rel="stylesheet">
    <link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/c/video.js"></script>

</head>
<body>
<div class="container">

    <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none"
           data-setup="{}">
        <source src="./videos/<?php echo $results[0]['location']; ?>" type='video/mp4' />
    </video>

</div>
<script>


    // Once the video is ready
    _V_("example_video_1").ready(function(){

        // Store the video object
        var myPlayer = this;
        // Make up an aspect ratio
        var aspectRatio = 1080/1920;

        function resizeVideoJS(){
            var width = document.getElementById(myPlayer.id).parentElement.offsetWidth;
            myPlayer.width(width).height( width * aspectRatio );

        }

        // Initialize resizeVideoJS()
        resizeVideoJS();
        // Then on resize call resizeVideoJS()
        window.onresize = resizeVideoJS;

        //myPlayer.play();
        //myPlayer.currentTime(200);

        <?php
        //echo 'myPlayer.currentTime('.$results[0]['left_off'].');';
        ?>

    });

</script>
<div id="time"></div>

<!-- Begin Mockup Section -->

<?php echo '<b>Now Playing: Season '.$results[0]['season'].', Epsode '.$results[0]['episode'].'</b>'; ?>

<table border="1">
    <tr>
       <td></td>
       <td></td>
       <td></td>
    </tr>
</table>


<!-- End Mockup Section -->

<script>
    (function(){
        var v = document.getElementsByTagName('video')[0]
        var t = document.getElementById('time');
        v.addEventListener('timeupdate',function(event){
            t.innerHTML = v.currentTime;
        },false);
    })();
</script>
</body>
</html>
<?php
/*
//In the event the video is not found
}else{
    echo "\r\n<br />Video not found!";
}
*/
//Send the output buffer
ob_end_flush();