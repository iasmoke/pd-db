<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$type_department = $_POST['type_department'];



$sql = "SELECT DISTINCT department FROM `pd_data` WHERE type_department=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param('s', $type_department);
  $stmt->execute();
  $stmt->bind_result(
    $department_office
  );
  while ($stmt->fetch()) {
    $res[] = $department_office;
  }
}


echo (json_encode($res));
