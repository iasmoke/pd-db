<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$new_employee = $_POST['new_form_employee'];
$date = $_POST['date_now'];
$first_name = $new_employee['first_name'];
$last_name = $new_employee['last_name'];
$second_name = $new_employee['second_name'];
$department = $new_employee['department'];
$position = $new_employee['position'];
$number_phone = '+38' . $new_employee['number_phone'];
$attraction_channel = $new_employee['attraction_channel'];
$attraction_channel_description = $new_employee['attraction_channel_description'];
$type_department = $new_employee['type_department'];
$interview_date = $new_employee['interview_date'];
$status = $new_employee['status'];
$user_name_create_employee = $_POST['user_name_create_employee'];

$sql = "SELECT MAX(`id_personal`) FROM db_main";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $id_personal
    );
    while ($stmt->fetch()) {
        $id_personal = ($id_personal + 1);
    }


    $sql = "INSERT INTO db_main (id_personal,date_create_employee,user_name_create_employee,first_name,last_name,second_name,type_department,department,position,number_phone,interview_date,attraction_channel,attraction_channel_description,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param(
            "isssssssssssss",
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
            $interview_date,
            $attraction_channel,
            $attraction_channel_description,
            $status
        );
        $stmt->execute();
        if (count($stmt->error_list) === 0) {
            $res = 'Пользователь добавлен';
        } else {
            $res = $stmt->error_list;
        }
    }
}


echo (json_encode($res));

