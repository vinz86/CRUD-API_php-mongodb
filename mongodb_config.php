<?php

class DbManager {

	//Configurazione
	private $dbhost = 'localhost';
	private $dbport = '27017';
	private $conn;
	
	function __construct(){
        //Connessione a MongoDB
        try {
			//Stabilisce la connessione al db
            $this->conn = new MongoDB\Driver\Manager('mongodb://'.$this->dbhost.':'.$this->dbport);
        }catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
			echo nl2br("n");
        }
    }

	function getConnection() {
		return $this->conn;
	}

}

?>