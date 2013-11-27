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
    public $results = '';
    public $fail = false;
    public $prepared = false;
    public $errors = '';

    public function __construct(){

        //Connect to the database
        $this->connect();

    }

    public function connect(){

        //Attempt to connect to the database
        try {

            $this->dbc = new PDO('mysql:host=localhost;dbname='.$this->db_name, $this->db_user, $this->db_pass);
            $this->dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){

            $this->errors = $this->errors."\r\n".$e->getMessage();
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

    public function insert($query){

        /**
         * Name:        insert
         * Description: for compatibility with data.php (will be deprecated)
         */

        $this->query($query);

    }

    public function query($query){

        //Make sure we have not failed
        if($this->fail == false){

            //Attempt to query the database
            try{

                $this->results =  $this->dbc->query($query);

            }catch(PDOException $e){

                $this->errors = $this->errors.$e->getMessage();
                $this->fail = true;

            }

            if($this->fail == false){

                if(is_object($this->results)){

                    while($row = $this->results->fetchALL()) {	//fetch assoc array
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

        }else{

            return false;

        }

    }

    public function execute($handle, $array){

        //Make sure a prepared statement has been defined
        if($this->prepared == true){

            //Make sure we have not failed
            if($this->fail == false){

                //Attempt to execute
                try{

                    $handle->execute($array);

                }catch(PDOException $e){

                    $this->errors = $this->errors.$e->getMessage();
                    $this->fail = true;

                }

                //Check for failure
                if($this->fail == false){

                    if(is_object($handle)){

                        while($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                            $array[] = $row;
                        }


                        return $array;	//return results

                    }else{

                        return false;

                    }

                }else{

                    return false;

                }

            }else{

                return false;

            }

        }else{

            return false;

        }

    }

    //Prepared statements
    public function prepare_media(){

        //Make sure we have not failed
        if($this->fail == false){

            //Prepare the query
            $handle = $this->dbc->prepare('SELECT * FROM `cloudburst`.`media` WHERE `index` = :id');

            //Let the excute function know that we have defined a query
            $this->prepared = true;

            //Return the handle
            return $handle;

        }else{

            //We failed earlier so return false
            return false;

        }

    }

    public function prepare($query){

        //Make sure we have not failed
        if($this->fail == false){

            //Prepare the query
            $handle = $this->dbc->prepare($query);

            //Let the excute function know that we have defined a query
            $this->prepared = true;

            //Return the handle
            return $handle;

        }else{

            //We failed earlier so return false
            return false;

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

    public function get_errors(){

        /**
         * Name:         get_errors
         * Description:  Echos out any error messages saved in $this->errors
         */

        //Check for errors
        if(!(empty($this->errors))){

            //Spit out any error messages
            echo "<br />".$this->errors."<br />";

        }

    }

    public function __destruct(){

        /**
         * Name:        __destruct
         * Description: Closes the database connection on destruct.
         */

        //Destroy the database connection
        $this->close();

    }

}
