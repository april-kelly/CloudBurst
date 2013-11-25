<?php
/**
 * Name:        Settings Abstraction Layer
 * Description: Saves application settings in the database for later use
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}
require_once('pdo.php');

class settings{

    public $dbc;

    //constructor
    public function __construct(){

        //Establish a connection to the database
        $this->dbc = new db;


    }

    //fetch function
    public function fetch(){

    }

    //update function

    //remove function

    //add function



}