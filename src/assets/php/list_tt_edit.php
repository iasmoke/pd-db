<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$edit_outlet = $_POST['edit_outlet'];
$id_tt = $edit_outlet['id_tt'];
$number_td = $edit_outlet['number_td'];
$address = $edit_outlet['address'];
$city = $edit_outlet['city'];
switch ($new_outlet['date_open']) {
  case null:
  $date_open = $new_outlet['date_open'];
      break;
  default:
  $date_open = date("d.m.Y", strtotime($new_outlet['date_open']));
      break;
}$manager = $edit_outlet['manager'];
$rm = $edit_outlet['rm'];



$sql = "UPDATE list_tt SET number_td=?, `address`=?, city=?, date_open=?, manager=?, rm=? WHERE id_tt=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("sssssss", $number_td, $address, $city, $date_open, $manager, $rm, $id_tt);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;   
  }
}

echo (json_encode($res));
