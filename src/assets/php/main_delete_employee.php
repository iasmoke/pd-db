<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$id_personal = $_POST['id_personal'];


$sql = "DELETE FROM db_main WHERE id_personal=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("s", $id_personal);
    $stmt->execute();
    if (count($stmt->error_list) === 0) {
        $res = "Пользователь удален";
    } else {
        $res = $stmt->error_list;
    }
}


echo (json_encode($res));
