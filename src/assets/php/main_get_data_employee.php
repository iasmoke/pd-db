<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$id_personal = $_POST['id_personal'];


$sql = "SELECT id_personal, first_name, last_name, second_name,type_department, department, position, number_phone, certification_date, date_birth,`status`,employee_description  FROM db_main WHERE id_personal=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("i", $id_personal);
  $stmt->execute();
  $stmt->bind_result(
    $id_personal,
    $first_name,
    $last_name,
    $second_name,
    $type_department,
    $department,
    $position,
    $number_phone,
    $certification_date,
    $date_birth,
    $status,
    $employee_description
  );
  while ($stmt->fetch()) {
    $res[] = array(
      'id_personal' => (string) $id_personal,
      'first_name' => (string) $first_name,
      'last_name' => (string) $last_name,
      'second_name' => (string) $second_name,
      'type_department' => $type_department,
      'department' => (string) $department,
      'position' => (string) $position,
      'number_phone' => stristr($number_phone,'3'),
      'certification_date' => (string) $certification_date,
      'date_birth' => (string) $date_birth,
      'status' => (string) $status,
      'employee_description' => (string) $employee_description,
    );
  }
}


echo (json_encode($res));
