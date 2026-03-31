<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$author->id = $data->id;

$author->author = $data->author;

if(isset($author->id) && isset($author->author)){
    if($author->update()) {
        echo json_encode(
            array("id" => $author->id, "author" => $author->author));
    } else {
        echo json_encode(
            array("message" => "Author Not Updated"));
    }
} else {
    echo json_encode(
        array("message" => "Missing Required Parameters"));
    }
    
exit();