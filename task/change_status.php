<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

include_once '../objects/task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->status) && !empty($data->task_id)) {
    if(!$task->checkStatus($data->status)) {
        // set response code - 400 bad request
        http_response_code(400);
        echo json_encode(array("message" => "Invalid status."));die;
    }
    $task->id = (int)$data->task_id;
    $task->status = $data->status;
    if($task->changeStatus()){
        // set response code - 201 created
        http_response_code(200);
        echo json_encode(array("message" => "Task status been successfully updated."));
    } else {
        // set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Failed to change task status."));
    }
} else {
    /// set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create task. The data is missing."));
}