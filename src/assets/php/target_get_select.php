<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];

$res = array();

$sql = "SELECT DISTINCT target_name FROM targets WHERE user_id=? AND select_type=1";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $target_name
    );
    while ($stmt->fetch()) {
        $res = $target_name;
    }
}

echo (json_encode($res));

$db_connect->close();