<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$form_edit_employee = $_POST['form_edit_employee'];
$id_personal = $_POST['id_personal'];
$first_name = $form_edit_employee['first_name'];
$date = $_POST['date_now'];
$last_name = $form_edit_employee['last_name'];
$patronymic = $form_edit_employee['patronymic'];
$department = $form_edit_employee['department'];
$position = $form_edit_employee['position'];
$number_phone = '+' . $form_edit_employee['numberPhone'];
$city = $form_edit_employee['city'];
$adress = $form_edit_employee['adress'];
$user_name = $_POST['user_name'];
$type_department = $form_edit_employee['type_department'];



$sql = "UPDATE pd_data SET date_last_update=?, user_name=?, first_name=?, last_name=?, patronymic=?, type_department=? ,department=?, position=?, number_phone=?, city=?, adress=? WHERE id_personal=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ssssssssssss", $date, $user_name, $first_name, $last_name, $patronymic, $type_department, $department, $position, $number_phone, $city, $adress, $id_personal);
  $stmt->execute();
  $res = 'Данные обновлены';
}

echo (json_encode($res));
