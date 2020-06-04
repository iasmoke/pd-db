<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$backtest_id = $_POST['backtest_id'];
$code = $_POST['code'];
$code_c = (string) $code;

$sql = "SELECT date, nav, eq_nav FROM outofsample_results WHERE backtest_id=? AND code=? ORDER BY date ASC";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("is", $backtest_id, $code_c);
    $stmt->execute();
    $stmt->bind_result(
        $date,
        $nav,
        $eq_nav
    );
    while ($stmt->fetch()) {
        $equity[] = array(
            'date' => $date,
            'eq_nav' => $eq_nav
        );
        
    }
}


echo(json_encode($equity));