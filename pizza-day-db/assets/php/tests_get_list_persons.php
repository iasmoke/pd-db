<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_name_create_employee = $_POST['user_name_create_employee'];


$sql = "SELECT id_person, first_name, last_name, second_name, position, department, type_department , internship_date FROM db_main ORDER BY `db_main`.`last_name` ASC";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $id_person,
        $first_name,
        $last_name,
        $second_name,
        $position,
        $department,
        $type_department,
        $internship_date
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'id_person' => $id_person,
            'fi' =>  $last_name . " " .$first_name,
            'position' =>  $position,
            'type_department' =>  $type_department,
            'department' => $department,
            'second_name' => $second_name,
            'internship_date' => $internship_date === null ? '' : date("d.m.Y", strtotime($internship_date))
        );
    }
}



echo (json_encode($res));
