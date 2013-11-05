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
            public $imdb_id                 = '';
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
    public $output_buffer           = '';

    //Constructor
    public function __construct(){

        //Setup output buffering

            //Send a debugging header
            ob_start();

            //Header
            echo '<h1>Class video Debugging mode enabled:';

            //Save to output buffer
            echo "<hr /><br /><br />\r\n\r\n";
            $this->output_buffer = $this->output_buffer.ob_end_flush();

    }

    //Reset variables
    public function reset(){

        /**
         * Resets database fields to their default values.
         */

        //Database Fields

        //metadata table

        $this->index = '';
            $this->subset_id = '';
            $this->imdb_id                 = '';
            $this->cover                   = '';
            $this->title                   = '';
            $this->plot_simple             = '';
            $this->year                    = '';
            $this->rated                   = '';
            $this->rating                  = '';
            $this->runtime                 = '';
            $this->genres                  = '';
            $this->language                = '';
            $this->country                 = '';
            $this->actors                  = '';
            $this->writers                 = '';
            $this->directors               = '';
            $this->filming_locations       = '';
            $this->season                  = '';
            $this->episode                 = '';
            $this->episode_name            = '';
            $this->episode_description     = '';
            $this->comments                = '';

            //media table

            $this->media_index             = '';
            $this->media_metadata_id       = '';
            $this->media_location          = '';
            $this->media_comments          = '';

    }

    //read_meta
    public function read_meta($filename){

        /**
         * Reads metadata from a video file
         */

        //Define which file we will read
        $filename = ABSPATH.'content/uploads/'.$filename;
        $this->media_location = $filename;

        //setup getID3
        $getID3 = new getID3;

        // Analyze file and store returned data in $ThisFileInfo
        $ThisFileInfo = $getID3->analyze($filename);
        getid3_lib::CopyTagsToComments($ThisFileInfo);

        //Setup the array
        $meta = array();

        //Setup output buffering
        ob_start();
        echo '<h3>Function: read_meta() called:</h3>'."\r\n";

        //Dump the $ThisFileInfo variable
        /*
        echo 'Dumping the meta data: <br />'."\r\n";
        echo '<pre>';
        var_dump($ThisFileInfo);
        echo '</pre>';
        */

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
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_end_flush();

        //Return the metadata
        return $meta;

    }

    //lookup
    public function lookup(){

        /**
         * Determines if a file is already in the database
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: lookup() called:</h3>'."\r\n";

        //Setup the database connection
        $this->dbc = new db;
        $this->dbc->connect();

        //Determine if the name is in the database

        //Prep string for search
        $name = $this->dbc->sanitize($this->media_location);
        $name = strtolower($name);

        //Query the database
        $query = "SELECT * FROM `media` WHERE `location` LIKE '%".$name."%'";
        $array = $this->dbc->query($query);

        //Close the database connection
        $this->dbc->close();

        //Process the results
        if(count($array) >= 1 && isset($array[0]['index'])){

            //The file IS in the db
            echo 'File: '.$this->media_location.' IS in the database.<br />'."\r\n";

            //Save the output buffer contents in the output variable
            echo "<hr /><br /><br />\r\n\r\n";
            $this->output_buffer = $this->output_buffer.ob_end_flush();

            //Return
            return true;

        }else{

            //The file is NOT in the db
            echo 'File: '.$this->media_location.' is NOT in the database.<br />'."\r\n";

            //Save the output buffer contents in the output variable
            echo "<hr /><br /><br />\r\n\r\n";
            $this->output_buffer = $this->output_buffer.ob_end_flush();

            //Return
            return false;

        }

    }

    //create_media
    public function create_media(){

        /**
         * Creates an entry in the media table
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: create_media() called:</h3>'."\r\n";

        //Setup the database connection
        $this->dbc = new db;
        $this->dbc->connect();

        //Escape bad chars
        $this->escape();

        //Setup Query
        $query = "INSERT INTO `media` (`index`, `metadata_id`, `location`, `comments`)
                      VALUES (NULL,
                              '".$this->index."',
                              '".$this->media_location."',
                              '".$this->media_comments."')";

        //Issue query
        $this->dbc->insert($query);

        //Send debugging info
        echo 'Issued insert query: <br />'."\r\n";
        echo '<pre>'.$query.'</pre><br />'."\r\n";

        //Close the database connection
        $this->dbc->close();

        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_end_flush();


    }

    //create_metadata
    public function create_metadata(){

        /**
         * Creates an entry in the metadata table
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: create_metadata() called:</h3>'."\r\n";

        //Setup the database connection
        $this->dbc = new db;
        $this->dbc->connect();

        //Escape bad chars
        $this->escape();

        //Setup the Query
        $query = "INSERT INTO `metadata` (`index`,
                  `subset_id`,
                  `imdb_id`,
                  `cover`,
                  `title`,
                  `plot_simple`,
                  `year`,
                  `rated`,
                  `rating`,
                  `runtime`,
                  `genres`,
                  `language`,
                  `country`,
                  `actors`,
                  `writers`,
                  `directors`,
                  `filming_locations`,
                  `season`,
                  `episode`,
                  `episode_name`,
                  `episode_description`,
                  `comments`)
                  VALUES (NULL,
                  '".$this->subset_id."',
                  '".$this->imdb_id."',
                  '".$this->cover."',
                  '".$this->title."',
                  '".$this->plot_simple."',
                  '".$this->year."',
                  '".$this->rated."',
                  '".$this->rating."',
                  '".$this->runtime."',
                  '".$this->genres."',
                  '".$this->language."',
                  '".$this->country."',
                  '".$this->actors."',
                  '".$this->writers."',
                  '".$this->directors."',
                  '".$this->filming_locations."',
                  '".$this->season."',
                  '".$this->episode."',
                  '".$this->episode_name."',
                  '".$this->episode_description."',
                  '".$this->comments."'
                  );";

        //Issue query
        $this->dbc->insert($query);

        //Send debugging info
        echo 'Issued insert query: <br />'."\r\n";
        echo '<pre>'.$query.'</pre><br />'."\r\n";

        //Close the database connection
        $this->dbc->close();

        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_end_flush();


    }

    //fetch_imdb
    public function fetch_imdb() {

        /**
         * Fetches meta data from IMDb
         */

        //Determine how we will be searching IMDb
        if(!(empty($this->imdb_id))){

            //Search via IMDb id
            $imdb_id = urlencode($this->imdb_id);
            $url = 'http://mymovieapi.com/?ids='.$imdb_id.'&type=json&plot=simple&episode=1&lang=en-US&aka=simple&release=simple&business=0&tech=0';

        }elseif(!(empty($this->title))){

            //Search via title
            $title = urlencode($this->title);
            $url = 'http://mymovieapi.com/?title='.$title.'&type=json&plot=simple&episode=1&limit=1&yg=0&mt=none&lang=en-US&offset=&aka=simple&release=simple&business=0&tech=0';

        }else{

            //Nothing to query
            return false;

        }

        //Setup output buffering
        ob_start();
        echo '<h3>Function: fetch_imdb() called:</h3>'."\r\n";

        //Fetch the movie info
        $json = file_get_contents($url);

        //Convert json to array
        $array = json_decode($json);

        //Get rid of episode list before var_dumping
        //unset($array[0]->episodes);

        //Debug
        /*
        echo "Results of request: <br />\r\n";
        echo '<pre>';
        var_dump($array);
        echo '</pre>';
        echo "<br />\r\n";
        */

        //Echo the results
        if(isset($array[0])){
            if(isset($array[0]->poster->cover)){
                echo '<img src="'.$array[0]->poster->cover.'" /><br />';
                $this->cover = $array[0]->poster->cover;
            }

            if(isset($array[0]->title)){
                echo 'Title: '.$array[0]->title."<br /> \r\n";
                $this->title = $array[0]->title;
            }

            if(isset($array[0]->plot_simple)){
                echo 'Plot: '.$array[0]->plot_simple."<br /> \r\n";
                $this->plot_simple = $array[0]->plot_simple;
            }

            if(isset($array[0]->year)){
                echo 'Year: '.$array[0]->year."<br /> \r\n";
                $this->year = $array[0]->year;
            }

            if(isset($array[0]->rated)){
                echo 'Rated: '.$array[0]->rated."<br /> \r\n";
                $this->rated = $array[0]->rated;
            }

            if(isset($array[0]->rating)){
                echo 'Rating: '.$array[0]->rating."<br /> \r\n";
                $this->rating = $array[0]->rating;
            }

            if(isset($array[0]->runtime)){
                echo 'Runtime(s): '.implode(', ', $array[0]->runtime)."<br /> \r\n";
                $this->runtime = implode(', ', $array[0]->runtime);
            }

            if(isset($array[0]->genres)){
                echo 'Genre(s): '.implode(', ', $array[0]->genres)."<br /> \r\n";
                $this->genres = implode(', ', $array[0]->genres);
            }

            if(isset($array[0]->language)){
                echo 'Language(s): '.implode(', ', $array[0]->language)."<br /> \r\n";
                $this->language = implode(', ', $array[0]->language);
            }

            if(isset($array[0]->country)){
                echo 'Country(s): '.implode(', ', $array[0]->country)."<br /> \r\n";
                $this->country = implode(', ', $array[0]->country);
            }

            if(isset($array[0]->actors)){
                echo 'Actors: '.implode(', ', $array[0]->actors)."<br /> \r\n";
                $this->actors = implode(', ', $array[0]->actors);
            }

            if(isset($array[0]->directors)){
                echo 'Director(s): '.implode(', ', $array[0]->directors)."<br /> \r\n";
                $this->directors = implode(', ', $array[0]->directors);
            }

            if(isset($array[0]->writers)){
                echo 'Writer(s): '.implode(', ', $array[0]->writers)."<br /> \r\n";
                $this->writers = implode(', ', $array[0]->writers);
            }

            if(isset($array[0]->filming_locations)){
                echo 'Filming Location(s): '.$array[0]->filming_locations."<br /> \r\n"; //This is output as a string for some reason
                $this->filming_locations = $array[0]->filming_locations;
            }

            if(isset($array[0]->imdb_id)){
                echo 'IMDb id: '.$array[0]->imdb_id."<br /> \r\n";
                $this->ibdb_id = $array[0]->imdb_id;
            }
        }

        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_end_flush();

        //Return the abstract video object
        return $this;

    }

    //escape
    public function escape(){

        /**
         * Adds slashes to all of the database inputs (and everything else..)
         * TODO: Make this function only effect the database inputs.
         */

        //Type cast $this so we can iterate through it
        $array = (array) $this;

        //Iterate through $array and addslashes() to each value
        foreach($array as $key => $value){

            //Send escaped values back to $this
            $this->$key = addslashes($array[$key]);

        }

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

    //output
    public function output(){

        /**
         * Sends the contents of the output_buffer variable
         */

        //Send the output buffer;
        echo $this->output_buffer;

        //return
        return true;
    }


}