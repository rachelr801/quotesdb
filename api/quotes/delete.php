<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Quote.php";

$db = (new Database())->connect();
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote = new Quote($db);
$quote->id = $data->id;

if ($quote->delete()) {
    echo json_encode(["id" => $data->id]);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}