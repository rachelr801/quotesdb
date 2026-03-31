<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Category.php";

$db = (new Database())->connect();
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id, $data->category)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$category = new Category($db);
$category->id = $data->id;
$category->category = $data->category;

if ($category->update()) {
    echo json_encode([
        "id" => $category->id,
        "category" => $category->category
    ]);
}