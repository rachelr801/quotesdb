<?php
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// validate id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$params = ['id' => $_GET['id']];

$stmt = $quote->read($params);

if ($stmt && $stmt->rowCount() > 0) {
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
} else {
    echo json_encode(["message" => "quote_id Not Found"]);
}