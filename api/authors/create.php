<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Author.php';

$db = (new Database())->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->author)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$author->author = $data->author;

$result = $author->create();

echo json_encode([
    "id" => $result['id'],
    "author" => $author->author
]);