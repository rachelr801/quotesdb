<?php
header("Content-Type: application/json");

require_once '../config/Database.php';
require_once '../models/Quote.php';

$db = new Database();
$conn = $db->connect();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote = new Quote($conn);

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

if ($quote->create()) {
    echo json_encode([
        "id" => $conn->lastInsertId(),
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
} else {
    echo json_encode(["message" => "Quote not created"]);
}
