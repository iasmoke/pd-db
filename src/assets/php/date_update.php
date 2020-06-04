<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$user_id = $_POST['user_id'];
$parameter_value = $_POST['parameter_value'];
$parameter_name = $_POST['parameter_name'];
$resets = substr($parameter_value,0,10);

$sql = "UPDATE trading_settings SET parameter_value=? WHERE user_id=? AND parameter_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("sis", $resets, $user_id, $parameter_name);
    $stmt->execute();
} 





echo($resets);




$db_connect->close();