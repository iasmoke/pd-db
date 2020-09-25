<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_name_create_employee = $_POST['user_name_create_employee'];


$sql = "SELECT id_person, first_name,last_name,second_name,position,type_department,department,number_phone,attraction_channel,attraction_channel_description,interview_date,internship_date,internship_place,certification_date,rejection_reason,`status`,employee_description, color,date_birth FROM db_main ORDER BY db_main.id_person DESC";
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
        $color,
        $date_birth
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'id_person' => $id_person,
            'fio' =>  $last_name . " " .$first_name . " " . $second_name,
            'position' =>  $position,
            'type_department' =>  $type_department,
            'department' => $department,
            'number_phone' =>  $number_phone,
            'attraction_channel' =>  $attraction_channel,
            'attraction_channel_description' =>  $attraction_channel_description,
            'interview_date' =>  $interview_date === null ? '' : date("d.m.Y", strtotime($interview_date)),
            'internship_date' =>  $internship_date === null ? '' : date("d.m.Y", strtotime($internship_date)),
            'internship_place' =>  $internship_place,
            'certification_date' =>  $certification_date === null ? '' : date("d.m.Y", strtotime($certification_date)),
            'rejection_reason' =>  $rejection_reason,
            'status' =>  $status,
            'employee_description' =>  $employee_description,
            'color' => (string) $color,
            'date_birth' => $date_birth
        );
    }
}



// foreach ($res as $value) {

//     $newDate_interview_date = $value['interview_date'] === null ? null : date("Y-m-d", strtotime($value['interview_date'])) && $value['interview_date'] === "" ? null : date("Y-m-d", strtotime($value['interview_date']));
//     $newDate_internship_date = $value['internship_date'] === null ? null : date("Y-m-d", strtotime($value['internship_date'])) && $value['internship_date'] === "" ? null : date("Y-m-d", strtotime($value['internship_date']));
//     $newDate_certification_date = $value['certification_date'] === null ? null : date("Y-m-d", strtotime($value['certification_date'])) && $value['certification_date'] === "" ? null : date("Y-m-d", strtotime($value['certification_date']));
//     $newDate_birth = $value['date_birth'] === null ? null : date("Y-m-d", strtotime($value['date_birth'])) && $value['date_birth'] === "" ? null : date("Y-m-d", strtotime($value['date_birth']));

//     $sql = "UPDATE db_main SET interview_date=?, internship_date=?, certification_date=? ,date_birth=? WHERE id_person=?";
//     if ($stmt = $db_connect->prepare($sql)) {
//         $stmt->bind_param(
//             "sssss",
//             $newDate_interview_date,
//             $newDate_internship_date,
//             $newDate_certification_date,
//             $newDate_birth,
//             $value['id_person']
//         );
//         $stmt->execute();
//     }
// }



echo (json_encode($res));
