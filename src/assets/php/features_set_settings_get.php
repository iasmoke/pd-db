<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$user_id = $_POST['user_id'];
$feature_name = $_POST['feature_name'];

$res = array();


$sql = "SELECT parameter_name, value_name, start_value, stop_value, step_value, type, file FROM features_set WHERE user_id=? AND feature_name=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("is", $user_id, $feature_name);
  $stmt->execute();
  $stmt->bind_result(
    $parameter_name,
    $value_name,
    $start_value,
    $stop_value,
    $step_value,
    $type,
    $file
  );
  while ($stmt->fetch()) {
    $res[] = array(
      'parameter_name' => $parameter_name,
      'value_name' => $value_name,
      'start_value' => $start_value,
      'stop_value' => $stop_value,
      'step_value' => $step_value,
      'type' => $type,
      'file' => $file
    );
  }
}

$code = base64_decode($file);

echo (json_encode(array(
    'res' => $res,
    'file' => $code
)));

$db_connect->close();
