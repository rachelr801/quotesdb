<?php

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->id) || !isset($data->author)){
    echo json_encode(['message' => 'Missing Required Parameters']);
    return;
}

$author->id = $data->id;
$author->author = $data->author;

if($author->update() > 0){
    echo json_encode([
        "id" => $author->id,
        "author" => $author->author
    ]);
} else {
    echo json_encode(['message' => 'author_id Not Found']);
}
