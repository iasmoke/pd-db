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

$result = [];
$sql = "SELECT name_test FROM test_name WHERE name_test=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param('s', $name_test);
  $stmt->execute();
  $stmt->bind_result(
    $name_test_double
  );
  while ($stmt->fetch()) {
    $result[] =  $name_test_double;
  }
  if (count($result) === 0) {
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
      $sql = "SELECT id_person, last_name, first_name, second_name, type_department, department, position, internship_date FROM db_main WHERE position=?";
      if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("s",$position_type);
        $stmt->execute();
        $stmt->bind_result(
          $id_person, $last_name, $first_name, $second_name, $type_department, $department, $position, $internship_date
        );
        while ($stmt->fetch()) {
          $result[] = array(
            'id_person' => $id_person,
            'last_name' =>  $last_name,
            'first_name' =>  $first_name,
            'second_name' =>  $second_name,
            'type_department' =>  $type_department,
            'department' =>  $department,
            'position' => $position,
            'internship_date' => $internship_date
          );
        }

        foreach ($result as $value) {
          $sql = "INSERT INTO test_personnel (id_person, name_test, last_name, first_name ,second_name, type_department, department, position, internship_date) VALUES (?,?,?,?,?,?,?,?,?)";
          if ($stmt = $db_connect->prepare($sql)) {
            $stmt->bind_param(
              "issssssss",
              $value['id_person'],
              $name_test,
              $value['last_name'],
              $value['first_name'],
              $value['second_name'],
              $value['type_department'],
              $value['department'],
              $value['position'],
              $value['internship_date']
            );
            $stmt->execute();
          }
        }
      }
      $res = "Новый тест добавлен";
      echo (json_encode($res));
    }
  } else {
    echo(json_encode($res =  $name_test . ' уже существует!' , JSON_UNESCAPED_UNICODE));
    return ;
  }
}






