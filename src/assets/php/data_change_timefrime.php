<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$timeframe = $_POST['timeframe'];


$sql = "UPDATE markets SET timeframe=? WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("si",$timeframe, $user_id);
    $stmt->execute();
}

echo (json_encode($_POST));




$db_connect->close();
