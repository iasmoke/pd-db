<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$selected = $_POST['selected'];
$user_id = $_POST['user_id'];


$sql = "DELETE FROM table_to_send";
if ($stmt = $db_connect->prepare($sql)) {
  $stmt->execute();
  if (count($stmt->error_list) === 0) {
    foreach ($selected as $value) {
      $sql = "INSERT INTO table_to_send (user_id,id_telegram,fi,department) VALUES (?,?,?,?)";
      if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param(
          "iiss",
          $user_id,
          $value['id_telegram'],
          $value['fi'],
          $value['department']
        );
        $stmt->execute();
        if (count($stmt->error_list) === 0) {
          $res = [];
          $sql = "SELECT fi, department FROM table_to_send WHERE user_id=?";
          if ($stmt = $db_connect->prepare($sql)) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->bind_result(
              $fi,
              $department
            );
            while ($stmt->fetch()) {
              $res[] = array(
                'fi' => $fi,
                'department' => $department
              );
            }
          }
        } else {
          return $res = $stmt->error_list;
        }
      }
    }
  }
} else {
  return $res = $stmt->error_list;
}



echo (json_encode($res));
