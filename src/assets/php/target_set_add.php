<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$target_name = $_POST['target_name'];

$sql = "UPDATE targets SET select_type=0 WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}
$sql = "UPDATE targets SET select_type=1 WHERE user_id=? AND target_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("is", $user_id, $target_name);
    $stmt->execute();
    }    

$sql ="DELETE FROM targets_set WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

$sql = "INSERT INTO targets_set (user_id, target_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name,file)
SELECT user_id, target_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name,file FROM targets WHERE user_id=? AND target_name=?;";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ss", $user_id, $target_name);
    $stmt->execute();
}



// $sql ="SELECT parameter_name, value_name, start_value, stop_value, step_value, type, file_name, file FROM targets_set WHERE user_id=? AND target_name=?";
// if($stmt = $db_connect->prepare($sql)){
//     $stmt->bind_param("is", $user_id, $target_name);
//     $stmt->execute();
//     $stmt->bind_result(
//         $parameter_name, 
//         $value_name, 
//         $start_value, 
//         $stop_value, 
//         $step_value,
//         $type,
//         $file_name,
//         $file
//     );
//     while ($stmt->fetch()) {
//         $res[] = array(
//           'parameter_name' => $parameter_name,
//           'value_name' => $value_name,
//           'start_value' => $start_value,
//           'stop_value' => $stop_value,
//           'step_value' => $step_value,
//           'type' => $type,
//           'file_name' => $file_name,
//           'file' => $file
//         );
//       }
// }


// echo (json_encode(array(
//     'res' => $res,
//     'file' => $file
// )));

$db_connect->close();
