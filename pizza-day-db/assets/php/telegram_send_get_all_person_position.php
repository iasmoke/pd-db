<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$position = $_POST['position'];
$type_department = $_POST['type_department'];

$res = [];

$sql = "SELECT id_person, id_telegram, first_name, last_name, department, type_department, position, `status` FROM db_main WHERE type_department=? AND position=? AND id_telegram IS NULL";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ss",$type_department, $position);
  $stmt->execute();
  $stmt->bind_result(
    $id_person,
    $id_telegram,
    $first_name,
    $last_name,
    $department,
    $type_department,
    $position,
    $status
  );
  while ($stmt->fetch()) {
    $res['not_connected'][] = array(
      'id_person' => $id_person,
      'id_telegram' => $id_telegram,
      'fi' => $last_name . " " . $first_name,
      'department' => $department,
      'type_department' => $type_department,
      'position' => $position,
      'status' => $status
    );
  }
}

$sql = "SELECT id_person, id_telegram, first_name, last_name, department, type_department, position, `status` FROM db_main WHERE (`status`='Работает' OR `status`='Стажёр') AND type_department=? AND position=? AND id_telegram IS NOT NULL";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ss",$type_department, $position);
  $stmt->execute();
  $stmt->bind_result(
    $id_person,
    $id_telegram,
    $first_name,
    $last_name,
    $department,
    $type_department,
    $position,
    $status
  );
  while ($stmt->fetch()) {
    $res['connected'][] = array(
      'id_person' => $id_person,
      'id_telegram' => $id_telegram,
      'fi' => $last_name . " " . $first_name,
      'department' => $department,
      'type_department' => $type_department,
      'position' => $position,
      'status' => $status
    );
  }
}






echo (json_encode($res));
