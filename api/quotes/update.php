<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (
    !isset($data->id) ||
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

// check quote exists
$check = $db->prepare("SELECT id FROM quotes WHERE id=?");
$check->execute([$data->id]);

if ($check->rowCount() == 0) {
    echo json_encode(["message" => "quote_id Not Found"]);
    exit();
}

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
$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// update
if ($quote->update()) {
    echo json_encode([
        "id" => $quote->id,
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
} else {
    echo json_encode([
        "message" => "Failed to update quote"
    ]);
}