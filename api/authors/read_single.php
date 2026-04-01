<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Author.php';

$db = (new Database())->connect();

$author = new Author($db);

if (!isset($_GET['id'])) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$author->id = $_GET['id'];

$stmt = $author->read_single();

if ($stmt && $stmt->rowCount() > 0) {
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
} else {
    echo json_encode(['message' => 'author_id Not Found']);
}