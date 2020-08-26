<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$new_outlet = $_POST['new_outlet'];
$id_tt = $new_outlet['id_tt'];
$city = $new_outlet['city'];
$adress = $new_outlet['adress'];
$date_open = date("d.m.Y", strtotime($new_outlet['date_open']));
$manager = $new_outlet['manager'];
$rm = $new_outlet['rm'];






$sql = "INSERT INTO list_tt (id_tt, city, adress, date_open ,manager ,rm) VALUES (?,?,?,?,?,?)";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ssssss",
        $id_tt,
        $city,
        $adress,
        $date_open,
        $manager,
        $rm
    );
    $stmt->execute();
    if (count($stmt->error_list) === 0) {
        $res = "Торговая точка добавлена";
    } else {
        $res = $stmt->error_list;
    }
}





echo (json_encode($res));
