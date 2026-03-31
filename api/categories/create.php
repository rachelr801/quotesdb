<?php

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->category)){
    echo json_encode(['message' => 'Missing Required Parameters']);
    return;
}

$category->category = $data->category;

$result = $category->create();

echo json_encode([
    "id" => $result['id'],
    "category" => $category->category
]);