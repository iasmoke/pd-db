<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$spread_name = $_POST['spread_name'];



$sql = "DELETE FROM spread WHERE user_id=? AND spread_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ii", $user_id, $spread_name);
    $stmt->execute();
};
$sql = "SELECT * FROM spread WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result(
    $user_id,
    $spread_name,
    $spread_from,
    $spread_to,
    $spread_value
  );
  while ($stmt->fetch()) {
    $res[] = array(
      'user_id' => $user_id,
      'spread_name' => $spread_name,
      'spread_from' => $spread_from,
      'spread_to' => $spread_to,
      'spread_value' => $spread_value
    );
  }
} 

echo(json_encode($res));

$db_connect->close();