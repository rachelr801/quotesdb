<?php

require_once "../config/Database.php";
require_once "../models/Quote.php";

$db = (new Database())->connect();
$data = json_decode(file_get_contents("php://input"));

// Validate input
if (
    !isset($data->quote) || trim($data->quote) === "" ||
    !isset($data->author_id) ||
    !isset($data->category_id)
) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

// Validate author exists
$checkAuthor = $db->prepare("SELECT id FROM authors WHERE id = :id");
$checkAuthor->bindParam(':id', $data->author_id);
$checkAuthor->execute();

if ($checkAuthor->rowCount() === 0) {
    echo json_encode(["message" => "author_id Not Found"]);
    exit();
}

// Validate category exists
$checkCategory = $db->prepare("SELECT id FROM categories WHERE id = :id");
$checkCategory->bindParam(':id', $data->category_id);
$checkCategory->execute();

if ($checkCategory->rowCount() === 0) {
    echo json_encode(["message" => "category_id Not Found"]);
    exit();
}

// Create quote
$quote = new Quote($db);

$quote->quote = trim($data->quote);
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

$id = $quote->create();

if ($id) {
    echo json_encode([
        "id" => $id,
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
} else {
    echo json_encode(["message" => "Quote not created"]);
}

exit();
