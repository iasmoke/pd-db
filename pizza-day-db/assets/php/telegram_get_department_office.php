<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$type_department = $_POST['type_department'];

$res = [];

$sql = "SELECT DISTINCT department FROM `db_main` WHERE type_department=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param('s', $type_department);
  $stmt->execute();
  $stmt->bind_result(
    $department_office
  );
  while ($stmt->fetch()) {
    $res['department_office'] = array($department_office);
  }
}
$sql = "SELECT first_name, last_name, id_telegram, position, department FROM db_main WHERE type_department=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param('s', $type_department);
  $stmt->execute();
  $stmt->bind_result(
    $first_name,
    $last_name,
    $id_telegram,
    $position,
    $department
  );
  while ($stmt->fetch()) {
    $res['users'] = array(
      'first_name'=> $first_name,
      'last_name'=> $last_name,
      'id_telegram'=> $id_telegram,
      'position'=> $position,
      'department'=> $department
    );
  }
}


echo (json_encode($res));
