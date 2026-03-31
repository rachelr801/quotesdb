<?php

require_once "../config/Database.php";
require_once "../models/Author.php";

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

// VALIDATION
if (!isset($data->id)) {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
    exit();
}

$author = new Author($db);
$author->id = $data->id;

//  DELETE
if ($author->delete()) {
    echo json_encode([
        "id" => $data->id
    ]);
} else {
    echo json_encode([
        "message" => "No Authors Found"
    ]);
}

exit();