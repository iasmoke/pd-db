<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);


$sql = "SELECT user_id, user_name, password, first_name, last_name, user_role FROM `users`";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->execute();
  $stmt->bind_result(
    $user_id,
    $user_name,
    $password,
    $first_name,
    $last_name,
    $user_role
  );
  while ($stmt->fetch()) {
    $res[] = array(
      'user_id' => (string) $user_id,
      'user_name' => (string) $user_name,
      'password' => (string) base64_decode($password),
      'first_name' => (string) $first_name,
      'last_name' => (string) $last_name,
      'user_role' => (string) $user_role
    );
  }
}


echo (json_encode($res));
