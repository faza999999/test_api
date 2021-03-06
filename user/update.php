<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

$user->user_id = (int)$data->user_id;
$user->fist_name = $data->fist_name;
$user->last_name = $data->last_name;

if ($user->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "User was updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update user."));
}