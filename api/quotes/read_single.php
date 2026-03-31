<?php
header('Content-Type: application/json');

require_once "../config/Database.php";
require_once "../models/Quote.php";

$db = (new Database())->connect();
$quote = new Quote($db);

$quote->id = $_GET['id'];

$result = $quote->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode($row);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}