<?php

require_once "../config/Database.php";
require_once "../models/Quote.php";

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$result = $category->read();

$num = $result->rowCount();

if($num > 0) {
    $category_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $category_item = array(
            'id' => $id,
            'category' => $category
        );

        array_push($category_arr, $category_item);
    }

    print_r(json_encode($category_arr));
} else {
    echo json_encode(
        array('message' => 'categoryId Not Found'));
}

exit();