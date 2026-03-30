<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->author) || trim($data->author) === "") {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

include_once '../config/Database.php';
include_once '../models/Author.php';

$db = (new Database())->connect();
$author = new Author($db);

$author->author = $data->author;

if ($author->create()) {
    echo json_encode([
        "id" => $author->id,
        "author" => $author->author
    ]);
} else {
    echo json_encode([
        "message" => "Failed to create author"
    ]);
}