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
if(is_array($episode_list)){

    $i = 0;
    foreach($episode_list as $episode){
        //var_dump($episode);

        echo '<li>'.$episode[$i]['metadata'][0]['season'].'</li>';
        $i++;
    }


}
?>
</ul>
