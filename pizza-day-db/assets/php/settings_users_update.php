<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$users_array = $_POST['users_array'];
$user_id = $users_array['user_id'];
$first_name = $users_array['first_name'];
$last_name = $users_array['last_name'];
$user_name = $users_array['user_name'];
$password = $users_array['password'];
$user_role = $users_array['user_role'];
$access_list_tt = $users_array['access_list_tt'];
$access_distribution = $users_array['access_distribution'];
$access_report = $users_array['access_report'];
$access_tests = $users_array['access_tests'];
switch ($access_list_tt) {
  case '':
    $access_list_tt = 0;
  break;
}
switch ($access_tests) {
  case '':
    $access_tests = 0;
  break;
}
switch ($access_distribution) {
  case '':
    $access_distribution = 0;
  break;
}
switch ($access_report) {
  case '':
    $access_report = 0;
  break;
}





$sql = "UPDATE users SET first_name=?, last_name=?, user_name=?, password=?, user_role=? WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ssssss", $first_name, $last_name, $user_name, base64_encode($password), $user_role, $user_id);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
  } else {
    return $res = $stmt->error_list;
  }
  $sql = "UPDATE users_settings_content SET access_list_tt=?, access_distribution=?, access_report=?,access_tests=?  WHERE user_id=?";
  if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("sssss", $access_list_tt, $access_distribution, $access_report, $access_tests, $user_id);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
}
}

echo (json_encode($res));
