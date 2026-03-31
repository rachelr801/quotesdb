<?php

require_once "../config/Database.php";
require_once "../models/Author.php";

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$result = $author->read();

$num = $result->rowCount();

if ($num > 0) {

    $author_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $author_arr[] = [
            "id" => $row['id'],
            "author" => $row['author']
        ];
    }

    echo json_encode($author_arr);

} else {

    echo json_encode([
        "message" => "author_id Not Found"
    ]);
}

exit();