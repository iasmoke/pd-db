<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$department_office = $_POST['department_office'];



$sql = "SELECT id_person,id_telegram_chat, first_name, last_name,department FROM db_main WHERE department=? AND `status`='Работает'";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param('s', $department_office);
  $stmt->execute();
  $stmt->bind_result(
    $id_person,
    $id_telegram_chat,
    $first_name,
    $last_name,
    $department
  );
  while ($stmt->fetch()) {
    $res[] = array(
        'id_person' => $id_person,
        'id_telegram_chat' => $id_telegram_chat,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'department' => $department_office
    );
  }
}


echo (json_encode($res));
