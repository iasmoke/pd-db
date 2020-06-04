<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$data_type = $_POST['data_type'];
$timeframe_type = $_POST['timeframe_type'];

$sql = "UPDATE markets SET select_type=0 WHERE user_id=? AND data_type=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("is", $user_id, $data_type);
    $stmt->execute();
}
$sql = "UPDATE markets SET select_type=1 WHERE user_id=? AND data_type=? AND timeframe_type=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("iss", $user_id, $data_type, $timeframe_type);
    $stmt->execute();
    }    



echo (json_encode($_POST));




$db_connect->close();
