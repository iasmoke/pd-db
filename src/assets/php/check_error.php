<?php

error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];

$sql = "SELECT log_error FROM users_settings WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $log_error
    );
    while ($stmt->fetch()) {
        $log_error = $log_error;
    }
}
if ($log_error === "") {
    $status_err = 0;
    echo (json_encode($status_err));
} else {
    $status_err = 1;
    echo (json_encode($status_err));
}
