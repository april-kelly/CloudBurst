<?php
/**
 * Name:        test.php
 * Description: A file for temporary tests of code while debugging
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//Includes
require_once('./path.php');
include_once(ABSPATH.'/includes/models/settings.php');
require_once(ABSPATH.'/includes/models/video.php');
require_once(ABSPATH.'/includes/models/tables/media.table.php');

$test = new media;

$test->media_id = '122';
$test->filename = 'adsfasdf.mp4';
$test->resolution = '720p';
$test->server_adderess = 'localhost';

$results = $test->insert();

var_dump($results);