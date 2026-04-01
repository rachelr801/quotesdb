<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');
    exit();
}

require_once '../config/Database.php';
require_once '../models/Quote.php';

$db = (new Database())->connect();

// ✅ THIS MUST EXIST BEFORE ANY REQUIRE
$quote = new Quote($db);

if ($method === 'GET') {
    require 'read.php';
} elseif ($method === 'POST') {
    require 'create.php';
} elseif ($method === 'PUT') {
    require 'update.php';
} elseif ($method === 'DELETE') {
    require 'delete.php';
}