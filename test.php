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
/*
$username = 'root';
$password = 'kd0hdf';
$id = 5;
try {
    $conn = new PDO('mysql:host=localhost;dbname=cloudburst', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare('SELECT * FROM media WHERE `index` = :id');
    $stmt->execute(array('id' => $id));

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $array[] = $row;
    }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
var_dump($array);
*/
$test = new db;
$handle = $test->prepare_media();
$results = $test->execute($handle, array('id' => 1));

var_dump($results);

$test->get_errors();