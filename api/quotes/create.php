<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Quote.php';

$db = (new Database())->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)){
    echo json_encode(['message' => 'Missing Required Parameters']);
    return;
}

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

$result = $quote->create();

echo json_encode([
    "id" => $result['id'],
    "quote" => $quote->quote,
    "author_id" => $quote->author_id,
    "category_id" => $quote->category_id
]);