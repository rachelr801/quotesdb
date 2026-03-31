<?php

require_once "../config/Database.php";
require_once "../models/Category.php";

$database = new Database();
$db = $database->connect();

$category = new Category($db);

// Validate input
if (!isset($_GET['id'])) {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
    exit();
}

$category->id = $_GET['id'];

// Run query
$result = $category->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

// Check result
if ($row) {
    echo json_encode([
        "id" => $row['id'],
        "category" => $row['category']
    ]);
} else {
    echo json_encode([
        "message" => "category_id Not Found"
    ]);
}

exit();