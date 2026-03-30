<?php
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// safely handle filters
$params = $_GET ?? [];

// get results
$stmt = $quote->read($params);

if ($stmt && $stmt->rowCount() > 0) {

    $quotes_arr = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $quotes_arr[] = $row;
    }

    echo json_encode($quotes_arr);

} else {
    echo json_encode([
        "message" => "quotes Not Found"
    ]);
}