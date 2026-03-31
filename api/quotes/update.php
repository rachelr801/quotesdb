<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Quote.php";

$db = (new Database())->connect();
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id, $data->quote, $data->author_id, $data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote = new Quote($db);

$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

if ($quote->update()) {
    echo json_encode([
        "id" => $quote->id,
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
}
