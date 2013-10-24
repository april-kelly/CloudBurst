<?php
/**
 * Name:        data.php
 * Description: A simple database abstraction layer.
 * Date:        10/24/13
 * Programmer:  Liam Kelly
 */

//Includes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

//The db class
class db {

    //Variables

        //Database login:
        public $db_host = '';
        public $db_user = '';
        public $db_pass = '';
        public $db_database = '';

        //mysqli object
        public $dbc;

    //Connect function
    public function connect(){

        //Connect
        $this->dbc = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_database)
            or die("Could not connect!");

    }

    //Query function
    public function query($db_query){

        $result = $this->dbc->query($db_query);	//query the database


        if(is_object($result)){

            while($row = $result->fetch_assoc()) {	//fetch assoc array
                $array[] = $row;
            }

        }else{
            return false;
        }

        if(!(empty($array))){
            return $array;	//return results
        }

        return false;

    }

    //Insert function
    public function insert($db_query){

        if(is_object($this->dbc)){

            $this->dbc->query($db_query);	//query the database

        }

    }

    //Sanitize function
    public function sanitize($input){

        return $this->dbc->real_escape_string($input);

    }

    //Close function
    public function close(){

        //Make sure a connection exists
        if(is_object($this->dbc)){

            //Close the connection
            if($this->dbc->close())
            {

                return true;	//connection closed

            }
            else
            {

                return false;	//connection not closed

            }

        }else{

            return false; //no connection existed

        }

    }

}

