<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Quote.php';

$db = (new Database())->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !isset($data->id) ||
    !isset($data->quote) ||
    !isset($data->author_id) ||
    !isset($data->category_id)
){
    echo json_encode(['message' => 'Missing Required Parameters']);
    return;
}

$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

$result = $quote->update();

if($result > 0){
    echo json_encode([
        "id" => $quote->id,
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
} else {
    echo json_encode(['message' => 'No Quotes Found']);
}