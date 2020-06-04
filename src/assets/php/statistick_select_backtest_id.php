<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$backtest_id = $_POST['backtest_id'];

$sql = "UPDATE backtests SET select_type_oos=0 WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

$sql = "UPDATE backtests SET select_type_oos=1 WHERE user_id=? AND backtest_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("is", $user_id, $backtest_id);
    $stmt->execute();
}



echo (json_encode($_POST));




$db_connect->close();
