<?php
/**
 * Name:        Settings
 * Description: Saves application settings
 * Date:        11/27/13
 * Programmer:  Liam Kelly
 */

if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

class settings {

    //Settings Definitions
    public $settings_path                 =   ''; //Defined in the constructor
    public $settings_filename             =   'settings.json';

    //General Settings
    public $version                       =   '0.0.1'; //Define the software version number
    public $version_type                  =   'pre-alpha'; //Defines the type of release alpha, beta etc

    //Constructor
    public function __construct(){

        //Define where the settings file is
        $this->settings_path =  ABSPATH.'includes/data/'.$this->settings_filename;

        //Make sure the settings file exists
        if(!(file_exists($this->settings_path))){

            //The file does not exist, create it
            file_put_contents($this->settings_path, '');

        }else{

            //The file exists, see if it need to be updated

            //Get the current settings
            $current_settings = (array) $this;

            //Get the file's version
            $settings_file = $this->fetch();

            //Check for difference
            if(!($current_settings == $settings_file)){

                //Settings file is out of date, update it
                $this->update($current_settings);

            }

        }

    }

    //Fetch settings
    public function fetch(){

        //Read the settings file
        $file_contents = file_get_contents($this->settings_path);

        //Decode the results
        if(!(empty($file_contents))){

            $settings = json_decode($file_contents);

        }else{

            //There is nothing to fetch so return false
            return false;

        }

        //Return the results, as an array
        return (array) $settings;

    }

    //Update settings
    public function update($settings){

        //Encode the settings
        $file_contents = json_encode($settings);

        //Write the settings
        file_put_contents($this->settings_path, $file_contents);


    }

}