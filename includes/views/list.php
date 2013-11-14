<?php
/**
 * Name:        List.php
 * Description: Lists episodes in a tv show
 * Date:        11/11/13
 * Programmer:  Liam Kelly
 */

if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

require_once(ABSPATH.'includes/models/video.php');

$video = new video;
$results = $video->fetch_video($_SESSION['video_id']);
$episode_list = $video->fetch_episodes($results['metadata'][0]['imdb_id']);

?>
<b><?php echo $results['metadata'][0]['title']; ?></b>
<ul>
<?php


    foreach($episode_list['episodes'] as $episode){

        echo '<li>';
        echo '<a href="./?p=video&id='.$episode['metadata_id'].'">Play</a> ';
        echo $episode['metadata'][0]['season'].' ';
        echo $episode['metadata'][0]['episode'].' ';
        echo $episode['metadata'][0]['episode_name'].' ';
        echo '</li>';

    }

?>
</ul>
