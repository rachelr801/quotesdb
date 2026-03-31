<?php

require_once "../config/Database.php";
require_once "../models/Category.php";

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

// Validate input
if (!isset($data->id)) {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
    exit();
}

$category->id = $data->id;

// Delete
if ($category->delete()) {
    echo json_encode([
        "id" => $data->id . " deleted"
    ]);
} else {
    echo json_encode([
        "message" => $data->id . " not deleted"
    ]);
}

exit();