<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);


$sql = "SELECT id_person, first_name, last_name, second_name, type_department, department, position, number_phone ,certification_date, `status`, employee_description FROM db_main ORDER BY db_main.id_person DESC";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $id_person,
        $first_name,
        $last_name,
        $second_name,
        $type_department,
        $department,
        $position,
        $number_phone,
        $certification_date,
        $status,
        $employee_description
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'id_person' => (int) $id_person,
            'first_name' => (string) $first_name,
            'last_name' => (string) $last_name,
            'second_name' => (string) $second_name,
            'type_department' => $type_department,
            'department' => (string) $department,
            'position' => (string) $position,
            'number_phone' => (string) $number_phone,
            'certification_date' => (string) $certification_date,
            'status' => (string) $status,
            'employee_description' => (string) $employee_description,
        );
    }
}


echo (json_encode($res));
