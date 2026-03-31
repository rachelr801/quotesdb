<?php

require_once "../config/Database.php";
require_once "../models/Quote.php";

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

// Validate first
if (
    !isset($data->id) ||
    !isset($data->quote) ||
    !isset($data->author_id) ||
    !isset($data->category_id)
) {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
    exit();
}

// Assign values (consistent naming!)
$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// Update
if ($quote->update()) {
    echo json_encode([
        "id" => $quote->id,
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
} else {
    echo json_encode([
        "message" => "Quote Not Updated"
    ]);
}

exit();