<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$parameter_value = $_POST['parameter_value'];
$parameter_name = $_POST['parameter_name'];

$sql = "UPDATE trading_settings SET parameter_value=? WHERE user_id=? AND parameter_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("sis", $parameter_value, $user_id, $parameter_name);
    $stmt->execute();
} else {
    $res[] = array('parameter_value', $db_connect->error);
}





echo(json_encode(array($_POST)));




$db_connect->close();