<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_name_create_employee = $_POST['user_name_create_employee'];


$sql = "SELECT id_person, first_name,last_name,second_name,position,type_department,department,number_phone,attraction_channel,attraction_channel_description,interview_date,internship_date,internship_place,certification_date,rejection_reason,`status`,employee_description, color FROM db_main ORDER BY db_main.id_person DESC";
if ($stmt = $db_connect->prepare($sql)) {
    // $stmt->bind_param("s", $user_name_create_employee);
    $stmt->execute();
    $stmt->bind_result(
        $id_person,
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
        $employee_description,
        $color
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'id_person' => $id_person,
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
            'certification_date' => (string) $certification_date,
            'rejection_reason' => (string) $rejection_reason,
            'status' => (string) $status,
            'employee_description' => (string) $employee_description,
            'color' => (string) $color
        );
    }
}

// foreach ($res as $value) {
//     if($value['interview_date'] === '01.01.1970'){
//         $newDate_interview_date = '';
//     }
//     if($value['internship_date'] === '01.01.1970'){
//         $newDate_internship_date = '';
//     }
//     if($value['certification_date'] === '01.01.1970'){
//         $newDate_certification_date = '';
//     }

    // $newDate_interview_date = date("d.m.Y", strtotime($value['interview_date']));
    // $newDate_internship_date = date("d.m.Y", strtotime($value['internship_date']));
    // $newDate_certification_date = date("d.m.Y", strtotime($value['certification_date']));

//     $sql = "UPDATE db_main SET interview_date=?, internship_date=?, certification_date=? WHERE id_person=?";
//     if ($stmt = $db_connect->prepare($sql)) {
//         $stmt->bind_param(
//             "ssss",
//             $newDate_interview_date,
//             $newDate_internship_date,
//             $newDate_certification_date,
//             $value['id_person']
//         );
//         $stmt->execute();
//     }
// }



echo (json_encode($res));
