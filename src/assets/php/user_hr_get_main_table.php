<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_name_create_employee = $_POST['user_name_create_employee'];


$sql = "SELECT id_personal, first_name,last_name,second_name,position,type_department,department,number_phone,attraction_channel,attraction_channel_description,interview_date,internship_date,internship_place,certification_date,rejection_reason,`status`,employee_description FROM db_main WHERE user_name_create_employee=? ORDER BY db_main.id_personal DESC";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("s", $user_name_create_employee);
    $stmt->execute();
    $stmt->bind_result(
        $id_personal,
        $first_name,
        $last_name,
        $second_name,
        $position,
        $type_department,
        $department,
        $number_phone,
        $attraction_channel,
        $attraction_channel_description,
        $interview_date,
        $internship_date,
        $internship_place,
        $certification_date,
        $rejection_reason,
        $status,
        $employee_description
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'id_personal' => $id_personal,
            'fio' => $first_name . " " . $last_name . " " . $second_name,
            'position' => (string) $position,
            'type_department' => (string) $type_department,
            'department' => $department,
            'number_phone' => (string) $number_phone,
            'attraction_channel' => (string) $attraction_channel,
            'attraction_channel_description' => (string) $attraction_channel_description,
            'interview_date' => (string) $interview_date,
            'internship_date' => (string) $internship_date,
            'internship_place' => (string) $internship_place,
            'certification_date' => $certification_date,
            'rejection_reason' => (string) $rejection_reason,
            'status' => (string) $status,
            'employee_description' => (string) $employee_description
        );
    }
}


echo (json_encode($res));