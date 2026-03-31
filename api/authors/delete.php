<?php

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->id)){
    echo json_encode(['message' => 'Missing Required Parameters']);
    return;
}

$author->id = $data->id;

if($author->delete() > 0){
    echo json_encode(['id' => $author->id]);
} else {
    echo json_encode(['message' => 'author_id Not Found']);
}