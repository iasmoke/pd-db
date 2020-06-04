<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$user_id = $_POST['user_id'];
$feature_name = $_POST['feature_name'];


$sql = "INSERT INTO features_set (user_id, feature_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name,file)
SELECT user_id, feature_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name, file FROM features WHERE user_id=? AND feature_name=?;";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("is", $user_id, $feature_name);
    $stmt->execute();
}

echo (json_encode($_POST));

$db_connect->close();
