<?php

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->id)){
    echo json_encode(['message' => 'Missing Required Parameters']);
    return;
}

$category->id = $data->id;

if($category->delete() > 0){
    echo json_encode(['id' => $category->id]);
} else {
    echo json_encode(['message' => 'category_id Not Found']);
}