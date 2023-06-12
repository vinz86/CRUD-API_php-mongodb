<?php

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database
include_once 'mongodb_config.php';

$dbname = 'vdbname';
$collection = 'users';

//connessione al DB
$db = new DbManager();
$conn = $db->getConnection();

//record da aggiungere
$data = json_decode(file_get_contents("php://input", true));

// aggiunge record
$insert = new MongoDB\Driver\BulkWrite();
$insert->insert($data);

$result = $conn->executeBulkWrite("$dbname.$collection", $insert);

// verifica
if ($result->getInsertedCount() == 1) {
    echo json_encode(
		array("message" => "Record inserito con successo")
	);
} else {
    echo json_encode(
            array("message" => "Errore durante l'inserimento del record")
    );
}

?>