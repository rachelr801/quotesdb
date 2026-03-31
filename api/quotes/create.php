<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

$quote->quote = $data->quote;
$quote->authorId = $data->authorId;
$quote->categoryId = $data->categoryId;

if(isset($quote->quote) && isset($quote->authorId) && isset($quote->categoryId)) {
    if($quote->create()) {
        echo json_encode(
            array(
                'id' => $db->lastInsertId(),
                'quote' => $quote->quote,
                'authorId' => $quote->authorId,
                'categoryId' => $quote->categoryId)
            );
    } else {
        echo json_encode(
            array("message" => "Quote Not Created"));
    }
} else {
    echo json_encode(
        array("message" => "Missing Required Parameters"));
    }

exit();