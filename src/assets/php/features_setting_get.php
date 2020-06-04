<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$user_id = $_POST['user_id'];

$res = array();


$sql = "SELECT feature_name, parameter_name, start_value, stop_value, step_value FROM features_set WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result(
    $feature_name,
    $parameter_name,
    $start_value,
    $stop_value,
    $step_value
  );
  while ($stmt->fetch()) {
    $res[] = array(
      'feature_name' => $feature_name,
      'parameter_name' => $parameter_name,
      'start_value' => $start_value,
      'stop_value' => $stop_value,
      'step_value' => $step_value
    );
  }
} else {
  $res[] = array('user_id', $db_connect->error);
}

echo(json_encode($res));

$db_connect->close();
