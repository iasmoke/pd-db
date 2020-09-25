<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$main_page= (int) $_POST['main_page'];
$settings_page= (int) $_POST['settings_page'];
$list_tt_page= (int) $_POST['list_tt_page'];
$distribution_page= (int) $_POST['distribution_page'];
$report_page = (int) $_POST['report_page'];



$sql = "UPDATE users_settings_content SET main_page=?, settings_page=?, list_tt_page=?, distribution_page=?, report_page=? WHERE `user_id`=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("iiiiis", $main_page, $settings_page, $list_tt_page, $distribution_page,$report_page, $user_id);
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    $res = 'Данные обновлены';
  } else {
    $res = $stmt->error_list;
  }
}

echo (json_encode($res));
