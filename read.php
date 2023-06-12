<?php

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database
include_once 'mongodb_config.php';

$dbname = 'vdbname';
$collection = 'users';


//connessione al DB
$db = new DbManager();
$conn = $db->getConnection();

// legge tutti i records
$filter = [];
$option = [];
$read = new MongoDB\Driver\Query($filter, $option);

//fetch records
$records = $conn->executeQuery("$dbname.$collection", $read);

echo json_encode(iterator_to_array($records));

?>