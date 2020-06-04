<?php

error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
// header("Cache-Control: no-cache");
// header("Content-Type: text/event-stream\n\n");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];

$sql = "SELECT backtest_id FROM backtests WHERE user_id=? AND backtest_status=0 ORDER BY `backtests`.`backtest_id` ASC";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $backtest_id
    );
    while ($stmt->fetch()) {
        $backtest_id_list[] =  $backtest_id;
    }
}

echo (json_encode(array(
    'backtest_list' => $backtest_id_list)));
