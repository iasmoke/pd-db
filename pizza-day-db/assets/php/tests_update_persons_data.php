
<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$editPerson = $_POST['editPerson'];
$id_person = $_POST['id_person'];




$sql = "UPDATE test_personnel SET last_name=?, first_name=?, second_name=?, type_department=?, department=?, position=?, internship_date=? WHERE id_person=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("sssssssi", $editPerson['last_name'], $editPerson['first_name'], $editPerson['second_name'], $editPerson['type_department'], $editPerson['department'], $editPerson['position'], $editPerson['internship_date'], $id_person);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
}

echo (json_encode($res));
