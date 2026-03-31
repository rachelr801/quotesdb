<?php

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->id) || !isset($data->category)){
    echo json_encode(['message' => 'Missing Required Parameters']);
    return;
}

$category->id = $data->id;
$category->category = $data->category;

if($category->update() > 0){
    echo json_encode([
        "id" => $category->id,
        "category" => $category->category
    ]);
} else {
    echo json_encode(['message' => 'category_id Not Found']);
}