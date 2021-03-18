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
    $res_1[] = array(
      'user_id' => (string) $user_id,
      'user_name' => (string) $user_name,
      'password' => (string) base64_decode($password),
      'first_name' => (string) $first_name,
      'last_name' => (string) $last_name,
      'user_role' => (string) $user_role
    );
  }
  $sql = "SELECT access_list_tt, access_distribution, access_report,access_tests FROM `users_settings_content`";
  if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
      $access_list_tt,
      $access_distribution,
      $access_report,
      $access_tests
    );
    while ($stmt->fetch()) {
      $res_2[] = array(
        'access_list_tt' => (bool) $access_list_tt,
        'access_distribution' => (bool) $access_distribution,
        'access_report' => (bool) $access_report,
        'access_tests' => (bool) $access_tests
      );
    }
  }
}
$res = array_replace_recursive($res_1,$res_2);


echo (json_encode($res));
