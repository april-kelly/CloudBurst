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

//Echo the results
if(isset($array[0])){
    if(isset($array[0]->poster->cover)){
        echo '<img src="'.$array[0]->poster->cover.'" /><br />';
    }

    if(isset($array[0]->title)){
        echo 'Title: '.$array[0]->title."<br /> \r\n";
    }

    if(isset($array[0]->plot_simple)){
        echo 'Plot: '.$array[0]->plot_simple."<br /> \r\n";
    }

    if(isset($array[0]->year)){
        echo 'Year: '.$array[0]->year."<br /> \r\n";
    }

    if(isset($array[0]->rated)){
        echo 'Rated: '.$array[0]->rated."<br /> \r\n";
    }

    if(isset($array[0]->rating)){
        echo 'Rating: '.$array[0]->rating."<br /> \r\n";
    }

    if(isset($array[0]->runtime)){
        echo 'Runtime(s): '.implode(', ', $array[0]->runtime)."<br /> \r\n";
    }

    if(isset($array[0]->genres)){
        echo 'Genre(s): '.implode(', ', $array[0]->genres)."<br /> \r\n";
    }

    if(isset($array[0]->language)){
        echo 'Language(s): '.implode(', ', $array[0]->language)."<br /> \r\n";
    }

    if(isset($array[0]->country)){
        echo 'Country(s): '.implode(', ', $array[0]->country)."<br /> \r\n";
    }

    if(isset($array[0]->actors)){
        echo 'Actors: '.implode(', ', $array[0]->actors)."<br /> \r\n";
    }

    if(isset($array[0]->directors)){
        echo 'Director(s): '.implode(', ', $array[0]->directors)."<br /> \r\n";
    }

    if(isset($array[0]->writers)){
        echo 'Writer(s): '.implode(', ', $array[0]->writers)."<br /> \r\n";
    }

    if(isset($array[0]->filming_locations)){
        echo 'Filming Location(s): '.$array[0]->filming_locations."<br /> \r\n"; //This is output as a string for some reason
    }

    if(isset($array[0]->also_known_as)){
        echo 'Also Known As: '.implode(', ', $array[0]->also_known_as)."<br /> \r\n";
    }

    if(isset($array[0]->imdb_id)){
        echo 'IMDb id: '.$array[0]->imdb_id."<br /> \r\n";
    }
}



