<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    exit();
}

$id = $_GET['id'] ?? null;
$author_id = $_GET['author_id'] ?? null;
$category_id = $_GET['category_id'] ?? null;

// Routing
if ($method === "GET" && !empty($id)) {
    require_once("./read_single.php");
    exit();
}

if ($method === "GET") {
    require_once("./read.php");
    exit();
}

if ($method === "POST") {
    require_once("./create.php");
    exit();
}

if ($method === "PUT") {
    require_once("./update.php");
    exit();
}

if ($method === "DELETE") {
    require_once("./delete.php");
    exit();
}

// fallback
http_response_code(405);
echo json_encode([
    "message" => "Method Not Allowed",
    "method" => $method
]);
exit();