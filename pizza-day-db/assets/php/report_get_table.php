<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);
$type_reports = $_POST['type_reports'];



switch ($type_reports) {
  case 'all':
    $sql = "SELECT id, first_name,last_name,number_phone,department,position,type_reports,`description`, date_time FROM reports_employee ORDER BY `reports_employee`.`id` DESC";
    if ($stmt = $db_connect->prepare($sql)) {
      $stmt->execute();
      $stmt->bind_result(
        $id,
        $first_name,
        $last_name,
        $number_phone,
        $department,
        $position,
        $type_reports,
        $description,
        $date_time
      );
      while ($stmt->fetch()) {
        $res[] =  array(
          'id' => $id,
          'fi' => $last_name . " " . $first_name ,
          'number_phone' => $number_phone,
          'department' => $department,
          'position' => $position,
          'type_reports' => $type_reports,
          'description' => $description,
          'date_time' => $date_time === null ? '': date('d.m.Y',strtotime($date_time))
        );
      }
    }
    break;
  default:
    $sql = "SELECT id, first_name, last_name, number_phone, department, position,type_reports,`description`, date_time FROM reports_employee WHERE type_reports=? ORDER BY `reports_employee`.`id` DESC";
    if ($stmt = $db_connect->prepare($sql)) {
      $stmt->bind_param("s",$type_reports);
      $stmt->execute();
      $stmt->bind_result(
        $id,
        $first_name,
        $last_name,
        $number_phone,
        $department,
        $position,
        $type_reports,
        $description,
        $date_time
      );
      while ($stmt->fetch()) {
        $res[] =  array(
          'id' => $id,
          'fi' => $last_name . " " . $first_name ,
          'number_phone' => $number_phone,
          'department' => $department,
          'position' => $position,
          'type_reports' => $type_reports,
          'description' => $description,
          'date_time' => $date_time === null ? '': date('d.m.Y',strtotime($date_time))
        );
      }
    }
    break;
}



echo (json_encode( $res));
