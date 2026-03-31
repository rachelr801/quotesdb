<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

$quote->read_single();

$quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author_name,
    'category' => $quote->category_name
);

if(isset($quote->id)) {
    print_r(json_encode($quote_arr));
    } else {
        echo json_encode(
            array("message" => "No Quotes Found"));
        }

exit();