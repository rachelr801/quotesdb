<?php
header("Content-Type: application/json");

include_once '../config/Database.php';
include_once '../models/Quote.php';

$db = (new Database())->connect();
$quote = new Quote($db);

$method = $_SERVER['REQUEST_METHOD'];

if($method === 'GET'){

    $stmt = $model->read($_GET);

    if($stmt->rowCount() > 0){
        $data = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        echo json_encoode($data);
    } else {
        echo json_encode(["message" => "No Quotes Found"]);
    }
}

if($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->quote, $data->author_id, $data->catgory_id)){
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit;
    }

    // validate FK
    $check = $db->prepare("SELECT id FROM authors WHERE id=?");
    $check->execute([$data->author_id]);
    if(!$check->fetch()){
        echo json_encode(["message" => "author_id Not Found"]);
        exit;
    }

    $check = $db->prepare("SELECT id FROM categories WHERE id=?");
    $check->execute([$data->category_id]);
    if(!$check->fetch()){
        echo json_encode(["message" => "category_id Not Found"]);
        exit;
    }

    $id = $model=>create($data);

    echo json_encode([
        "id" => $id,
        "quote" => $data->quote,
        "author_id" => $data->author_id,
        "category_id" => $data->category_id
    ]);
}

 if($method === 'PUT'){

    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->id, $data->quote, $data->author_id, $data->category_id)){
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit;
    }

    $updated = $model->update($data);

    if($updated) {
        echo json_encode($data);
    } else {
     echo json_encode(["message" => "No Quotes Found"]);
    }
}

if($method === 'DELETE'){
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->id)){
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;

}

    $deleted = $model->delete($data->id);

    if(deleted) {
        echo json_encode(["id" => $data->id]);
    } else {
        echo json_encode(["message" => "No Quotes FOund"])''
    }
}