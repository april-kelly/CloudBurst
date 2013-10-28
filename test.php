<?php
/**
 * Name:        test.php
 * Description: A file for temporary tests of code while debugging
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//Includes
require_once('./path.php');
include_once(ABSPATH.'/includes/models/abstract_video.php');

//Fetch the movie info
$title = urlencode($_REQUEST['t']);
$json = file_get_contents('http://mymovieapi.com/?title='.$title.'&type=json&plot=simple&episode=1&limit=1&yg=0&mt=none&lang=en-US&offset=&aka=simple&release=simple&business=0&tech=0');

//Convert json to array
$array = json_decode($json);

//Get rid of episode list before var_dumping
//unset($array[0]->episodes);
//Debug
echo '<pre>';
var_dump($array);
echo '</pre>';

//Setup the video abstraction layer
$test = new abstract_media;

//Echo the results
if(isset($array[0])){
    if(isset($array[0]->poster->cover)){
        //echo '<img src="'.$array[0]->poster->cover.'" /><br />';
        $test->cover = $array[0]->poster->cover;
    }

    if(isset($array[0]->title)){
        //echo 'Title: '.$array[0]->title."<br /> \r\n";
        $test->title = $array[0]->title;
    }

    if(isset($array[0]->plot_simple)){
        //echo 'Plot: '.$array[0]->plot_simple."<br /> \r\n";
        $test->plot_simple = $array->plot_simple;
    }

    if(isset($array[0]->year)){
        //echo 'Year: '.$array[0]->year."<br /> \r\n";
        $test->year = $array[0]->year;
    }

    if(isset($array[0]->rated)){
        //echo 'Rated: '.$array[0]->rated."<br /> \r\n";
        $test->rated = $array[0]->rated;
    }

    if(isset($array[0]->rating)){
        //echo 'Rating: '.$array[0]->rating."<br /> \r\n";
        $test->rating = $array[0]->rating;
    }

    if(isset($array[0]->runtime)){
       //echo 'Runtime(s): '.implode(', ', $array[0]->runtime)."<br /> \r\n";
       $test->runtime = $array[0]->runtime;
    }

    if(isset($array[0]->genres)){
        //echo 'Genre(s): '.implode(', ', $array[0]->genres)."<br /> \r\n";
        $test->genres = $array[0]->genres;
    }

    if(isset($array[0]->language)){
        //echo 'Language(s): '.implode(', ', $array[0]->language)."<br /> \r\n";
        $test->language = $array[0]->language;
    }

    if(isset($array[0]->country)){
        //echo 'Country(s): '.implode(', ', $array[0]->country)."<br /> \r\n";
        $test->country = $array[0]->country;
    }

    if(isset($array[0]->actors)){
        //echo 'Actors: '.implode(', ', $array[0]->actors)."<br /> \r\n";
        $test->actors = $array[0]->actors;
    }

    if(isset($array[0]->directors)){
        //echo 'Director(s): '.implode(', ', $array[0]->directors)."<br /> \r\n";
        $test->directors = $array[0]->directors;
    }

    if(isset($array[0]->writers)){
        //echo 'Writer(s): '.implode(', ', $array[0]->writers)."<br /> \r\n";
        $test->writers = $array[0]->writers;
    }

    if(isset($array[0]->filming_locations)){
        //echo 'Filming Location(s): '.$array[0]->filming_locations."<br /> \r\n"; //This is output as a string for some reason
        $test->filming_locations = $array[0]->filming_locations;
    }

    if(isset($array[0]->imdb_id)){
        echo 'IMDb id: '.$array[0]->imdb_id."<br /> \r\n";
    }
}



