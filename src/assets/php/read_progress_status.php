<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];

$sql = "SELECT progress_status FROM users_settings WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $progress_status
    );
    while ($stmt->fetch()) {
        $progress_status = $progress_status;
    }
}
if($progress_status === ""){
    $progress_status_a = "Waiting for the start";
}else{
    $progress_status_decode = base64_decode($progress_status); 
    $progress_status_a = strstr($progress_status_decode, ";",true); 
}


echo(json_encode(array('tooltip' => $progress_status_decode,'a' => $progress_status_a)));

$db_connect->close();
