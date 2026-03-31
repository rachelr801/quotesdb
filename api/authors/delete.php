<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$author->id = $data->id;

if($author->delete()) {
    echo json_encode(
        array("id" => "{$data->id} deleted"));
} else {
    echo json_encode(
        array("message" => "{$data->id} not deleted"));
}

exit();