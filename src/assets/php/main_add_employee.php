<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$new_employee = $_POST['new_form'];
$date = $_POST['date_now'];
$user_name_create_employee = $_POST['user_name_create_employee'];
$first_name = $new_employee['first_name'];
$last_name = $new_employee['last_name'];
$second_name = $new_employee['second_name'];
$type_department = $new_employee['type_department'];
$department = $new_employee['department'];
$position = $new_employee['position'];
$number_phone = '+380' . $new_employee['number_phone'];
$date_birth = $new_employee['date_birth'];
$status = $new_employee['status'];
$employee_description = $new_employee['employee_description'];



$sql = "SELECT MAX(`id_personal`) FROM db_main";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $id_personal
    );
    while ($stmt->fetch()) {
        $id_personal = ($id_personal + 1);
    }


    $sql = "INSERT INTO db_main (id_personal, date_create_employee, user_name_create_employee, first_name, last_name, second_name, type_department, department, position, number_phone, date_birth,`status`,employee_description) 
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param(
            "issssssssssss",
            $id_personal,
            $date,
            $user_name_create_employee,
            $first_name,
            $last_name,
            $second_name,
            $type_department,
            $department,
            $position,
            $number_phone,
            $date_birth,
            $status,
            $employee_description
        );
        $stmt->execute();
        if (count($stmt->error_list) === 0) {
            $res = "Пользователь добавлен";
        } else {
            $res = $stmt->error_list;
        }
    }
}




echo (json_encode($res));
