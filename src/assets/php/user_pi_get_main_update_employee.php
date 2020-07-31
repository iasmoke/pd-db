<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$form_edit_employee = $_POST['form_edit_employee'];
$date_last_update = $_POST['date_now'];
$id_personal = $_POST['id_personal'];
$first_name = $form_edit_employee['first_name'];
$last_name = $form_edit_employee['last_name'];
$second_name = $form_edit_employee['second_name'];
$position = $form_edit_employee['position'];
$department = $form_edit_employee['department'];
$type_department = $form_edit_employee['type_department'];
$number_phone = '+' . $form_edit_employee['number_phone'];
$date_birth = $form_edit_employee['date_birth'];
$available_doc = $form_edit_employee['available_doc'];
$city_registration = $form_edit_employee['city_registration'];
$address_registration = $form_edit_employee['address_registration'];
$city_residence = $form_edit_employee['city_residence'];
$place_residence = $form_edit_employee['place_residence'];
$status = $form_edit_employee['status'];
$description_dismissal = $form_edit_employee['description_dismissal'];
$date_dismissal = $form_edit_employee['date_dismissal'];
$inn = $form_edit_employee['inn'];
$user_name = $_POST['user_name'];

if($status !== 'Уволен'){
  $date_dismissal = '';
}
if($date_birth === 'Invalid date'){
  $date_birth = '';
}
if($date_dismissal === 'Invalid date'){
  $date_dismissal = '';
}



$sql = "UPDATE `db_main` SET date_last_update=?, user_name_last_update=?, first_name=?, last_name=?, second_name=?, type_department=? ,department=?, `position`=?, number_phone=?, date_birth=?, available_doc=?, city_registration=?, address_registration=?, city_residence=?, place_residence=?, `status`=?, description_dismissal=?,date_dismissal=?,inn=? WHERE id_personal=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ssssssssssssssssssss", 
  $date_last_update, $user_name, $first_name, $last_name, $second_name, $type_department, $department, $position, $number_phone, $date_birth, $available_doc, $city_registration, $address_registration, $city_residence, $place_residence, $status, $description_dismissal,$date_dismissal,$inn, $id_personal);

  $stmt->execute();

  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
}

echo (json_encode($res));
