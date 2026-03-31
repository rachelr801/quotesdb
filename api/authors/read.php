<?php

if(isset($_GET['id'])) {
    $author->id = $_GET['id'];
    $stmt = $author->read_single();

    if($stmt->rowCount() > 0){
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo json_encode(['message' => 'author_id Not Found']);
    }

} else {
    $stmt = $author->read();

    if($stmt->rowCount() > 0){
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } else {
        echo json_encode(['message' => 'author_id Not Found']);
    }
}