<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$test_score = $_POST['test_score'];
$passing_date = $_POST['passing_date'] === 'Invalid date' ? null: $_POST['passing_date'];
$id_person = $_POST['id_person'];
$name_test = $_POST['name_test'];




$sql = "UPDATE test_personnel SET test_score=?, passing_date=? WHERE id_person=? AND name_test=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ssis", $test_score, $passing_date, $id_person, $name_test);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
}

$sql = "UPDATE db_main SET passing_date=? WHERE id_person=? AND name_test=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ssis", $test_score, $passing_date, $id_person, $name_test);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
}

echo (json_encode($res));
