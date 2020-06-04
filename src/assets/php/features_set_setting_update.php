<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$feature_name = $_POST['feature_name'];
$parameter_name = $_POST['parameter_name'];
$value_name = $_POST['value_name'];
$start_value = (float) $_POST['start_value'];
$stop_value = (float) $_POST['stop_value'];
$step_value = (float) $_POST['step_value'];
$type = $_POST['type'];


$sql = "UPDATE features_set SET start_value=?, stop_value=?, step_value=?, type=? WHERE user_id=? AND feature_name=? AND parameter_name=? AND value_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param('dddsisss', $start_value, $stop_value, $step_value, $type ,$user_id, $feature_name, $parameter_name, $value_name);
    $stmt->execute();
}




echo(json_encode($_POST));




$db_connect->close();