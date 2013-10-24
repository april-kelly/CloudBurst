<?php
/**
 * Name:        test.php
 * Description: A file for temporary tests of code while debugging
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//Includes
require_once('./path.php');
include_once(ABSPATH.'/includes/controllers/data.php');

$dbc = new db;
$dbc->connect();
$test = $dbc->insert("INSERT INTO `video`.`tv_shows` (`index`, `type`, `name`, `season`, `episode`, `description`, `location`, `left_off`, `play_count`) VALUES (NULL, 'tv_show', 'asdfasdf', '3', '3', 'adsfasdfasdfadfadsf', 'asdfadsf', 'asdfasdf', '2');");
$dbc->close();

//var_dump($test);
