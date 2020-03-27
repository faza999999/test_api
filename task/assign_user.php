<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

include_once '../objects/task.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
if(!$data->assigned_user_id || !$data->task_id) {
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to assign user. The data is missing."));
    die;
}

if(!$user->existUser($data->assigned_user_id)){
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "User is not exist."));
    die;
}

$task->assigned_user_id = (int) $data->assigned_user_id;
$task->id = (int) $data->task_id;
if($task->assignUser()){
    http_response_code(201);
    echo json_encode(array("message" => "User was success assigned."));
    die;
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to assign user."));
    die;
}
