<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Category.php';

$db = (new Database())->connect();

$category = new Category($db);

if (isset($_GET['id'])) {

    $category->id = $_GET['id'];
    $stmt = $category->read_single();

    if ($stmt && $stmt->rowCount() > 0) {
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo json_encode(['message' => 'category_id Not Found']);
    }

} else {

    $stmt = $category->read();

    if ($stmt && $stmt->rowCount() > 0) {
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } else {
        echo json_encode(['message' => 'category_id Not Found']);
    }
}