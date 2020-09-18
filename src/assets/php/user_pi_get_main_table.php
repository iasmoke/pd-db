<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);


$res = [];

$sql = "SELECT id_person, first_name, last_name, second_name, type_department, position, department, number_phone, date_birth, address_registration, city_registration, date_forming, place_residence, city_residence, available_doc, `date_dismissal`, description_dismissal ,inn, `status`
FROM db_main ";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $id_person,
        $first_name,
        $last_name,
        $second_name,
        $type_department,
        $position,
        $department,
        $number_phone,
        $date_birth,
        $address_registration,
        $city_registration,
        $date_forming,
        $place_residence,
        $city_residence,
        $available_doc,
        $date_dismissal,
        $description_dismissal,
        $inn,
        $status
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'id_person'=> $id_person,
            'first_name'=> $first_name,
            'last_name'=> $last_name,
            'second_name'=> $second_name,
            'type_department' => $type_department,
            'position'=> $position,
            'department'=> $department,
            'number_phone'=> $number_phone,
            'date_birth'=> $date_birth,
            'address_registration'=> $address_registration,
            'city_registration'=> $city_registration,
            'date_forming'=> $date_forming,
            'place_residence'=> $place_residence,
            'city_residence'=> $city_residence,
            'available_doc'=> $available_doc,
            'date_dismissal'=> $date_dismissal,
            'description_dismissal'=> $description_dismissal,
            'inn'=> $inn,
            'status' => $status
        );
    }

}



echo (json_encode($res));
