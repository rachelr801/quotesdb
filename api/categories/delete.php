<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Category.php";

$db = (new Database())->connect();
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$category = new Category($db);
$category->id = $data->id;

if ($category->delete()) {
    echo json_encode(["id" => $data->id]);
} else {
    echo json_encode(["message" => "No Categories Found"]);
}