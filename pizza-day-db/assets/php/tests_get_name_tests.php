<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);


$sql = "SELECT DISTINCT name_test FROM test_name";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $name_test
    );
    while ($stmt->fetch()) {
        $res[] =  $name_test;
        }
}


echo (json_encode($res));
