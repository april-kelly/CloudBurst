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
$results = $test->lookup(1);

var_dump($results);