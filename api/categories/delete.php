<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Category.php';

$db = (new Database())->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$category->id = $data->id;

$result = $category->delete();

if ($result > 0) {
    echo json_encode(['id' => $category->id]);
} else {
    echo json_encode(['message' => 'category_id Not Found']);
}