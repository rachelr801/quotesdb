<?php
header("Content-Type: application/json");

include_once '../config/Database.php';
include_once '../models/Category.php';

$db = (new Database())->connect();
$category = new Category($db);

$id = isset($_GET['id']) ? $_GET['id'] : null;

$stmt = $category->read($id);

if ($stmt && $stmt->rowCount() > 0) {
    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode([
        "message" => "category_id Not Found"
    ]);
}