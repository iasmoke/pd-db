<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$TOKEN_name = $_POST['TOKEN_name'];
$TOKEN_id = $_POST['TOKEN_id'];





$sql = "INSERT INTO user_settings (user_id, user_name, TOKEN_name, TOKEN_id) VALUES (?,?,?,?)";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param(
        "ssss",
        $user_id,
        $user_name,
        $TOKEN_name,
        $TOKEN_id,
    );
    $stmt->execute();
    if (count($stmt->error_list) === 0) {
        $res = "Добавлен TOKEN";
    } else {
        $res = $stmt->error_list;
    }
}





echo (json_encode($res));
