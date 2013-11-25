<?php
/**
 * Name:        CloudBurst pdo based crud
 * Description: Handles requests for the database
 * Date:        11/16/13
 * Programmer:  Liam Kelly
 */

class db{

    public $db_name = 'CloudBurst';
    public $db_host = 'localhost';
    public $db_user = 'root';
    public $db_pass = 'kd0hdf';
    public $dbc = '';
    public $fail = false;
    public $prepared = false;

    public function __construct(){

        //Connect to the database
        $this->connect();

    }

    public function connect(){

        //Attempt to connect to the database
        try {
            $this->dbc = new PDO('mysql:host=localhost;dbname='.$this->db_name, $this->db_user, $this->db_pass);
            $this->dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            $this->fail = true;
        }

    }

    public function sanitize($data){

        //Make sure we have not failed
        if($this->fail == false){

            return $this->dbc->quote($data);

        }else{

            return false;

        }

    }

    public function query($query){

        //Make sure we have not failed
        if($this->fail == false){

            //Query the database
            $results =  $this->dbc->query($query);

            if(is_object($results)){

                while($row = $results->fetchALL()) {	//fetch assoc array
                    $array[] = $row;
                }

            }else{

                return false;

            }

            if(!(empty($array))){

                return $array;	//return results

            }else{

                return false;

            }

        }else{

            return false;

        }

    }

    public function execute($array){

        //Make sure a prepared statement has been defined
        if($this->prepared == true){

            //Make sure we have not failed
            if($this->fail == false){

                $results = $this->execute($array);

                if(is_object($results)){

                    while($row = $results->fetchALL()) {	//fetch assoc array
                        $array[] = $row;
                    }

                }else{

                    return false;

                }

                if(!(empty($array))){

                    return $array;	//return results

                }else{

                    return false;

                }

            }

        }

    }

    public function close(){

        //Make sure we have not failed
        if($this->fail == false){

            //Destroy the connection
            $this->dbc = null;

            //Return
            return true;

        }else{

            //We can't close so, return false
            return false;

        }

    }

    public function __destruct(){

        //Destroy the connection
        $this->close();

    }

}
