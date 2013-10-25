<?php
/**
 * Name:        Video import tool
 * Description: Video import tool
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

//variable definitions
$debug = true;
$location = '../../../video/';

//Start looking for files to import
$array = scandir($location);

//Get rid of the . , .. and any files
$clean = array();
$i = 0;
foreach($array as $item){

    //Find files, .. , and .
    if(!(preg_match('/\./', $item))){

        //Add directories back
        $clean[$i] = $item;
        $i++;

    }

}

//Look for Subdirectories
foreach($clean as $item){

    //Look for files
    $sub = scandir($location.$item.'/');
    echo "Subdirectory: $item \r\n";
    var_dump($sub);
}

