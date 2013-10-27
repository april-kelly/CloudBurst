<?php

$list = scandir('./videos/');

//Get rid of the . and ..
unset($list[0]);
unset($list[1]);

//List out all of the files
foreach($list as $item){
    $test = pathinfo($item);
    echo '<a href="video.php?src='.$test['filename'].'&title='.$test['filename'].'">';
    echo $test['filename'];
    echo '</a>'."</br>\r\n";
}