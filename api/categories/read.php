<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Category.php";

$db = (new Database())->connect();
$category = new Category($db);

$result = $category->read();

$data = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = [
        "id" => $row["id"],
        "category" => $row["category"]
    ];
}

echo json_encode($data);