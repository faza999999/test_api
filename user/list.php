<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$stmt = $user->getList();
$num = $stmt->rowCount();
if ($num > 0) {
    $user_arr = array();
    $user_arr['users'] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        array_push($user_arr["users"], $row);
    }
    http_response_code(200);
    echo json_encode($user_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No users found."));
}
