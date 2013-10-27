<?php
/**
 * Name:        IP Address Fetch System
 * Description: Fetches the users ip address to allow for limited local access without login
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

//Reports if client is on the lan
function is_local(){

    //Fetch the users ip address
    $ip = $_SERVER['REMOTE_ADDR'];

    //Local ip flag
    $local = false;

    //Debugging information (normally commented out)
    /*
    echo "Your ip address appears to be $ip <br /> \r\n";
    echo "You are in the ";
    */

    //Determine if ip is ipv4 or ipv6
    if(preg_match('/:/', $ip)){

        //Okay its, ipv6 check for local addresses

        //Since ipv6 does not have nat we will only look for ::1 or localhost
        if(preg_match('/::1/', $ip)){
            //echo '::1 block';
            $local = true;
        }


    }else{

        //Okay its, ipv4 check for local addresses

        //Parse the ip into an array
        $ip = explode('.', $ip);

        //Check for 192.168 block
            if($ip[0] == '192' && $ip[1] == '168'){
                //echo '192.168.x.x block';
                $local = true;
            }

        //Check for loopback
            if($ip[0] == '127'){
                //echo 'loopback block';
                $local = true;
            }

        //Check for 172.16 to 172.31 block
            if($ip[0] == '172' && $ip[1] >= '16' or  $ip[1] <= '31'){
                //echo '172.16.x.x to 172.31.x.x block';
                $local = true;
            }

        //Check for 10.x.x.x block
            if($ip[0] == '10'){
                //echo '10.x.x.x block';
                $local = true;
            }

    }

    //Debugging again (normally commented out)
    /*
    echo "<br />\r\n";
    if($local = true){
        echo "You are on the local area network.";
    }else{
        echo "You are <em>NOT</em> the local area network.";
    }
    */

    return $local;

}
