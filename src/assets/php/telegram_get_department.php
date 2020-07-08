<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);
$city = $_POST['city'];

$res = [];
if (count($city) > 1) {
  foreach ($city as $value) {
    $sql = "SELECT id_tt, city, adress FROM `list_tt` WHERE city=?";
    if ($stmt = $db_connect->prepare($sql)) {
      $stmt->bind_param("s", $value);
      $stmt->execute();
      $stmt->bind_result(
        $id_tt,
        $city,
        $adress
      );
      while ($stmt->fetch()) {
        $res[] = array(
          'id_tt' => $id_tt,
          'city' => $city,
          'adress' => $adress
        );
      }
    }
  }
 
} elseif (count($city) <= 1) {
  $sql = "SELECT id_tt, city, adress FROM `list_tt` WHERE city=?";
  if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("s", $city[0]);
    $stmt->execute();
    $stmt->bind_result(
      $id_tt,
      $city,
      $adress
    );
    while ($stmt->fetch()) {
      $res[] = array(
        'id_tt' => $id_tt,
        'city' => $city,
        'adress' => $adress
      );
    }
  }
}
echo (json_encode($res));