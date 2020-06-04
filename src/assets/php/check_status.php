<?php

error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];

$sql = "SELECT user_status_research FROM users_settings WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $user_status_research
    );
    while ($stmt->fetch()) {
        $user_status_research = (int) $user_status_research;
    }
}

echo (json_encode($user_status_research));
