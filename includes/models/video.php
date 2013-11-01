<?php
/**
 * Name:        Video.php
 * Description: Handles video import and serves as an abstraction layer to the database
 * Date:        10/31/13
 * Programmer:  Liam Kelly
 */

//includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}
require_once(ABSPATH.'includes/controllers/data.php');
require_once(ABSPATH.'includes/libraries/getID3-1.9.7/getid3/getid3.php');

class video {

    //Define variables

        //Database Fields

            //metadata table

            public $index = '';
            public $subset_id = '';
            public $ibdb_id                 = '';
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
            public $season                  = '';
            public $episode                 = '';
            public $episode_name            = '';
            public $episode_description     = '';
            public $comments                = '';


            //media table

            public $media_index             = '';
            public $media_metadata_id       = '';
            public $media_location          = '';
            public $media_comments          = '';

    //Control Variables
    public $item                    = '';
    public $dbc                     = '';
    public $debug                   = true;
    public $output_buffer           = '';


    //read_meta
    public function read_meta($filename){

        /**
         * Reads metadata from a video file
         */

        //Define which file we will read
        $filename = ABSPATH.'content/uploads/'.$filename;

        //setup getID3
        $getID3 = new getID3;

        // Analyze file and store returned data in $ThisFileInfo
        $ThisFileInfo = $getID3->analyze($filename);
        getid3_lib::CopyTagsToComments($ThisFileInfo);

        //Setup the array
        $meta = array();

        //Setup output buffering
        ob_start();

        //Type of video (tv show, movie, etc) (not supported currently in db)
        /*
        if(isset($ThisFileInfo['tags']['quicktime']['stik'][0])){
            echo "<br />\r\n".'Type:        '.$ThisFileInfo['tags']['quicktime']['stik'][0];
            $meta['type'] = $ThisFileInfo['tags']['quicktime']['stik'][0];
        }else{
            $meta['type'] = '';
        }
        */


        //TV Show Name (name of the series)
        if(isset($ThisFileInfo['tags']['quicktime']['tv_show_name'][0])){
            echo "<br />\r\n".'Name:        '.$ThisFileInfo['tags']['quicktime']['tv_show_name'][0];
            $meta['tv_show_name'] = $ThisFileInfo['tags']['quicktime']['tv_show_name'][0];
            $this->title = $meta['tv_show_name'];
        }else{
            $meta['tv_show_name'] = '';
        }

        //TV Season (typically int)
        if(isset($ThisFileInfo['tags']['quicktime']['tv_season'][0])){
            echo "<br />\r\n".'Season:      '.$ThisFileInfo['tags']['quicktime']['tv_season'][0];
            $meta['tv_season'] = $ThisFileInfo['tags']['quicktime']['tv_season'][0];
            $this->season = $meta['tv_season'];
        }else{
            $meta['tv_season'] = '';
        }

        //TV Episode (typically int)
        if(isset($ThisFileInfo['tags']['quicktime']['tv_episode'][0])){
            echo "<br />\r\n".'Episode:     '.$ThisFileInfo['tags']['quicktime']['tv_episode'][0];
            $meta['tv_episode'] = $ThisFileInfo['tags']['quicktime']['tv_episode'][0];
            $this->episode = $meta['tv_episode'];
        }else{
            $meta['tv_episode'] = '';
        }

        //Description
        if(isset($ThisFileInfo['tags']['quicktime']['description'][0])){
            echo "<br />\r\n".'Description: '.$ThisFileInfo['tags']['quicktime']['description'][0];
            $meta['description'] = $ThisFileInfo['tags']['quicktime']['description'][0];
            $this->episode_description = $meta['description'];
        }else{
            $meta['description'] = '';
        }

        //TV Network Name (not currently supported in db)
        /*
        if(isset($ThisFileInfo['tags']['quicktime']['tv_nework_name'][0])){
            //echo "<br />\r\n".'Network:     '.$ThisFileInfo['tags']['quicktime']['tv_network_name'][0];
            $meta['tv_network_name'] = $ThisFileInfo['tags']['quicktime']['tv_network_name'][0];
        }else{
            $meta['tv_network_name'] = '';
        }
        */

        //End output buffering
        $this->output_buffer = $this->output_buffer.ob_end_flush();

        //Return the metadata
        return $meta;

    }

    //lookup
    public function lookup(){

        /**
         * Determines if a file is already in the database
         */

    }

    //insert
    public function insert(){

        /**
         * Inserts a video file into the database
         */

    }

    //fetch_imdb
    public function fetch_imdb() {

        /**
         * Fetches meta data from IMDb
         */

    }


    //update_metadata
    public function update_metadata(){

        /**
         * Updates the metadata table with the contents of this object
         */

    }

    //update_media
    public function update_media(){

        /**
         * Updates the media table with the contents of this object
         */

    }


}