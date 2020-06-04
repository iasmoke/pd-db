<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


// $_POST = json_decode(file_get_contents('php://input'), true);
$name = $_POST['name'];
$user_id = $_POST['user_id'];


$file = $_FILES['file'];
echo($file);
// if($_FILES['file']){
//     $path = 'targets/';
//     if (!file_exists($path)) {
//         mkdir($path, 0777, true);
//     }
//     $originalName = $_FILES['file']['name'];
//     $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
//     $t=time();
//     $generatedName = $user_id.'_'.$originalName;
//     $filePath = $path. $generatedName;
//     if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
//         echo json_encode(array(
//             'result' => 'success',
//             'status' => true,
//             'user_id' => (int) $user_id,
//             'name' => $generatedName
//         ));
//     }
// }
