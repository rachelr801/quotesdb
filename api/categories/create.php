<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Category.php';

$db = (new Database())->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->category)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$category->category = $data->category;

$result = $category->create();

echo json_encode([
    "id" => $result['id'],
    "category" => $category->category
]);