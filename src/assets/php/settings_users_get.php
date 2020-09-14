<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$res = [];

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
    $res_0[] = array(
      'user_id' => (string) $user_id,
      'user_name' => (string) $user_name,
      'password' => (string) base64_decode($password),
      'first_name' => (string) $first_name,
      'last_name' => (string) $last_name,
      'user_role' => (string) $user_role
    );
  }
  $sql = "SELECT access_settings, list_tt_access, distribution_access FROM `users_settings_content`";
  if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
      $settings_access,
      $list_tt_access,
      $distribution_access
    );
    while ($stmt->fetch()) {
      $res_1[] = array(
        'access_settings' => (bool) $settings_access,
        'access_list_tt' => (bool) $list_tt_access,
        'access_distribution' => (bool) $distribution_access
      );
    }
  }
}
$res = array_merge($res_0,$res_1);


echo (json_encode($res));
