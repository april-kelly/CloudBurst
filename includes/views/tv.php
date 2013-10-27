<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Liam Kelly
 * Date: 10/18/13
 * Time: 9:50 PM
 * To change this template use File | Settings | File Templates.
 */

//includes
require_once('../path.php');
require_once(ABSPATH.'/includes/data.php');

//Fetch the list of TV Shows

    //Setup the database connection
    $dbc = new db;
    $dbc->connect();

    //Get the list
    $query = 'SELECT * FROM `tv_shows`';
    $list = $dbc->query($query);

    //Close the database connection
    $dbc->close();

//Preprocess the list
var_dump($list);

//Echo out the tv_shows
foreach($list as $item){

    echo '<br />';
    echo $item['name'];
    echo '<br />';


}