<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Category.php';

$db = (new Database())->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->category)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$category->id = $data->id;
$category->category = $data->category;

$result = $category->update();

if ($result > 0) {
    echo json_encode([
        "id" => $category->id,
        "category" => $category->category
    ]);
} else {
    echo json_encode(['message' => 'category_id Not Found']);
}