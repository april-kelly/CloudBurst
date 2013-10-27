<!DOCTYPE html>

<html>

<head>

    <title>Video Player</title>
    <!--<link href="../styles/styles.css" rel="stylesheet" />-->
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


    <link href="./styles/styles.css" rel="stylesheet">
    <link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/c/video.js"></script>

    <style>

        body{
            background-color: dimgray;
            background-image:url('../images/concrete_wall.png');
            background-repeat: repeat;
            text-align: center;
        }

        #nav-bar{
            left: 0;
            top: 0;
            background: lightgray;
            position: fixed;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
            height: 50px;
            z-index: 1000;
            opacity: 0.5;
        }

        #nav-bar:hover{
            opacity: 0.9;
        }

        #player{
            background: darkgray;
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
            height: 1000px;
            max-width: 80%;
        }

        #container{
            margin-top: 50px;
        }

        #footer{
            color: #888;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }



    </style>

</head>

<body>

<div id="nav-bar"><p>navbar</p></div>
<div id="player">

    <?php include_once('./video.php'); ?>

    <div id="details">


    </div>

</div>
<div id="footer"><p>&copy; Copyright 2013 Liam Kelly<br />Portions &copy; Copyright 2012-2013 Bluetent Marketing.</p></div>

</body>

</html>