<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Author.php";

$db = (new Database())->connect();
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id, $data->author)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$author = new Author($db);
$author->id = $data->id;
$author->author = $data->author;

if ($author->update()) {
    echo json_encode([
        "id" => $author->id,
        "author" => $author->author
    ]);
}