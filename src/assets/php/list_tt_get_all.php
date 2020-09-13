<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);


$sql = "SELECT * FROM list_tt";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $id_tt,
        $number_td,
        $city,
        $address,
        $date_open,
        $manager,
        $rm
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'id_tt' => (int) $id_tt,
            'number_td' => (int) $number_td,
            'city' => (string) $city,
            'address' => (string) $address,
            'date_open' => (string) $date_open,
            'manager' => $manager,
            'rm' => (string) $rm,
          
        );
    }
}


echo (json_encode($res));
