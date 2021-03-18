<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$new_outlet = $_POST['new_outlet'];
$number_td = $new_outlet['number_td'];
$city = $new_outlet['city'];
$address = $new_outlet['address'];
switch ($new_outlet['date_open']) {
    case null:
    $date_open = $new_outlet['date_open'];
        break;
    default:
    $date_open = date("d.m.Y", strtotime($new_outlet['date_open']));
        break;
}
$manager = $new_outlet['manager'];
$rm = $new_outlet['rm'];






$sql = "INSERT INTO list_tt (number_td, city, `address`, date_open ,manager ,rm) VALUES (?,?,?,?,?,?)";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ssssss",
        $number_td,
        $city,
        $address,
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
