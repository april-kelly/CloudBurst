<?php
/**
 * Name:        Video.php
 * Description: Handles video import and serves as an abstraction layer to the database
 * Date:        10/31/13
 * Programmer:  Liam Kelly
 * TODO: Determine why media table is not inserting
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
            public $media_imdb_id           = '';

    //Control Variables
    public $item                    = '';
    public $dbc                     = '';
    public $output_buffer           = '';
    public $import_location         = 'content/uploads/'; //Well add the ABSPATH in the constructor
    public $metadata_next_index     = '';
    public $media_next_index        = '';
    public $cache_path              = 'content/cache/';
    public $fail                    = false;
    public $basename                = '';
    public $storage_dir             = 'content/videos/';

    //Constructor
    public function __construct(){

        //Setup output buffering

            //Send a debugging header
            ob_start();

            //Header
            echo '<h1>Class video Debugging mode enabled:';

            //Save the output buffer contents in the output variable
            echo "<hr /><br /><br />\r\n\r\n";
            $this->output_buffer = $this->output_buffer.ob_get_contents();
            ob_end_clean();

        //Setup the import_location variable

            //Add ABSPATH to the front
            //$this->import_location = ABSPATH.$this->import_location;

    }




    /**
     * Functions relating to pre-insert modifications of variables
     */

    //reset()
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
            //$this->media_location          = '';
            $this->media_comments          = '';

    }

    //escape()
    public function escape(){

        /**
         * Adds slashes to all of the database inputs (and everything else..)
         */

        //metadata table

        $this->index                   = addslashes($this->index);
        $this->subset_id               = addslashes($this->subset_id);
        $this->imdb_id                 = addslashes($this->imdb_id);
        $this->cover                   = addslashes($this->cover);
        $this->title                   = addslashes($this->title);
        $this->plot_simple             = addslashes($this->plot_simple);
        $this->year                    = addslashes($this->year);
        $this->rated                   = addslashes($this->rated);
        $this->rating                  = addslashes($this->rating);
        $this->runtime                 = addslashes($this->runtime);
        $this->genres                  = addslashes($this->genres);
        $this->language                = addslashes($this->language);
        $this->country                 = addslashes($this->country);
        $this->actors                  = addslashes($this->actors);
        $this->writers                 = addslashes($this->writers);
        $this->directors               = addslashes($this->directors);
        $this->filming_locations       = addslashes($this->filming_locations);
        $this->season                  = addslashes($this->season);
        $this->episode                 = addslashes($this->episode);
        $this->episode_name            = addslashes($this->episode_name);
        $this->episode_description     = addslashes($this->episode_description);
        $this->comments                = addslashes($this->comments);

        //media table

        $this->media_index             = addslashes($this->media_index);
        $this->media_metadata_id       = addslashes($this->media_metadata_id);
        $this->media_location          = addslashes($this->media_location);
        $this->media_comments          = addslashes($this->media_comments);
        $this->media_imdb_id           = addslashes($this->media_imdb_id);

        //Control

        $this->fail                    = false;
        $this->basename                = '';

        /*
        //Type cast $this so we can iterate through it
        $array = (array) $this;

        //Iterate through $array and addslashes() to each value
        foreach($array as $key => $value){

            //Send escaped values back to $this
            $this->$key = addslashes($array[$key]);

        }
        */

    }




    /**
     * Functions relating to database insert or modification
     */

    //create_media()
    public function create_media(){

        /**
         * Creates an entry in the media table
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: create_media() called:</h3>'."\r\n";

        //Stop if fail is true
        if($this->fail == false){

            //Setup the database connection
            $this->dbc = new db;
            $this->dbc->connect();

            //Escape bad chars
            $this->escape();

            //Determine the next index
            $this->fetch_increment();
            $this->media_index = $this->media_next_index;

            //Setup Query
            $query = "INSERT INTO `media` (`index`, `metadata_id`, `location`, `imdb_id`, `comments`)
                      VALUES (
                              '".$this->media_index."',
                              '".$this->index."',
                              '".$this->storage_dir.basename($this->media_location)."',
                              '".$this->media_imdb_id."',
                              '".$this->media_comments."')";

            //Issue query
            $this->dbc->insert($query);

            //Send debugging info
            echo 'Issued insert query: <br />'."\r\n";
            echo '<pre>'.$query.'</pre><br />'."\r\n";

            //Close the database connection
            $this->dbc->close();

        }else{

            echo '<span style="color:red;">Error $this->fail = true, failing.</span>';

        }


        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_get_contents();
        ob_end_clean();

    }

    //create_metadata()
    public function create_metadata(){

        /**
         * Creates an entry in the metadata table
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: create_metadata() called:</h3>'."\r\n";

        //Stop if fail is true
        if($this->fail == false){

            //Setup the database connection
            $this->dbc = new db;
            $this->dbc->connect();

            //Escape bad chars
            $this->escape();

            //Determine the next index
            $this->fetch_increment();
            $this->index = $this->metadata_next_index;

            //Cache the video's poster
            $this->cache_image();

            //Setup the Query
            $query = "INSERT INTO `metadata` (
                  `index`,
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
                  VALUES (
                  '".$this->index."',
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

        }else{

            echo '<span style="color:red;">Error $this->fail = true, failing.</span>';

        }


        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_get_contents();
        ob_end_clean();

    }

    //update_metadata()
    public function update_metadata(){

        /**
         * Updates the metadata table with the contents of this object
         */

    }

    //update_media()
    public function update_media(){

        /**
         * Updates an entry in the media table with the contents of this object
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: update_media() called:</h3>'."\r\n";

        //Setup the database connection
        $this->dbc = new db;
        $this->dbc->connect();

        //Escape bad chars
        $this->escape();

        //Setup Query
        $query = "UPDATE `media` SET
                `index`       = '".$this->index."',
                `metadata_id` = '".$this->media_metadata_id."',
                `location`    = '".$this->storage_dir.$this->basename."',
                `comments`    = '".$this->media_comments."'
                WHERE `index` = '".$this->index."';
                ";

        //Issue query
        $this->dbc->insert($query);

        //Send debugging info
        echo 'Issued insert query: <br />'."\r\n";
        echo '<pre>'.$query.'</pre><br />'."\r\n";

        //Close the database connection
        $this->dbc->close();

        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_get_contents();
        ob_end_clean();

    }




    /**
     * Functions relating to reading metadata
     */

    //lookup()
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
            $this->output_buffer = $this->output_buffer.ob_get_contents();
            ob_end_clean();

            //Return
            return true;

        }else{

            //The file is NOT in the db
            echo 'File: '.$this->media_location.' is NOT in the database.<br />'."\r\n";

            //Save the output buffer contents in the output variable
            echo "<hr /><br /><br />\r\n\r\n";
            $this->output_buffer = $this->output_buffer.ob_get_contents();
            ob_end_clean();

            //Return
            return false;

        }

    }

    //fetch_increment()
    public function fetch_increment(){

        /**
         * Determines the next increment in the media and metadata tables
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: fetch_increment() called:</h3>'."\r\n";

        //Determine next increment metadata table
        $query = "SHOW TABLE STATUS LIKE  'metadata'";
        $results = $this->dbc->query($query);
        $this->metadata_next_index = $results[0]['Auto_increment'];

        echo 'The next index for the metadata table is: '.$this->metadata_next_index.".<br />\r\n";

        //Determine next increment metadata table
        $query = "SHOW TABLE STATUS LIKE  'media'";
        $results = $this->dbc->query($query);
        $this->media_next_index = $results[0]['Auto_increment'];

        echo 'The next index for the metadata table is: '.$this->media_next_index.".<br />\r\n";

        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_get_contents();
        ob_end_clean();

    }

    //get_library()
    public function get_library() {

        /**
         * Fetches the first 10 unique videos in the database. Returns an associative array.
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: get_library() called:</h3>'."\r\n";

        //Stop if fail is true
        if($this->fail == false){

            //Setup the database connection
            $this->dbc = new db;
            $this->dbc->connect();

            //Query
            $query = 'SELECT  `index` ,  `title` ,  `cover` ,  `plot_simple` ,  `imdb_id` FROM metadata GROUP BY (imdb_id) LIMIT 0 , 9';

            //Issue query
            $results = $this->dbc->query($query);

            //Send debugging info
            echo 'Issued query: <br />'."\r\n";
            echo '<pre>'.$query.'</pre><br />'."\r\n";
            echo 'Results: <br />'."\r\n";
            echo '<pre>';
            var_dump($results);
            echo '</pre><br />'."\r\n";


            //Close the database connection
            $this->dbc->close();

        }else{

            echo '<span style="color:red;">Error $this->fail = true, failing.</span>';

        }


        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_get_contents();
        ob_end_clean();

        //Return the results
        return $results;

    }

    //fetch_video()
    public function fetch_video($id){

        /**
         * Fetches information about a video in the database
         */


        //Setup output buffering
        ob_start();
        echo '<h3>Function: get_library() called:</h3>'."\r\n";

        //Stop if fail is true
        if($this->fail == false){

            //Setup the database connection
            $this->dbc = new db;
            $this->dbc->connect();

            //Sanitize user inputs
            $id = $this->dbc->sanitize($id);

            //Query
            $query = 'SElECT * FROM media WHERE `index` = '.$id;

            //Issue query
            $media = $this->dbc->query($query);

            $return = array();
            $return['media'] = $media;

            //Get the metadata table
            if(isset($media[0]['metadata_id'])){

                //Query
                $query = 'SElECT * FROM metadata WHERE `index` = '.$media[0]['metadata_id'];


                //Issue query
                $metadata = $this->dbc->query($query);

                $return['metadata'] = $metadata;
            }


            //Send debugging info
            echo 'Results: <br />'."\r\n";
            echo '<pre>';
            var_dump($return);
            echo '</pre><br />'."\r\n";

            //Close the database connection
            $this->dbc->close();

            //Save the output buffer contents in the output variable
            echo "<hr /><br /><br />\r\n\r\n";
            $this->output_buffer = $this->output_buffer.ob_get_contents();
            ob_end_clean();

            //Return the results
            return $return;

        }else{

            echo '<span style="color:red;">Error $this->fail = true, failing.</span>';

            //Return false
            return false;

            //Save the output buffer contents in the output variable
            echo "<hr /><br /><br />\r\n\r\n";
            $this->output_buffer = $this->output_buffer.ob_get_contents();
            ob_end_clean();

        }

        return false;

    }

    //fetch_episodes()
    public function fetch_episodes($imdb_id){

        /**
         * Retrieves a list of tv episodes from the database using an imdb_id
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: fetch_episodes() called:</h3>'."\r\n";

        //Setup the database connection
        $this->dbc = new db;
        $this->dbc->connect();

        //Sanitize inputs
        $imdb_id = $this->dbc->sanitize($imdb_id);

        //Setup Query
        $query = "SElECT * FROM `media` WHERE `imdb_id` = '".$imdb_id."'";

        //Get the media table
        $media = $this->dbc->query($query);

        $return = array();
        $return['episodes'] = $media;

        //Find metadata for each episode
        $i = 0;
        if(is_array($return['episodes'])){

            foreach($return['episodes'] as $episode){

                if(isset($episode['metadata_id'])){

                    //Query
                    $query = 'SElECT * FROM metadata WHERE `index` = '.$episode['metadata_id'];


                    //Issue query
                    $metadata = $this->dbc->query($query);

                    $return['episodes'][$i]['metadata'] = $metadata;
                    $i++;
                }

            }

        }

        //Send debugging info
        echo 'I recieved the following: <br />'."\r\n";
        echo '<pre>';
        var_dump($return);
        echo '</pre><br />'."\r\n";

        //Close the database connection
        $this->dbc->close();

        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_get_contents();
        ob_end_clean();

        //Return results
        return $return;


    }




    /**
     * Functions interfacing with to external libraries or apis
     */

    //fetch_imdb()
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

        //Stop if fail is true
        if($this->fail == false){

        //Fetch the movie info
        $json = file_get_contents($url);

        //Convert json to array
        $array = json_decode($json);

        //Debug results (from imdb)
        //This generates a lot of output so we'll keep it commented out unless needed

        /*
        echo "Results of request: <br />\r\n";
        echo '<pre>';
        var_dump($array);
        echo '</pre>';
        echo "<br />\r\n";
        */

        //Deal with the results
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
                $this->imdb_id = $array[0]->imdb_id;
                $this->media_imdb_id = $array[0]->imdb_id;
            }
        }


        //Figure out the episode title
        if(isset($this->season) && isset($this->episode)){

            if(isset($array[0]->episodes)){

                foreach($array[0]->episodes as $episode){

                    //find episode
                    if($episode->season == $this->season){

                        //Great, now find the episode
                        if($episode->episode == $this->episode){

                            //Save the title
                            if(isset($episode->title)){

                                echo 'Episode Title Determined: '.$episode->title."<br /> \r\n";
                                $this->episode_name = $episode->title;

                            }

                        }

                    }

                }

            }

        }


        }else{

            echo '<span style="color:red;">Error $this->fail = true, failing.</span>';

        }

        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_get_contents();
        ob_end_clean();

        //Return the abstract video object
        return $this;

    }

    //read_meta()
    public function read_meta($filename){

        /**
         * Reads metadata from a video file
         */

        //Define which file we will read
        $this->basename = $filename;
        $this->media_location = $this->import_location.$filename;
        $filename = ABSPATH.$this->import_location.$filename;

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
            $this->fail = true;
            echo '<span style="color:red;">Error: TV Show Name not found! Failing</span>';
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

        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_get_contents();
        ob_end_clean();

        //Return the metadata
        return $meta;

    }




    /**
     * Functions relating to actions
     */

    //cache_image()
    public function cache_image(){

        /**
         * Downloads the video's poster and saves it into /content/cache/
         */

        //Setup output buffering
        ob_start();
        echo '<h3>Function: cache_image() called:</h3>'."<br /> \r\n";
        echo 'Downloading: '.$this->cover."<br /> \r\n";;

        //Stop if fail is true
        if($this->fail == false){

            //Come up with a unique filename
            $name = $this->cache_path.time().'.jpg';

            //Download the image
            $image = file_get_contents($this->cover);
            file_put_contents($name, $image);

            //Change the name of the file for database insert
            echo 'Saved as: '.$this->cover;
            $this->cover = $name;

        }else{

            echo '<span style="color:red;">Error $this->fail = true, failing.</span>';

        }


        //Save the output buffer contents in the output variable
        echo "<hr /><br /><br />\r\n\r\n";
        $this->output_buffer = $this->output_buffer.ob_get_contents();
        ob_end_clean();

    }

    //import()
    public function import($filename){

        /**
         * Imports a video file to the database.
         */

        //Read the files metadata
        $this->read_meta($filename);

        //Attempt to fetch more information from IMDb
        $this->fetch_imdb();

        //Create an entry in the metadata table
        $this->create_metadata();

        //Create an entry in the media table
        $this->create_media();

        //Reset the fields for the next import
        $this->reset();

        //Move the file
        if($this->fail == false){

            //Only if the fail flag is not true
            rename(ABSPATH.$this->media_location, ABSPATH.$this->storage_dir.basename($this->media_location));

        }


    }




    //output()
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