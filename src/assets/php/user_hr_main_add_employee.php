<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_name_create_employee = $_POST['user_name'];
$new_employee = $_POST['newPerson'];
$time_create =$_POST['dateTimeNow'];
$first_name = preg_replace("/\s+/", "", $new_employee['first_name']);
$last_name = preg_replace("/\s+/", "", $new_employee['last_name']);
$second_name = preg_replace("/\s+/", "", $new_employee['second_name']);
$position = $new_employee['position'];
$department = $new_employee['department'];
$number_phone = '+38' . $new_employee['number_phone'];
$attraction_channel = $new_employee['attraction_channel'];
$type_department = $new_employee['type_department'];
$attraction_channel_description = $new_employee['attraction_channel_description'];
$interview_date = $new_employee['interview_date'];
$internship_date = $new_employee['internship_date'];
$internship_place = $new_employee['internship_place'];
$rejection_reason = $new_employee['rejection_reason'];
$status = $new_employee['status'];
$employee_description = $new_employee['employee_description'];
$color = $new_employee['color'];

$tests_name = [];

$sql = mysqli_query($db_connect, "SELECT number_phone FROM db_main WHERE number_phone='" . mysqli_real_escape_string($db_connect, $number_phone) . "'");
if (mysqli_num_rows($sql) > 0) {
  $res = "Ошибка!!. Этот номер " . $number_phone . " закреплен за '" . $first_name . " " . $last_name . "'";
  echo (json_encode($res));
  return;
}


$sql = "SELECT MAX(`id_person`) FROM db_main";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->execute();
  $stmt->bind_result(
    $id_person
  );
  while ($stmt->fetch()) {
    $id_person = ($id_person + 1);
  }


  $sql = "INSERT INTO db_main (id_person, time_create, user_name_create_employee, first_name, last_name, second_name, type_department ,department, `position`, number_phone, attraction_channel, attraction_channel_description, interview_date, internship_date, internship_place, rejection_reason, `status`, employee_description, color) VALUES (?,?,?,?, ?,?,?,?, ?,?,?,?, ?,?,?,?, ?,?,?)";
  if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param(
      "issssssssssssssssss",
      $id_person,
      $time_create,
      $user_name_create_employee,
      $first_name,
      $last_name,
      $second_name,
      $type_department,
      $department,
      $position,
      $number_phone,
      $attraction_channel,
      $attraction_channel_description,
      $interview_date,
      $internship_date,
      $internship_place,
      $rejection_reason,
      $status,
      $employee_description,
      $color
    );
    $stmt->execute();
    if (count($stmt->error_list) === 0) {
      $sql = "SELECT name_test FROM test_name WHERE position_type=?";
      if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("s", $position);
        $stmt->execute();
        $stmt->bind_result(
          $name_test
        );
        while ($stmt->fetch()) {
          $tests_name[] = $name_test;
        }
        switch (count($tests_name)){
          case 0:
            $res = 'Пользователь добавлен';
          break;
          default:
          foreach ($tests_name as $value_test_name) {
            $sql = "INSERT INTO test_personnel ( id_person, name_test,last_name,first_name ,second_name,type_department,department,position,internship_date) VALUES (?,?,?,?,?,?,?,?,?)";
            if ($stmt = $db_connect->prepare($sql)) {
              $stmt->bind_param(
                "issssssss",
                $id_person,
                $value_test_name,
                $last_name,
                $first_name,
                $second_name,
                $type_department,
                $department,
                $position,
                $internship_date
              );
              $stmt->execute();
              if (count($stmt->error_list) === 0) {
              } else {
                $res = $stmt->error_list;
              }
            }
          }
        break;
        }
        $res = 'Пользователь добавлен';
      } else {
        $res = $stmt->error_list;
      }
    }
  }
}


echo (json_encode($res));
