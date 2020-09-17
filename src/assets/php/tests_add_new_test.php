<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$newTest = $_POST['newTest'];
$name_test = $newTest['name_test'];
$description_test = $newTest['description_test'];
$max_score = $newTest['max_score'];
$position_type = $newTest['position_type'];




$sql = "INSERT INTO test_name ( name_test, description_test, max_score ,position_type) VALUES (?,?,?,?)";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param(
    "ssss",
    $name_test,
    $description_test,
    $max_score,
    $position_type
  );
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
  } else {
    return $res = $stmt->error_list;
  }
  $sql = "SELECT id_person, last_name, first_name, second_name, type_department, department, position FROM db_main WHERE position=?";
  if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("s",$position_type);
    $stmt->execute();
    $stmt->bind_result(
      $id_person, $last_name, $first_name, $second_name, $type_department, $department, $position
    );
    while ($stmt->fetch()) {
      $result[] = array(
        'id_person' => $id_person,
        'last_name' =>  $last_name,
        'first_name' =>  $first_name,
        'second_name' =>  $second_name,
        'type_department' =>  $type_department,
        'department' =>  $department,
        'position' => $position
      );
    }

    foreach ($result as $value) {
      $sql = "INSERT INTO test_personnel (id_person, name_test, last_name, first_name ,second_name, type_department, department, position) VALUES (?,?,?,?,?,?,?,?)";
      if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param(
          "isssssss",
          $value['id_person'],
          $name_test,
          $value['last_name'],
          $value['first_name'],
          $value['second_name'],
          $value['type_department'],
          $value['department'],
          $value['position']
        );
        $stmt->execute();
      }
    }
  }
  $res = "Новый тест добавлен";
}



echo (json_encode($res));
