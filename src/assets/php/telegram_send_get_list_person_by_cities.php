<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);
$array_city = $_POST['array_city'];
$res = [];

switch ($array_city) {
  case null:
    $res = [];
    break;

  default:
    foreach ($array_city as $value) {
      $sql = "SELECT DISTINCT number_td FROM list_tt WHERE city=?";
      if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->bind_result(
          $number_td
        );
        while ($stmt->fetch()) {
          $res['number_td'][] = $number_td;
        }
      }
    }

    foreach ($res['number_td'] as $items) {

      $sql = "SELECT id_person, id_telegram, first_name, last_name, department, type_department, position, `status` FROM db_main WHERE department=? AND id_telegram IS NULL";
      if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("s", $items);
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

      $sql = "SELECT id_person, id_telegram, first_name, last_name, department, type_department, position, `status` FROM db_main WHERE (`status`='Работает' OR `status`='Стажёр') AND  department=? AND id_telegram IS NOT NULL";
      if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("s", $items);
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
    }
    break;
}






echo (json_encode($res));
