<?php

require_once "../config/Database.php";
require_once "../models/Quote.php";

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$result = $quote->read();

$num = $result->rowCount();

if($num > 0) {
    $quote_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author_name,
            'category' => $category_name
        );

        array_push($quote_arr, $quote_item);
    }

    print_r(json_encode($quote_arr));
} else {
    echo json_encode(
        array('message' => 'No Quotes Found'));
}

exit();