<?php
/**
 * Name:        Media table
 * Description: Defines what the media table should look like.
 * Date:        11/26/13
 * Programmer:  Liam Kelly
 */

//Includes
if(!(defined('ABSPATH'))){
    require_once('../../../path.php');
}
require_once(ABSPATH.'/includes/models/pdo.php');

class media {

    //Define table columns
    public $media_id;
    public $filename;
    public $server_adderess;
    public $resolution;

    //Control variables
    public $dbc;

    //Define what an lookup looks like
    function lookup($media_id){

        //Determine if we already have a connection to the database
        if(!(is_object($this->dbc))){

            //No connection exists, create one
            $this->dbc = new db;

        }

        //Prepare the query
        $query = 'SELECT * FROM `cloudburst2`.`media` WHERE `media_id` = :id';
        $handle = $this->dbc->prepare($query);

        //Execute the query
        $parameters = array('id' => $media_id);
        $status = $handle->execute($parameters);

        //Get the results and return
        if($status == true){

            while($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }

            //Make sure we have something to return
            if(isset($array)){

                //Great, return the results
                return $array;

            }else{

                return false;

            }

        }else{

            return false;

        }


    }

    //Define what a insert looks like
    public function insert(){

        //Determine if we already have a connection to the database
        if(!(is_object($this->dbc))){

            //No connection exists, create one
            $this->dbc = new db;

        }

        //Prepare the query
        $query = 'INSERT INTO media (`media_id`, `filename`, `server_adderess`, `resolution`) VALUES (:media_id, :filename, :server_adderess, :resolution)';
        $handle = $this->dbc->prepare($query);

        //Execute the query
        $parameters = array('index'    => $this->media_id,
                            'filename' => $this->filename,
                            'server_address' => $this->server_adderess;
    );
        $status = $handle->execute($parameters);

        //Get the results and return
        if($status == true){

            while($row = $handle->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }

            //Make sure we have something to return
            if(isset($array)){

                //Great, return the results
                return $array;

            }else{

                return false;

            }

        }else{

            return false;

        }

    }

    //Define what an update looks like

    //Define what a delete looks like


}