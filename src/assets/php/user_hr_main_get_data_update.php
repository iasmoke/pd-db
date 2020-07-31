<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$id_personal = $_POST['id_personal'];


$sql = "SELECT id_personal,first_name,last_name,second_name,position,department,number_phone,attraction_channel,attraction_channel_description,interview_date,internship_date,internship_place,rejection_reason,`status`,employee_description FROM db_main ";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $id_personal,
        $first_name,
        $last_name,
        $second_name,
        $position,
        $department,
        $number_phone,
        $attraction_channel,
        $attraction_channel_description,
        $interview_date,
        $internship_date,
        $internship_place,
        $rejection_reason,
        $status,
        $employee_description
    );
    while ($stmt->fetch()) {
        $res[] = array (
            'id_personal' => (int) $id_personal,
            'first_name' => (string) $first_name,
            'last_name' => (string) $last_name,
            'second_name' =>(string) $second_name,
            'position' => (string) $position,
            'department' => $department,
            'number_phone' => stristr($number_phone,'3'),
            'attraction_channel' => (string) $attraction_channel,
            'attraction_channel_description' => (string) $attraction_channel_description,
            'interview_date' => (string) $interview_date,
            'internship_date' => (string) $internship_date,
            'internship_place' => (string) $internship_place,
            'rejection_reason' => (string) $rejection_reason,
            'status' => (string) $status,
            'employee_description' => (string) $employee_description
        );
        }
}


echo (json_encode($res));
