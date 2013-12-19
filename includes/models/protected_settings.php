<?php
/**
 * Name:        Protected Settings
 * Description: Holds settings which are sensitive, such as the salt
 * Date:        11/27/13
 * Programmer:  Liam Kelly
 */

class protected_settings{

    //Define settings
    public $salt               = 'a21fe803207b7c41957d5f9856355038e9168e6ff9ece47f008aade2113f4e657547101ce4c917d27e8a9ddc1d561c20251ba74692dac4f3c612a9a3093f5161'; //Salt for hashing passwords
    public $db_user            = 'root';
    public $db_pass            = 'kd0hdf';
    public $db_host            = 'localhost';
    public $db_name            = 'cloudburst2';

    //Fetch Settings
    public function fetch(){

        //Return the settings
        return (array) $this;

    }

}