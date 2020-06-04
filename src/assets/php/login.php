<?php
session_start();
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);




if (isset($_POST['user_name']) && isset($_POST['password'])) {
    $user_name = $_POST['user_name'];
    $password = base64_encode($_POST['password']);
    // $password = $_POST['password'];

    $sql = "SELECT user_id, user_name FROM users WHERE user_name=? AND password=?";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("ss", $user_name, $password);
        $stmt->execute();
        $stmt->bind_result(
            $user_id,
            $user_name
        );
        while ($stmt->fetch()) {
            $user_id = $user_id;
            $user_name = $user_name;
        }
        if ($user_id == null) {
            $res = 'Wrong login or password';
        }else {
            $res = 'Successful';
        }
        
    }
}







echo (json_encode(array(
  'user_id' => $user_id,
  'user_name' => $user_name,
    'error'=> $res)));

$db_connect->close();
