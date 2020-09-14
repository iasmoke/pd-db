<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$user_name = $_POST['user_name'];
$password = $_POST['password'];
$user_role = $_POST['user_role'];
// $settings_access = $_POST[]
// $list_tt_access
// $distribution_access





$sql = "UPDATE users SET first_name=?, last_name=?, user_name=?, password=?, user_role=? WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ssssss",$first_name, $last_name, $user_name, base64_encode($password), $user_role, $user_id);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
  $sql = "UPDATE users_settings_content SET faccess_settings=?, list_tt_access=?, distribution_access=?  WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("ssss", $settings_access, $list_tt_access, $distribution_access, $user_id);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
}
}

echo (json_encode($res));
