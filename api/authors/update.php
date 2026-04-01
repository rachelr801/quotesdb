<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Author.php';

$db = (new Database())->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->author)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$author->id = $data->id;
$author->author = $data->author;

$result = $author->update();

if ($result > 0) {
    echo json_encode([
        "id" => $author->id,
        "author" => $author->author
    ]);
} else {
    echo json_encode(['message' => 'author_id Not Found']);
}