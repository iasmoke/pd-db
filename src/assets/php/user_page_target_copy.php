<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$target_name = $_POST['target_name'];
$target_name_copy = $_POST['target_name_copy'];



$sql = "SELECT parameter_name, value_name, start_value, stop_value, step_value, parameter_description, type, file_name, file FROM targets WHERE user_id=? AND target_name=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("is", $user_id,$target_name);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_name,
        $value_name,
        $start_value,
        $stop_value,
        $step_value,
        $parameter_description,
        $type,
        $file_name,
        $file
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'parameter_name' => $parameter_name,
            'value_name' => $value_name,
            'start_value' => $start_value,
            'stop_value' => $stop_value,
            'step_value' => $step_value,
            'parameter_description' => $parameter_description,
            'type' => $type,
            'file_name' => $file_name,
            'file' => $file
        );
    }
}






foreach ($res as $row) {

    // $length = 3;
    // $characters = '0123456789';
    // $charactersLength = strlen($characters);
    // $randomString = '';
    // for ($i = 0; $i < $length; $i++) {
    //     $randomString .= $characters[rand(0, $charactersLength - 1)];
    // }

    // $target_copy = $target_name . "(copy)";

    $sql = "INSERT INTO targets (user_id,target_name,parameter_name,value_name,start_value,stop_value,step_value,type,parameter_description,select_type,file_name,file,def_target) 
    VALUES (?,?,?,?,?,?,?,?,?,0,?,?,0)";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param(
            "isssdddssss",
            $user_id,
            $target_name_copy,
            $row['parameter_name'],
            $row['value_name'],
            $row['start_value'],
            $row['stop_value'],
            $row['step_value'],
            $row['type'],
            $row['parameter_description'],
            $row['file_name'],
            $row['file']
        );
        $stmt->execute();
    }
}


$sql = "SELECT DISTINCT target_name FROM targets WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $target_name
    );
    while ($stmt->fetch()) {
        $target_name_res[] = $target_name;
    }
} 



$mess = "new target '".$target_name_copy."' done!";

echo (json_encode(array('target_list' => $target_name_res, 'mess'=> $mess)));

