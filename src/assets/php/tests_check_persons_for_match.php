<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$list_person = $_POST['list_person'];
$name_test = $_POST['name_test'];


$result = [];

foreach($list_person as $value) {

  $sql = "SELECT id_person FROM test_personnel WHERE id_person=? AND name_test=?";
  if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param('ss', $value['id_person'], $name_test);
    $stmt->execute();
    $stmt->bind_result(
      $id_person
    );
    while ($stmt->fetch()) {
      $result[] =  $id_person;

    }
    if (count($result) === 0) {
    } else {
      echo(json_encode($res =  $value['fi'] . ' уже сдал(ла) тест ' . '@'. $name_test .' !' , JSON_UNESCAPED_UNICODE));
      return ;
    }
  }
}

$res = 'done';

echo(json_encode($res));
