<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

include_once '../config/Database.php';
include_once '../models/Author.php';

$db = (new Database())->connect();
$author = new Author($db);

// check if exists
$check = $db->prepare("SELECT id FROM authors WHERE id=?");
$check->execute([$data->id]);

if ($check->rowCount() == 0) {
    echo json_encode(["message" => "author_id Not Found"]);
    exit();
}

$author->id = $data->id;

// delete
if ($author->delete()) {
    echo json_encode([
        "id" => $data->id
    ]);
} else {
    echo json_encode([
        "message" => "Failed to delete author"
    ]);
}