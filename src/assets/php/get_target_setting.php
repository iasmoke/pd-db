<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);



$user_id = $_POST['user_id'];
$select_type = $_POST['select_type'];
$res = array();


$sql = "SELECT parameter_name, start_value, stop_value, step_value, type, parameter_description,file_name FROM targets WHERE user_id=? AND select_type=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ii", $user_id, $select_type);
  $stmt->execute();
  $stmt->bind_result(
    $target_name,
    $parameter_name,
    $start_value,
    $stop_value,
    $step_value,
    $type,
    $parameter_description,
    $file_name
  );
  while ($stmt->fetch()) {
    $res[] = array(
      'target_name' => $target_name,
      'parameter_name' => $parameter_name,
      'start_value' => $start_value,
      'stop_value' => $stop_value,
      'step_value' => $step_value,
      'type' => $type,
      'parameter_description' => $parameter_description
    );
  }
}
$dir = "./features/$file_name";
$file = file_get_contents($dir);

echo (json_encode(array('parameter' => $res,'file_text' =>$file)));

$db_connect->close();
