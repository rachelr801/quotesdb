<?php
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Quote.php';

$db = new Database();
$conn = $db->connect();

$quote = new Quote($conn);

$result = $quote->read();

$num = $result->rowCount();

if ($num > 0) {

    $arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $arr[] = [
            "id" => $row['id'],
            "quote" => $row['quote'],
            "author" => $row['author'],
            "category" => $row['category']
        ];
    }

    echo json_encode($arr);

} else {
    echo json_encode(["message" => "No Quotes Found"]);
}