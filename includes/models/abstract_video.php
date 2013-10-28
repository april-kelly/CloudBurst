<?php
/**
 * Name: Media Metadata Abstraction Layer
 * Description: An abstraction layer between media metadata and the database
 * Date: 10/18/13
 * Time: 10:13 PM
 * Programmer: Liam Kelly
 */

//Includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}
require_once(ABSPATH . '/includes/controllers/read_meta.php');
require_once(ABSPATH.'/includes/controllers/data.php');

//abstract_media class
class abstract_media {

    //Define variables

        //Database Fields

            //media table
            public $media_index             = '';
            public $media_type              = '';
            public $media_location          = '';
            public $media_description       = '';
            public $media_season            = '';
            public $media_episode           = '';
            public $media_title             = '';

            //types table
            public $types_index             = '';
            public $types_type              = '';
            public $types_name              = '';
            public $types_description       = '';

        //IMDb Data

            public $cover                   = '';
            public $title                   = '';
            public $plot_simple             = '';
            public $year                    = '';
            public $rated                   = '';
            public $rating                  = '';
            public $runtime                 = '';
            public $genres                  = '';
            public $language                = '';
            public $country                 = '';
            public $actors                  = '';
            public $writers                 = '';
            public $directors               = '';
            public $filming_locations       = '';
            public $ibdb_id                 = '';


        //Control Variables
            public $item                    = '';
            public $dbc                     = '';
            public $debug                   = true;

    //Define Functions

        //Rest Fields
        public function reset_fields(){

            /**
             * This function resets all field values to an empty state
             */

            //Reset fields
            $this->media_index              = null;
            $this->media_type               = null;
            $this->media_location           = null;
            $this->media_description        = null;
            $this->media_season             = null;
            $this->media_episode            = null;
            $this->types_index              = null;
            $this->types_type               = null;
            $this->types_name               = null;
            $this->types_description        = null;

            //return
            return true;

        }

        //Convert
        public function convert() {

            /**
             * This function converts metadata to a database friendly format
             */

            //Fetch the metadata
            $meta = fetch_meta($this->item);

            //Lookup
            $lookup = $this->lookup($meta['tv_show_name']);
            if(!($lookup == false)){

                //We exist do nothing

            }else{

                //Define what we will put in the types tables
                //$this->types_index = null;
                $this->types_name = $meta['tv_show_name'];
                $this->types_type = $meta['type'];
                $this->types_description = 'No description available.';

                //Insert the new media into types
                $this->create_new_type();

            }

            //Convert
            $this->media_index              = null;
            $this->media_type               = $lookup[0]['index'];
            $this->media_location           = $this->item;
            $this->media_description        = $meta['description'];
            $this->media_season             = $meta['tv_season'];
            $this->media_episode            = $meta['tv_episode'];

            //Debug output
            if($this->debug == true){
                echo 'Converted: '.$this->item."<br />\r\n";;
            }

            //Push to database
            $this->send();

        }

        //Send
        public function send()  {

            /**
             * This function sends the converted data to the database
             * @TODO Upate the query statement to support the new media table.
             */

            //Setup the database connection
            $this->dbc = new db;
            $this->dbc->connect();

            //Query the database
            $query = "INSERT INTO `video`.`tv_shows` (`index`, `type`, `name`, `season`, `episode`, `description`, `location`, `left_off`, `play_count`)
                           VALUES (NULL, '".$this->media_type."',
                                         '".$this->types_name."',
                                         '".$this->media_season."',
                                         '".$this->media_episode."',
                                         '".$this->media_description."',
                                         '".$this->item."',
                                         '00:00:00',
                                         '0');";
            $this->dbc->insert($query);

            //Close the database connection
            $this->dbc->close();

            //Debug output
            if($this->debug == true){
                echo 'Inserted: '.$this->item."<br />\r\n";
            }

        }

        //Lookup
        public function lookup($name) {

            /**
             * This function looks up names and types from metadata in the database to determine how to list
             */

            //Setup the database connection
            $this->dbc = new db;
            $this->dbc->connect();

            //Determine if the name is in the database

                //Prep string for search
                $name = $this->dbc->sanitize($name);
                $name = strtolower($name);

                //Query the database
                $query = "SELECT * FROM `types` WHERE `name` LIKE '%".$name."%'";
                $array = $this->dbc->query($query);

            //Close the database connection
            $this->dbc->close();

            return $array;

        }


        //Create a new entry in the types table
        public function create_new_type(){

            /**
             * This function creates a new entry in the types table from metadata placed in the $this object
             */

            //Setup the database connection
            $this->dbc = new db;
            $this->dbc->connect();

            //Query the database
            $query = "INSERT INTO `video`.`types` (`index`, `type`, `name`, `description`)
                      VALUES (NULL,
                              '".$this->types_type."',
                              '".$this->types_name."',
                              '".$this->types_description."')";
            $this->dbc->insert($query);

            //Close the database connection
            $this->dbc->close();

            //Debug output
            if($this->debug == true){
                echo 'Inserted new type: '.$this->types_name."<br />\r\n";
            }

        }

        //A very primative output of all titles in the types table
        public function fetch_list(){

        }


}