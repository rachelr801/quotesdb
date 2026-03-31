<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Category.php";

$db = (new Database())->connect();
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->category)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$category = new Category($db);
$category->category = $data->category;

if ($category->create()) {
    echo json_encode([
        "id" => $db->lastInsertId(),
        "category" => $category->category
    ]);
}