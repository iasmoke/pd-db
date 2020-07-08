<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);


$sql = "SELECT id_tt, adress FROM `list_tt` ORDER BY `list_tt`.`id_tt` ASC";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $id_tt,
        $adress
     
    );
    while ($stmt->fetch()) {
        $res[] =  $id_tt.' - ' .$adress;
        }
}


echo (json_encode($res));
