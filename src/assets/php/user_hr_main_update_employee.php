<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$form_edit_employee = $_POST['form_edit_employee'];
$time_last_change = $_POST['time_last_change'];
$first_name = preg_replace("/\s+/", "", $form_edit_employee['first_name']);
$last_name = preg_replace("/\s+/", "", $form_edit_employee['last_name']);
$second_name = preg_replace("/\s+/", "", $form_edit_employee['second_name']);
$position = $form_edit_employee['position'];
$department = $form_edit_employee['department'];
$number_phone = '+38' . $form_edit_employee['number_phone'];
$attraction_channel = $form_edit_employee['attraction_channel'];
$type_department = $form_edit_employee['type_department'];
$attraction_channel_description = $form_edit_employee['attraction_channel_description'];
$interview_date = $form_edit_employee['interview_date'];
$internship_date = $form_edit_employee['internship_date'];
$certification_date = $form_edit_employee['certification_date'];
$rejection_reason = $form_edit_employee['rejection_reason'];
$internship_place = $form_edit_employee['internship_place'];
$status = $form_edit_employee['status'];
$employee_description = $form_edit_employee['employee_description'];
$certification_date = $form_edit_employee['certification_date'];
$user_name = $_POST['user_name'];
$color = $form_edit_employee['color'];


$sql = "UPDATE `db_main` SET time_last_change=?, user_name_last_update=?, first_name=?, last_name=?, second_name=?, type_department=? ,department=?, `position`=?, number_phone=?, attraction_channel=?, attraction_channel_description=?, interview_date=?, internship_date=?, internship_place=?, rejection_reason=?, `status`=?, employee_description=?, certification_date=?, color=? WHERE id_person=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ssssssssssssssssssss",
  $time_last_change, $user_name, $first_name, $last_name, $second_name, $type_department, $department, $position,
  $number_phone, $attraction_channel, $attraction_channel_description, $interview_date, $internship_date, $internship_place,
  $rejection_reason, $status, $employee_description, $certification_date, $color, $id_person);

  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
}

echo (json_encode($res));
