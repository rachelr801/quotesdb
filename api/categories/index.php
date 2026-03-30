<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    http_response_code(204);
    exit();
}

switch ($method) {

    case 'GET':
        if (
            isset($_GET['id']) ||
            isset($_GET['author_id']) ||
            isset($_GET['category_id'])
        ) {
            require 'read_single.php';
        } else {
            require 'read.php';
        }
        break;

    case 'POST':
        require 'create.php';
        break;

    case 'PUT':
        require 'update.php';
        break;

    case 'DELETE':
        require 'delete.php';
        break;

    default:
        http_response_code(400);
        echo json_encode(["message" => "Invalid Request"]);
        break;
}