<?php

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database
include_once 'mongodb_config.php';

$dbname = 'roytuts';
$collection = 'users';

// connessione al DB
$db = new DbManager();
$conn = $db->getConnection();

//record da aggiornare
$data = json_decode(file_get_contents("php://input", true));

$fields = $data->{'fields'};

$set_values = array();

foreach ($fields as $key => $fields) {
	$arr = (array)$fields;
	foreach ($fields as $key => $value) {
		$set_values[$key] = $value;
	}
}

//_id
$id = $data->{'where'};

// aggiorna record
$update = new MongoDB\Driver\BulkWrite();
$update->update(
	['_id' => new MongoDB\BSON\ObjectId($id)], ['$set' => $set_values], ['multi' => false, 'upsert' => false]
);

$result = $conn->executeBulkWrite("$dbname.$collection", $update);

// verifica
if ($result->getModifiedCount() == 1) {
    echo json_encode(
		array("message" => "Record aggiornato con successo")
	);
} else {
    echo json_encode(
            array("message" => "Errore durante l'aggiornamento del record")
    );
}

?>