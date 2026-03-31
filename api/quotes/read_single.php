<?php

if(!isset($_GET['id'])){
    echo json_encode(['message' => 'Missing Required Parameters']);
    return;
}

$where = "WHERE q.id = ?";
$params = [$_GET['id']];

$stmt = $quote->read($where, $params);

if($stmt->rowCount() > 0){
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
} else {
    echo json_encode(['message' => 'No Quotes Found']);
}