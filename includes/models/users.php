<?php
/**
 * Name:        User Abstraction Layer
 * Description: Creates an abstraction between the database and user data
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}
require_once(ABSPATH.'includes/controllers/data.php');

class users {

    //Define variables

        //User data
            public $index       = null;
            public $firstname   = '';
            public $lastname    = '';
            public $username    = '';
            public $password    = '';
            public $login_count = '0';
            public $last_ip     = '0.0.0.0';
            public $admin       = false;

        //Control variables
            public $debug       = true;

    //Login function
    public function login(){

        /**
         * This Function logs a user in.
         */

        //Setup databasea connection
        $dbc = new db;
        $dbc->connect();

        //sanitize inputs
        $this->username = $dbc->sanitize($this->username);
        $this->password = hash('SHA512', $this->password);

        //look for user in database
        $query = "SELECT * FROM users WHERE `username` = '".$this->username."' AND `password` = '".$this->password."'";
        $results = $dbc->query($query);

        //Count row returned
        if(count($results) == '1' && isset($results[0]['index'])){

            //Good login, define user data
            $this->index       = $results[0]['index'];
            $this->firstname   = $results[0]['firstname'];
            $this->lastname    = $results[0]['lastname'];
            $this->username    = $results[0]['username'];
            $this->password    = $results[0]['password'];
            $this->login_count = $results[0]['login_count'];
            $this->last_ip     = $results[0]['last_ip'];
            $this->admin       = $results[0]['admin'];

            return true;

        }else{

            //Bad login, return false
            return false;

        }



    }

    //Update function
    public function update(){

        /**
         * This function updates and existing user.
         */

    }

    //Delete function
    public function delete(){

        /**
         * This function deletes a user.
         */

    }

    //Create function
    public function create(){

        /**
         * This Function creates a new user.
         */

    }

}