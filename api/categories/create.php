<?php

require_once "../config/Database.php";
require_once "../models/Category.php";

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

// ✅ Validate input first
if (!isset($data->category) || empty($data->category)) {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
    exit();
}

$category->category = $data->category;

// ✅ Create once
$id = $category->create();

if ($id) {
    echo json_encode([
        "id" => $id,
        "category" => $category->category
    ]);
} else {
    echo json_encode([
        "message" => "Category Not Created"
    ]);
}

exit();