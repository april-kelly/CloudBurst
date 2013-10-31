<?php

if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

function read_meta($item){


$filename = ABSPATH.'content/uploads/'.$item;
// include getID3() library (can be in a different directory if full path is specified)
require_once(ABSPATH.'includes/libraries/getID3-1.9.7/getid3/getid3.php');

// Initialize getID3 engine
$getID3 = new getID3;

// Analyze file and store returned data in $ThisFileInfo
$ThisFileInfo = $getID3->analyze($filename);

/*
 Optional: copies data from all subarrays of [tags] into [comments] so
 metadata is all available in one location for all tag formats
 metainformation is always available under [tags] even if this is not called
*/
getid3_lib::CopyTagsToComments($ThisFileInfo);

/*
 Output desired information in whatever format you want
 Note: all entries in [comments] or [tags] are arrays of strings
 See structure.txt for information on what information is available where
 or check out the output of /demos/demo.browse.php for a particular file
 to see the full detail of what information is returned where in the array
 Note: all array keys may not always exist, you may want to check with isset()
 or empty() before deciding what to output
*/

$meta = array();

//Dump the results we get
/*
echo '<pre>';
    var_dump($ThisFileInfo);
echo '</pre>';
*/

    //Dump the video poster
    //$pic = $ThisFileInfo['comments']['picture'][0]['data'];
    //file_put_contents('test.jpg', $pic);


    //Type of video (tv show, movie, etc)
    if(isset($ThisFileInfo['tags']['quicktime']['stik'][0])){
        //echo "<br />\r\n".'Type:        '.$ThisFileInfo['tags']['quicktime']['stik'][0];
        $meta['type'] = $ThisFileInfo['tags']['quicktime']['stik'][0];
    }else{
        $meta['type'] = '';
    }


    //TV Show Name (name of the series)
    if(isset($ThisFileInfo['tags']['quicktime']['tv_show_name'][0])){
        //echo "<br />\r\n".'Name:        '.$ThisFileInfo['tags']['quicktime']['tv_show_name'][0];
        $meta['tv_show_name'] = $ThisFileInfo['tags']['quicktime']['tv_show_name'][0];
    }else{
        $meta['tv_show_name'] = '';
    }

    //TV Season (typically int)
    if(isset($ThisFileInfo['tags']['quicktime']['tv_season'][0])){
        //echo "<br />\r\n".'Season:      '.$ThisFileInfo['tags']['quicktime']['tv_season'][0];
        $meta['tv_season'] = $ThisFileInfo['tags']['quicktime']['tv_season'][0];
    }else{
        $meta['tv_season'] = '';
    }

    //TV Episode (typically int)
    if(isset($ThisFileInfo['tags']['quicktime']['tv_episode'][0])){
       //echo "<br />\r\n".'Episode:     '.$ThisFileInfo['tags']['quicktime']['tv_episode'][0];
       $meta['tv_episode'] = $ThisFileInfo['tags']['quicktime']['tv_episode'][0];
    }else{
        $meta['tv_episode'] = '';
    }

    //Description
    if(isset($ThisFileInfo['tags']['quicktime']['description'][0])){
        //echo "<br />\r\n".'Description: '.$ThisFileInfo['tags']['quicktime']['description'][0];
        $meta['description'] = $ThisFileInfo['tags']['quicktime']['description'][0];
    }else{
        $meta['description'] = '';
    }

    //TV Network Name
    if(isset($ThisFileInfo['tags']['quicktime']['tv_nework_name'][0])){
        //echo "<br />\r\n".'Network:     '.$ThisFileInfo['tags']['quicktime']['tv_network_name'][0];
        $meta['tv_network_name'] = $ThisFileInfo['tags']['quicktime']['tv_network_name'][0];
    }else{
        $meta['tv_network_name'] = '';
    }

    //echo "<br />\r\n".'Location:    '.$filename;

    $name = pathinfo($filename);
    //echo "<br />\r\n".'<a href="../video.php?src='.$name['filename'].'&title='.$name['filename'].'">';
    //echo $name['filename'];
    //echo 'Play';
    //echo '</a>'."</br>\r\n";

    return $meta;
}