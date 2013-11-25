<?php
/**
 * Name:        test.php
 * Description: A file for temporary tests of code while debugging
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//Includes
require_once('./path.php');
include_once(ABSPATH.'/includes/models/pdo.php');

$test = new db;
$results = $test->query('SElECT * FROM metadata');
var_dump($results);