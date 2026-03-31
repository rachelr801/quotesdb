<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Category.php";

$db = (new Database())->connect();
$category = new Category($db);

$category->id = $_GET['id'];

$result = $category->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "id" => $row["id"],
        "category" => $row["category"]
    ]);
} else {
    echo json_encode(["message" => "category_id Not Found"]);
}