<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$user_id = $_POST['user_id'];
$target_name = $_POST['target_name'];


$sql = "SELECT target_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name, file, def_target FROM targets WHERE user_id=? AND target_name=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ss", $user_id, $target_name);
  $stmt->execute();
  $stmt->bind_result(
    $target_name,
    $parameter_name,
    $value_name,
    $start_value,
    $stop_value,
    $step_value,
    $type,
    $parameter_description,
    $file_name,
    $file_py,
    $def_target
  );
  while ($stmt->fetch()) {
    $res[] = array(
      'target_name' => $target_name,
      'parameter_name' => $parameter_name,
      'value_name' => $value_name,
      'start_value' => $start_value,
      'stop_value' => $stop_value,
      'step_value' => $step_value,
      'type' => $type,
      'parameter_description' => $parameter_description,
      'file' => $file_py,
      'def_target' => (int) $def_target
    );
  }
}

$code = base64_decode($file_py);

echo (json_encode(array('parameter_target'=> $res, 'file_text'=> $code, 'target_name'=> $target_name,'parameter_description'=>$parameter_description  )));

$db_connect->close();
