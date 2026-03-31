<?php

require_once "../config/Database.php";
require_once "../models/Category.php";

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

// ✅ Validate BEFORE assignment
if (!isset($data->id) || !isset($data->category) || empty($data->category)) {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
    exit();
}

$category->id = $data->id;
$category->category = $data->category;

// Update
if ($category->update()) {
    echo json_encode([
        "id" => $category->id,
        "category" => $category->category
    ]);
} else {
    echo json_encode([
        "message" => "Category Not Updated"
    ]);
}

exit();