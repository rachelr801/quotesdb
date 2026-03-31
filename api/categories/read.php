<?php

if(isset($_GET['id'])) {
    $category->id = $_GET['id'];
    $stmt = $category->read_single();

    if($stmt->rowCount() > 0){
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo json_encode(['message' => 'category_id Not Found']);
    }

} else {
    $stmt = $category->read();

    if($stmt->rowCount() > 0){
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } else {
        echo json_encode(['message' => 'category_id Not Found']);
    }
}