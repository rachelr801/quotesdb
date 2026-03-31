<?php
require_once "../config/Database.php";
require_once "../models/Quote.php";

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$author->author = $data->author;

$id = $author->create();

if ($id) {
    echo json_encode([
        "id" => $id,
        "author" => $author->author
    ]);
}

if(isset($author->author)) {
    if($author->create()) {
        echo json_encode(
            array('id' => $db->lastInsertId(), 'author' => $author->author));
    } else {
        echo json_encode(
            array("message" => "Author Not Created"));
    }
} else {
    echo json_encode(
        array("message" => "Missing Required Parameters"));
    }
    
exit();