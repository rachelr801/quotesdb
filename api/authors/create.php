<?php

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->author)){
    echo json_encode(['message' => 'Missing Required Parameters']);
    return;
}

$author->author = $data->author;

$result = $author->create();

echo json_encode([
    "id" => $result['id'],
    "author" => $author->author
]);