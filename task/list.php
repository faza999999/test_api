<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);
$stmt = $task->getList();
$num = $stmt->rowCount();
if ($num > 0) {
    $task_arr = array();
    $task_arr['tasks'] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        array_push($task_arr["tasks"], $row);
    }
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($task_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "Tasks not found."), JSON_UNESCAPED_UNICODE);
}
