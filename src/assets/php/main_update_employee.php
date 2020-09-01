<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$form_edit_employee = $_POST['form_edit_employee'];
$id_personal = $_POST['id_personal'];
$date = $_POST['date_now'];
$user_name = preg_replace("/\s+/", "", $_POST['user_name']);
$first_name = preg_replace("/\s+/", "", $form_edit_employee['first_name']);
$last_name = preg_replace("/\s+/", "", $form_edit_employee['last_name']);
$second_name = preg_replace("/\s+/", "", $form_edit_employee['second_name']);
$type_department = $form_edit_employee['type_department'];
$department = $form_edit_employee['department'];
$position = $form_edit_employee['position'];
$number_phone = '+38' . $form_edit_employee['number_phone'];
$status = $form_edit_employee['status'];
$employee_description = $form_edit_employee['employee_description'];


$sql = "UPDATE db_main SET date_last_update=?, user_name_last_update=?, first_name=?, last_name=?, second_name=?, type_department=? ,department=?, position=?, number_phone=?, `status`=?, employee_description=?  WHERE id_personal=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ssssssssssss", $date, $user_name, $first_name, $last_name, $second_name, $type_department, $department, $position, $number_phone, $status, $employee_description, $id_personal);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
}

echo (json_encode($res));
