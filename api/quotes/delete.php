<?php

require_once "../config/Database.php";
require_once "../models/Quote.php";

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

// Validate input
if (!isset($data->id)) {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
    exit();
}

$quote->id = $data->id;

// Delete
if ($quote->delete()) {
    echo json_encode([
        "id" => $data->id,
        "message" => "Quote deleted"
    ]);
} else {
    echo json_encode([
        "message" => "Quote not deleted"
    ]);
}

exit();