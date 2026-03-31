<?php

require_once "../config/Database.php";
require_once "../models/Author.php";

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

// VALIDATION
if (!isset($data->author)) {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
    exit();
}

// CREATE AUTHOR
$author = new Author($db);
$author->author = $data->author;

// PostgreSQL: create() must return id
$id = $author->create();

if ($id) {
    echo json_encode([
        "id" => $id,
        "author" => $author->author
    ]);
} else {
    echo json_encode([
        "message" => "Author Not Created"
    ]);
}

exit();