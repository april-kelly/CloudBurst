<?php
/**
 * Name:        List.php
 * Description: Lists episodes in a tv show
 * Date:        11/11/13
 * Programmer:  Liam Kelly
 */

if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

require_once(ABSPATH.'includes/controllers/data.php');

$dbc = new db;

$dbc->connect();
$dbc->query($query);
$dbc->close();