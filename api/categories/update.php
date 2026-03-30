<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->category) || trim($data->category) === "") {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

include_once '../config/Database.php';
include_once '../models/Category.php';

$db = (new Database())->connect();
$category = new Category($db);

// check if exists
$check = $db->prepare("SELECT id FROM categories WHERE id=?");
$check->execute([$data->id]);

if ($check->rowCount() == 0) {
    echo json_encode(["message" => "category_id Not Found"]);
    exit();
}

$category->id = $data->id;
$category->category = $data->category;

if ($category->update()) {
    echo json_encode([
        "id" => $category->id,
        "category" => $category->category
    ]);
} else {
    echo json_encode([
        "message" => "Failed to update category"
    ]);
}