<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

include_once '../config/Database.php';
include_once '../models/Quote.php';

$db = (new Database())->connect();
$quote = new Quote($db);

// check exists
$check = $db->prepare("SELECT id FROM quotes WHERE id=?");
$check->execute([$data->id]);

if ($check->rowCount() == 0) {
    echo json_encode(["message" => "quote_id Not Found"]);
    exit();
}

$quote->id = $data->id;

if ($quote->delete()) {
    echo json_encode([
        "id" => $data->id
    ]);
} else {
    echo json_encode([
        "message" => "Failed to delete quote"
    ]);
}
$quote->id = $data->id;

if ($quote->delete()) {
    echo json_encode(["id" => $data->id]);
}