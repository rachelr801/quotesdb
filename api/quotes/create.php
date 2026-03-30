<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (
    !isset($data->quote) ||
    !isset($data->author_id) ||
    !isset($data->category_id) ||
    trim($data->quote) === ""
) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

include_once '../config/Database.php';
include_once '../models/Quote.php';

$db = (new Database())->connect();
$quote = new Quote($db);

// validate author
$authorCheck = $db->prepare("SELECT id FROM authors WHERE id=?");
$authorCheck->execute([$data->author_id]);

if ($authorCheck->rowCount() == 0) {
    echo json_encode(["message" => "author_id Not Found"]);
    exit();
}

// validate category
$categoryCheck = $db->prepare("SELECT id FROM categories WHERE id=?");
$categoryCheck->execute([$data->category_id]);

if ($categoryCheck->rowCount() == 0) {
    echo json_encode(["message" => "category_id Not Found"]);
    exit();
}

// assign values
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// create
if ($quote->create()) {
    echo json_encode([
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
} else {
    echo json_encode([
        "message" => "Failed to create quote"
    ]);
}