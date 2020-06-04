<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$parameter_name = $_POST['parameter_name'];

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? AND parameter_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("is", $user_id, $parameter_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
}





echo(json_encode($result));




$db_connect->close();