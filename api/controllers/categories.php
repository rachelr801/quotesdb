<?php
header("Content-Type: application/json");

include_once '.../config/Database.php';
include_once '.../models/Category.php';

$db = (new Database())->connect();
$model = new Category($db);

$method = $_SERVER['REQUEST_METHOD'];

if($method === 'GET'){
    $stmt = isset($_GET['id']) ? $model->read($_GET['id']) : $model->read();

    if($stmt->rowCount() > 0) {
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } else {
        echo json_encode(["message" => "category_id Not Found"]);
    }
}

if($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->category)) {
        echo json_encode(["message" = "Missing Required Parameters"]);
        exit;
    }

    $id = $model->create($data);
    echo json_encode(["id" => $id, "category" => $data->category]);
}

if($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->id, $data->category)) {
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit;
    }

    $updated = $model->update($data);

    echo $updated ? json_encode($data)
                  : json_encode(["message" => "category_id Not Found"]);
}

if($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->id)) {
        echo json_encode(["message" => "Missing Required Parameter"]);
        exit;
    }

    $deleted = $model->delete($data->id);

    echo $deleted ? json_encode(["id" => $data->id])
              : json_encode(["message" => "category_id Not Found"]);
}