<?php

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->id)){
    echo json_encode(['message'=>'Missing Required Parameters']);
    return;
}

$quote->id = $data->id;

if($quote->delete() > 0){
    echo json_encode(['id'=>$quote->id]);
} else {
    echo json_encode(['message'=>'No Quotes Found']);
}