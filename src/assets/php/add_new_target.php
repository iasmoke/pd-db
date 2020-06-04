<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$file_name = $user_id."_".$_POST['file_name'];
$new_target = $_POST['new_target'];
$def_target = (int) $_POST['def_target'];

if($def_target === 1){
    $user_id = 0;
    $file_name = $_POST['file_name'];
}
$file_py = $_POST['file_py'];
$file_code = stristr($file_py,','); 
$file_code = substr($file_code, 1);

    if ($new_target['target_name'] === "") {
        $res = "Please, enter target name";
        echo (json_encode($res));
        exit;
    }
    foreach ($new_target['parameter'] as $row) {
        if ((($row === "") || ($row === null))) {
            $res = "Enter all target parameters";
            echo (json_encode($res));
            exit;
        }
        if ((($row !== "") || ($row !== null))) {
            
            $sql = "INSERT INTO targets (user_id,target_name,parameter_name,value_name,start_value,stop_value,step_value,type,parameter_description,select_type,file_name,file,def_target) 
             VALUES (?,?,?,?,?,?,?,?,?,1,?,?,?)";
            if ($stmt = $db_connect->prepare($sql)) {
                $stmt->bind_param(
                    "isssdddssssi",
                    $user_id,
                    $new_target['target_name'],
                    $row['parameter_name'],
                    $row['variable_name'],
                    $row['start_value'],
                    $row['end_value'],
                    $row['step_value'],
                    $row['type'],
                    $new_target['description'],
                    $file_name,
                    $file_code,
                    $def_target
                );
                $stmt->execute();
                $res = "Target added successfully";
            }
        }
    }
echo (json_encode($res));

$db_connect->close();
