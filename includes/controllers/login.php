<?php
/**
 * Name:        Login system
 * Description: Logs users in.
 * Date:        10/26/13
 * Programmer:  Liam Kelly
 */

//includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}
require_once(ABSPATH.'/includes/controllers/get_ip.php');
require_once(ABSPATH.'/includes/models/users.php');

//Start session
if(!(isset($_SESSION))){
    session_start();
}else{
    session_destroy();
    session_start();
}

//Setup users object
$users = new users;

//Determine if the user is trying to login
if(isset($_REQUEST['username'])){

    //User is attempting to login
    $users->username = $_REQUEST['username'];
    $users->password = $_REQUEST['password'];
    $login = $users->login();

    //Determine if the login was a success
    if($login == true){

        //Good login, setup session
        $_SESSION['user_id']     = $users->index;
        $_SESSION['firstname']   = $users->firstname;
        $_SESSION['lastname']    = $users->lastname;
        $_SESSION['username']    = $users->username;
        $_SESSION['password']    = $users->password;
        $_SESSION['login_count'] = $users->login_count;
        $_SESSION['last_ip']     = $users->last_ip;
        $_SESSION['admin']       = $users->admin;

        //Send the user to the home page
        header('location: ../../?p=home');

    }else{

        //Bad login, send the user back to the login form
        header('location: ../../?p=login&e=badlogin');

    }

}elseif(!(isset($_SESSION['user_id']))){

    //We are trying to verify a login

        //Determine if user is on lan
        $local = is_local();

        if($local == true){

            //User is local, we'll setup a session
            $_SESSION['user_id']     = '0';
            $_SESSION['firstname']   = 'Local';
            $_SESSION['lastname']    = '';
            $_SESSION['username']    = 'local';
            $_SESSION['password']    = '';
            $_SESSION['login_count'] = null;
            $_SESSION['last_ip']     = $_SERVER['REMOTE_ADDR'];
            $_SESSION['admin']       = '';

            //Send the user to the home page
            header('location: ../../?p=home');

        }else{

            //User is not local we'll send them to the login page
            header('location: ../../?p=login');

        }

}