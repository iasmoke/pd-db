<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];


$sql = "SELECT TOKEN_name, TOKEN_id FROM user_settings WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("s",$user_id);
    $stmt->execute();
    $stmt->bind_result(
        $TOKEN_name,
        $TOKEN_id
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'TOKEN_name' =>  $TOKEN_name,
            'TOKEN_id' =>  $TOKEN_id
        );
    }
}


echo (json_encode($res));
