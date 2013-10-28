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

//Determine if user is on the lan
$local = is_local();

//Attempt to log the user in if not on lan
if(!($local == true)){

    //User is NOT local

}else{

    //User IS local

    //Create local user


}
