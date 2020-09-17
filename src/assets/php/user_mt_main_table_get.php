<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);



$sql = "SELECT id_person,	name_test, last_name, first_name,	second_name, test_score, type_department, department,	position,	passing_date FROM test_personnel ";
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
        $passing_date
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
        );
    }
}



echo (json_encode($res));
