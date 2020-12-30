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

    $sql = "SELECT user_id, user_name, user_role FROM users WHERE user_name=? AND password=?";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("ss", $user_name, $password);
        $stmt->execute();
        $stmt->bind_result(
            $user_id,
            $user_name,
            $user_role
        );
        while ($stmt->fetch()) {
            $user_id = $user_id;
            $user_name = $user_name;
            $user_role = $user_role;
        }
        if ($user_id == null) {
            $res = 'Логин или пароль не верный';
        } else {
            $res = 'Successful';
            $sql = "UPDATE users_settings_content SET main_page=1, settings_page=0, list_tt_page=0, distribution_page=0, report_page=0, tests_page=0 WHERE `user_id`=?";
            if ($stmt = $db_connect->prepare($sql)) {
              $stmt->bind_param("s", $user_id);
              $stmt->execute();
              if (count($stmt->error_list) === 0) {
              } else {
                $res = $stmt->error_list;
              }
            }
        }
    }
}


echo (json_encode(array(
    'user_id' => $user_id,
    'user_name' => $user_name,
    'user_role' => $user_role,
    'error' => $res
)));

$db_connect->close();
