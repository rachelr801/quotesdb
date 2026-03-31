<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

$quote->id = $data->id;

$quote->quote = $data->quote;
$quote->authorId = $data->authorId;
$quote->categoryId = $data->categoryId;

if(isset($quote->id) && isset($quote->quote) && isset($quote->authorId) && isset($quote->categoryId)) {
    if($quote->update()) {
        echo json_encode(
            array("id" => $quote->id, "quote" => $quote->quote, "authorId" => $quote->authorId, "categoryId" => $quote->categoryId));
    } else {
        echo json_encode(
            array("message" => "No Quotes Found"));
    }
} else {
    echo json_encode(
        array("message" => "Missing Required Parameters"));
    }

exit();