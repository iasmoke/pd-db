<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$spread_name = $_POST['spread_name'];
$spread_from = $_POST['spread_from'];
$spread_to = $_POST['spread_to'];
$spread_value = (float) $_POST['spread_value'];


$sql = "UPDATE spread SET spread_from=?, spread_to=?, spread_value=? WHERE user_id=? AND spread_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param('ssdii', $spread_from, $spread_to, $spread_value ,$user_id, $spread_name);
    $stmt->execute();
}




echo(json_encode($_POST));




$db_connect->close();