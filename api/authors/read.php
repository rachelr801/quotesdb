<?php
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../models/Author.php";

$db = (new Database())->connect();
$author = new Author($db);

$result = $author->read();

$data = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = [
        "id" => $row["id"],
        "author" => $row["author"]
    ];
}

echo json_encode($data);