<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Author.php';


$db = (new Database())->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$author->id = $data->id;

$result = $author->delete();

if ($result > 0) {
    echo json_encode(['id' => $data->id]);
} else {
    echo json_encode(['message' => 'author_id Not Found']);
}