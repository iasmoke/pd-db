<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$list_person = $_POST['list_person'];
$name_test = $_POST['name_test'];



foreach($list_person as $value) {
  $fi = explode(" ", $value['fi']);
  $internship_date =  $value['internship_date'] === '' ? null : date("Y-m-d", strtotime($value['internship_date']));
  $sql = "INSERT INTO test_personnel (id_person, name_test, last_name, first_name ,second_name, type_department, department, position, internship_date) VALUES (?,?,?,?,?,?,?,?,?)";
  if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param(
      "issssssss",
      $value['id_person'],
      $name_test,
      $fi[0],
      $fi[1],
      $value['second_name'],
      $value['type_department'],
      $value['department'],
      $value['position'],
      $internship_date
    );
    $stmt->execute();
  }
}

$res = 'Готово!';


echo (json_encode($res));
