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
/*
$test->read_meta('mlp.mp4');
$test->fetch_imdb();
$test->cache_image();
$test->escape();
$test->create_metadata();
$test->create_media();
*/

$test->get_library();

echo $test->output();
