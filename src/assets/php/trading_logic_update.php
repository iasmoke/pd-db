<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$parameter_name = $_POST['parameter_name'];
$value_name = $_POST['value_name'];
$value = $_POST['value'];


$sql = "UPDATE trading_logics_settings SET value=? WHERE user_id=? AND value_name=? AND parameter_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param('disi', $value, $user_id, $value_name, $parameter_name);
    $stmt->execute();
}




echo(json_encode($_POST));




$db_connect->close();