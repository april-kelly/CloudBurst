<?php
/**
 * Name:        test.php
 * Description: A file for temporary tests of code while debugging
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//Includes
require_once('./path.php');
include_once(ABSPATH.'/includes/models/abstract_video.php');
include_once(ABSPATH.'/includes/models/users.php');
include_once(ABSPATH.'/includes/models/video.php');

$test = new video;


//Scan the dir
$dir = scandir(ABSPATH.'content/uploads');

//Get rid of the . and ..
unset($dir[0]);
unset($dir[1]);

//Start importing files
foreach($dir as $file){

    if(preg_match('/.mp4/', $file)){

        //This is an mp4 so we will continue
        $test->import($file);

    }

}


//$test->fetch_episodes('tt1751105');


echo $test->output();
