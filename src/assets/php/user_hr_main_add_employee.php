<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$new_employee = $_POST['new_form_employee'];
$date = $_POST['date_now'];
$first_name = preg_replace("/\s+/", "", $new_employee['first_name']);
$last_name = preg_replace("/\s+/", "", $new_employee['last_name']);
$second_name = preg_replace("/\s+/", "", $new_employee['second_name']);
$department = $new_employee['department'];
$position = $new_employee['position'];
$number_phone = '+38' . $new_employee['number_phone'];
$attraction_channel = $new_employee['attraction_channel'];
$attraction_channel_description = $new_employee['attraction_channel_description'];
$type_department = $new_employee['type_department'];
$interview_date = $new_employee['interview_date'];
$status = $new_employee['status'];
$user_name_create_employee = $_POST['user_name_create_employee'];
$color = $new_employee['color'];

if ($interview_date === 'Invalid date') {
    $interview_date = '';
  }
  if ($interview_date === '01.01.1970') {
    $interview_date = '';
  }


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


    $sql = "INSERT INTO db_main (id_person,date_create_employee,user_name_create_employee,first_name,last_name,second_name,type_department,department,position,number_phone,interview_date,attraction_channel,attraction_channel_description,`status`,color) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param(
            "issssssssssssss",
            $id_person,
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
            $status,
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

