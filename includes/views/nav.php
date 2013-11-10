<?php

//Navigation bar

//Session
if(!(isset($_SESSION))){
    session_start();
}

//Check for user login
if(isset($_SESSION['user_id'])){

    //User is logged in
    $name = $_SESSION['firstname'];

}else{

    //User is not logged in, send to login
    header('location: ./?p=login');
    $name = '';


}

?>

    <ul>
        <li><a href="?p=tv">TV</a></li>
        <li><a href="?p=movies">Movies</a></li>
        <li><a href="?p=music">Music</a></li>
        <li><a href="?p=photos">Photos</a></li>
        <li><a href="?p=settings">Settings</a></li>
        <li><a href="?p=logout">Hi, <?php echo $name;?></a></li>
    </ul>

