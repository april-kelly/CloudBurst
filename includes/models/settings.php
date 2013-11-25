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
    public $settings;

    //constructor
    public function __construct(){

        //Establish a connection to the database
        $this->dbc = new db;

    }

    //fetch function
    public function fetch(){

        //fetch the settings
        $this->settings = $this->dbc->query('SELECT * FROM settings');

    }

    //push function
    public function push($settings){



    }

}