<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Author.php";

$db = (new Database())->connect();
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$author = new Author($db);
$author->id = $data->id;

if ($author->delete()) {
    echo json_encode(["id" => $data->id]);
} else {
    echo json_encode(["message" => "No Authors Found"]);
}