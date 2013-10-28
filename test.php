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

$users = new users;
$users->username = 'kd0hdf@gmail.com';
$users->password = 'grapeshirt';
$test = $users->login();
var_dump($test);