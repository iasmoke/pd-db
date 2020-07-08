<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);



$sql = "SELECT DISTINCT position FROM `pd_data` WHERE type_department='Торговая точка'";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->execute();
  $stmt->bind_result(
    $position
  );
  while ($stmt->fetch()) {
    $res[] = $position;
  }
}


echo (json_encode($res));
