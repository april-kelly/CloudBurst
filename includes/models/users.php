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
        $query = 'SELECT * FROM users WHERE username = `'.$this->username.'` AND password = `'.$this->password.'`';
        $results = $dbc->query($query);

        //Count row returned
        if(count($results) == '1'){

            //Good login, define user data
            $this->index       = $results['index'];
            $this->firstname   = $results['firstname'];
            $this->lastname    = $results['lastname'];
            $this->username    = $results['username'];
            $this->password    = $results['password'];
            $this->login_count = $results['login_count'];
            $this->last_ip     = $results['last_ip'];
            $this->admin       = $results['admin'];

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