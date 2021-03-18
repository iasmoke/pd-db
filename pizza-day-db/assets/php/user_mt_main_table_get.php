<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$name_test_post = $_POST['name_test'];
$passing_date_post = $_POST['passing_date'] === 'Invalid date' ? 'all' : $_POST['passing_date'];


switch ($name_test_post === 'all' && $passing_date_post === 'all') {
  case true:
    $sql = "SELECT id_person,	name_test, last_name, first_name,	second_name, test_score, type_department, department,	position,	passing_date, internship_date FROM test_personnel";
    if ($stmt = $db_connect->prepare($sql)) {
      $stmt->execute();
      $stmt->bind_result(
        $id_person,
        $name_test,
        $last_name,
        $first_name,
        $second_name,
        $test_score,
        $type_department,
        $department,
        $position,
        $passing_date,
        $internship_date
      );
      while ($stmt->fetch()) {
        $res[] = array(
          'id_person' => (int) $id_person,
          'fio' => $last_name . " " . $first_name . " " . $second_name,
          'position' => (string) $position,
          'test_score' => $test_score,
          'name_test' => (string) $name_test,
          'department' => (string) $department,
          'type_department' => (string) $type_department,
          'passing_date' => $passing_date,
          'internship_date' => $internship_date === null ? '' : date("d.m.Y", strtotime($internship_date))
        );
      }
    }
    $res_1 = '1';
    break;
}
switch ($passing_date_post !== 'all' && $name_test_post === 'all') {
  case true;
    $sql = "SELECT id_person,	name_test, last_name, first_name,	second_name, test_score, type_department, department,	position,	passing_date, internship_date FROM test_personnel WHERE passing_date=?";
    if ($stmt = $db_connect->prepare($sql)) {
      $stmt->bind_param("s", $passing_date_post);
      $stmt->execute();
      $stmt->bind_result(
        $id_person,
        $name_test,
        $last_name,
        $first_name,
        $second_name,
        $test_score,
        $type_department,
        $department,
        $position,
        $passing_date,
        $internship_date
      );
      while ($stmt->fetch()) {
        $res[] = array(
          'id_person' => (int) $id_person,
          'fio' => $last_name . " " . $first_name . " " . $second_name,
          'position' => (string) $position,
          'test_score' => $test_score,
          'name_test' => (string) $name_test,
          'department' => (string) $department,
          'type_department' => (string) $type_department,
          'passing_date' => $passing_date,
          'internship_date' => $internship_date === null ? '' : date("d.m.Y", strtotime($internship_date))
        );
      }
    }
    $res_2 = '2';
    break;
}
switch ($passing_date_post === 'all' && $name_test_post !== 'all') {
  case true;
  $sql = "SELECT id_person,	name_test, last_name, first_name,	second_name, test_score, type_department, department,	position,	passing_date, internship_date FROM test_personnel WHERE name_test=? ";
  if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("s", $name_test_post);
    $stmt->execute();
    $stmt->bind_result(
      $id_person,
      $name_test,
      $last_name,
      $first_name,
      $second_name,
      $test_score,
      $type_department,
      $department,
      $position,
      $passing_date,
      $internship_date
    );
    while ($stmt->fetch()) {
      $res[] = array(
        'id_person' => (int) $id_person,
        'fio' => $last_name . " " . $first_name . " " . $second_name,
        'position' => (string) $position,
        'test_score' => $test_score,
        'name_test' => (string) $name_test,
        'department' => (string) $department,
        'type_department' => (string) $type_department,
        'passing_date' => $passing_date,
        'internship_date' => $internship_date === null ? '' : date("d.m.Y", strtotime($internship_date))
      );
    }
  }
  $res_3 = '3';
  break;
}

switch (($passing_date_post !== 'all') && ($name_test_post !== 'all')) {
  case true;
  $sql = "SELECT id_person,	name_test, last_name, first_name,	second_name, test_score, type_department, department,	position,	passing_date, internship_date FROM test_personnel WHERE name_test=? AND passing_date=? ";
  if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ss", $name_test_post, $passing_date_post);
    $stmt->execute();
    $stmt->bind_result(
      $id_person,
      $name_test,
      $last_name,
      $first_name,
      $second_name,
      $test_score,
      $type_department,
      $department,
      $position,
      $passing_date,
      $internship_date
    );
    while ($stmt->fetch()) {
      $res[] = array(
        'id_person' => (int) $id_person,
        'fio' => $last_name . " " . $first_name . " " . $second_name,
        'position' => (string) $position,
        'test_score' => $test_score,
        'name_test' => (string) $name_test,
        'department' => (string) $department,
        'type_department' => (string) $type_department,
        'passing_date' => $passing_date,
        'internship_date' => $internship_date === null ? '' : date("d.m.Y", strtotime($internship_date))
      );
    }
  }
  $res_4 = '4';
  break;
}







echo (json_encode($res));
