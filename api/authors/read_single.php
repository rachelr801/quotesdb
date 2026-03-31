<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Author.php";

$db = (new Database())->connect();
$author = new Author($db);

$author->id = $_GET['id'];

$result = $author->read_single();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "id" => $row["id"],
        "author" => $row["author"]
    ]);
} else {
    echo json_encode(["message" => "author_id Not Found"]);
}