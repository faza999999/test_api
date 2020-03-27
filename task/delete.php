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
$data = json_decode(file_get_contents("php://input"));
if(!$data->task_id) {
    echo json_encode(array("message" => "Missing task id."));die;
}

$task = new Task($db);
$task->id = (int)$data->task_id;
if($task->delete()){
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode(array("message" => "Task was deleted."));
} else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete task."));
}