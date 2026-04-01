<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

include_once('../config/Database.php');
include_once('../models/Quote.php');

// ✅ CREATE DB + OBJECT HERE
$db = (new Database())->connect();
$quote = new Quote($db);

// ✅ THEN route
switch($method) {

    case 'GET':
        require 'read.php';
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
        echo json_encode(['message' => 'Invalid Request']);
}