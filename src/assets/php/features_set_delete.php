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



$sql = "DELETE FROM features_set WHERE user_id=? AND feature_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("is", $user_id, $feature_name);
    $stmt->execute();
};

$sql ="SELECT user_id, feature_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description FROM features_set WHERE user_id=?";
if($stmt = $db_connect->prepare($sql)){
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $user_id, $feature_name, $parameter_name, $value_name, $start_value, $stop_value, $step_value, $type, $parameter_description
    );
    while ($stmt->fetch()) {
        $res[] = array(
          'user_id' => $user_id,
          'feature_name' => $feature_name,
          'parameter_name' => $parameter_name,
          'value_name' => $value_name,
          'start_value' => $start_value,
          'stop_value' => $stop_value,
          'step_value' => $step_value,
          'type' => $type,
          'parameter_description' => $parameter_description
        );
      }
}

echo (json_encode($res));

$db_connect->close();