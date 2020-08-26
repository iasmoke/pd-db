<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

 
$res = [];

$sql = "SELECT id_personal, first_name, last_name, second_name, position, department, number_phone, certification_date, test_date_1, test_number_ball_1, test_date_2, test_number_ball_2, internship_date, internship_place, `status`, employee_description 
FROM db_main";
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
        $certification_date,
        $test_date_1,
        $test_number_ball_1,
        $test_date_2,
        $test_number_ball_2,
        $internship_date,
        $internship_place,
        $status,
        $employee_description
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'id_personal' => (int) $id_personal,
            'fio' => $first_name . " " . $last_name . " " . $second_name,
            'position' => (string) $position,
            'certification_date' => (string) $certification_date,
            'department' => (string) $department,
            'number_phone' => (string) $number_phone,
            'test_date_1' => (string) $test_date_1,
            'test_number_ball_1' => (string) $test_number_ball_1,
            'test_date_2' => (string) $test_date_2,
            'test_number_ball_2' => (string) $test_number_ball_2,
            'internship_date' => (string) $internship_date,
            'internship_place' => (string) $internship_place,
            'status' => (string) $status,
            'employee_description' => (string) $employee_description
        );
    }
    
// $sql = "SELECT id_personal, first_name, last_name, second_name, position, department, number_phone, certification_date, test_date_1, test_number_ball_1, test_date_2, test_number_ball_2, internship_date, internship_place, `status`, employee_description 
// FROM db_main WHERE type_department='Офис'";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->execute();
//     $stmt->bind_result(
//         $id_personal,
//         $first_name,
//         $last_name,
//         $second_name,
//         $position,
//         $department,
//         $number_phone,
//         $certification_date,
//         $test_date_1,
//         $test_number_ball_1,
//         $test_date_2,
//         $test_number_ball_2,
//         $internship_date,
//         $internship_place,
//         $status,
//         $employee_description
//     );
//     while ($stmt->fetch()) {
//         $res[] = array(
//             'id_personal' => (int) $id_personal,
//             'first_name' => (string) $first_name,
//             'last_name' => (string) $last_name,
//             'second_name' => (string) $second_name,
//             'position' => (string) $position,
//             'certification_date' => (string) $certification_date,
//             'department' => (string) $department,
//             'number_phone' => (string) $number_phone,
//             'test_date_1' => (string) $test_date_1,
//             'test_number_ball_1' => (string) $test_number_ball_1,
//             'test_date_2' => (string) $test_date_2,
//             'test_number_ball_2' => (string) $test_number_ball_2,
//             'internship_date' => (string) $internship_date,
//             'internship_place' => (string) $internship_place,
//             'status' => (string) $status,
//             'employee_description' => (string) $employee_description
//         );
//     }
// }
}



echo (json_encode($res));
