<?php
header("Content-Type: application/json");

include_once '../config/Database.php';
include_once '../models/Quote.php';

$db = (new Database())->connect();
$quote = new Quote($db);

// GET filters
$id = isset($_GET['id']) ? $_GET['id'] : null;
$author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

$result = $quote->readSingle($id, $author_id, $category_id);

$num = $result->rowCount();

if ($num > 0) {
    $quotes_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quotes_arr[] = [
            "id" => $id,
            "quote" => $quote,
            "author_id" => $author_id,
            "category_id" => $category_id
        ];
    }

    echo json_encode($quotes_arr);
} else {
    echo json_encode([
        "message" => "No Quotes Found"
    ]);
}