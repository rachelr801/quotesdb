<?php

require_once "../config/Database.php";
require_once "../models/Quote.php";

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die();

$category->read_single();

$category_arr = array(
    'id' => $category->id,
    'category' => $category->category
);

if(isset($category->id)) {
    print_r(json_encode($category_arr));
    } else {
        echo json_encode(
            array("message" => "categoryId Not Found"));
        }

exit();