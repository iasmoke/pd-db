<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_name = $_POST['user_name'];
$new_employee = $_POST['new_form_employee'];
$time_create = date(strftime('Y-m-d H:m:s',$_POST['time_create']));
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
$certification_date = $new_employee['certification_date'];
$internship_place = $new_employee['internship_place'];
$rejection_reason = $new_employee['rejection_reason'];
$status = $new_employee['status'];
$employee_description = $new_employee['employee_description'];
$certification_date = $new_employee['certification_date'];
$color = $new_employee['color'];


$sql = mysqli_query($db_connect, "SELECT number_phone FROM db_main WHERE number_phone='" . mysqli_real_escape_string($db_connect, $number_phone) . "'");
if (mysqli_num_rows($sql) > 0) {
    $res = "Ошибка!!. Этот номер ".$number_phone." закреплен за '".$first_name." ".$last_name."'";
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


    $sql = "INSERT INTO db_main (id_person, time_create, user_name_create_employee, first_name, last_name, second_name, type_department ,department, `position`, number_phone, attraction_channel, attraction_channel_description, interview_date, internship_date, internship_place, rejection_reason, `status`, employee_description, certification_date, color) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param(
            "isssssssssssssssssss",
            $id_person,
            $time_create,
            $user_name_create_employee,
            $first_name,
            $last_name,
            $second_name,
            $type_department ,
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
            $certification_date,
            $color
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

