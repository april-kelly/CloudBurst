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

//$test = new db;
//$results = $test->query('SElECT * FROM metadata');
//var_dump($results);

$test = new settings;
$test->fetch();

$test->dbc->get_errors();