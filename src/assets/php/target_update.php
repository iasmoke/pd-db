<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$target_name = $_POST['target_name'];
$parameter_name = $_POST['parameter_name'];
$start_value = (float) $_POST['start_value'];
$stop_value = (float) $_POST['stop_value'];
$step_value = (float) $_POST['step_value'];


$sql = "UPDATE targets SET start_value=?, stop_value=?, step_value=? WHERE user_id=? AND target_name=? AND parameter_name=? ";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param('dddiss', $start_value, $stop_value, $step_value ,$user_id, $target_name, $parameter_name);
    $stmt->execute();
}else {
    $res[] = array('start_value','stop_value', 'step_value', $db_connect->error);
}




echo(json_encode(array($_POST)));




$db_connect->close();