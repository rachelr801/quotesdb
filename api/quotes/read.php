<?php

$where = "";
$params = [];

if(isset($_GET['id'])) {
    $where = "WHERE q.id = ?";
    $params = [$_GET['id']];
}
elseif(isset($_GET['author_id']) && isset($_GET['category_id'])) {
    $where = "WHERE q.author_id = ? AND q.category_id = ?";
    $params = [$_GET['author_id'], $_GET['category_id']];
}
elseif(isset($_GET['author_id'])) {
    $where = "WHERE q.author_id = ?";
    $params = [$_GET['author_id']];
}
elseif(isset($_GET['category_id'])) {
    $where = "WHERE q.category_id = ?";
    $params = [$_GET['category_id']];
}

$stmt = $quote->read($where, $params);

if($stmt->rowCount() > 0) {
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode(['message' => 'No Quotes Found']);
}