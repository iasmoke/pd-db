<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$user_id = $_POST['user_id'];
$feature_name = $_POST['feature_name'];


$sql = "SELECT feature_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name,file, def_feature FROM features WHERE user_id=? AND feature_name=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("is", $user_id, $feature_name);
  $stmt->execute();
  $stmt->bind_result(
    $feature_name,
    $parameter_name,
    $value_name,
    $start_value,
    $stop_value,
    $step_value,
    $type,
    $parameter_description,
    $file_name,
    $file,
    $def_feature
  );
  while ($stmt->fetch()) {
    $res[] = array(
      'feature_name' => $feature_name,
      'parameter_name' => $parameter_name,
      'value_name' => $value_name,
      'start_value' => $start_value,
      'stop_value' => $stop_value,
      'step_value' => $step_value,
      'type' => $type,
      'parameter_description' => $parameter_description,
      'file' => $file,
      'def_feature' => (int) $def_feature
    );
  }
}

$code = base64_decode($file);

echo (json_encode(array('parameter_feature' => $res, 'file_text' => $code , 'feature_name' =>$feature_name, 'parameter_description' => $parameter_description)));

$db_connect->close();
