<?php
require_once "../config/Database.php";
require_once "../models/Quote.php";

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->category = $data->category;

$id = $category->create();

if ($id) {
    echo json_encode([
        "id" => $id,
        "category" => $category->category
    ]);
}

if(isset($category->category)) {
    if($category->create()) {
        echo json_encode(
            array('id' => $db->lastInsertId(), 'category' => $category->category));
    } else {
        echo json_encode(
            array("message" => "Category Not Created"));
    }
} else {
    echo json_encode(
        array("message" => "Missing Required Parameters"));
    }
    
exit();