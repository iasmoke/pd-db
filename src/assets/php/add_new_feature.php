<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];
$file_name = $user_id."_".$_POST['file_name'];
$new_feature = $_POST['new_feature'];
$def_feature = (int) $_POST['def_feature'];

if ($def_feature === 1) {
    $user_id = 0;
    $file_name = $_POST['file_name'];
}
$file_py = $_POST['file_py'];
$file_code = stristr($file_py,','); 
$file_code = substr($file_code, 1);

if ($new_feature['feature_name'] === "") {
    $res = "Please, enter feature name";
    echo (json_encode($res));
    exit;
}
foreach ($new_feature['parameter'] as $row) {

    if ((($row === "") || ($row === null))) {
        $res = "Enter all feature parameters";
        echo (json_encode($res));
        exit;
    } else {
        $sql = "INSERT INTO features (user_id,feature_name,parameter_name,value_name,start_value,stop_value,step_value,type,parameter_description,file_name,file,def_feature) 
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        if ($stmt = $db_connect->prepare($sql)) {
            $stmt->bind_param(
                "isssdddssssi",
                $user_id,
                $new_feature['feature_name'],
                $row['parameter_name'],
                $row['variable_name'],
                $row['start_value'],
                $row['end_value'],
                $row['step_value'],
                $row['type'],
                $new_feature['description'],
                $file_name,
                $file_code,
                $def_feature
            );
            $stmt->execute();
            $res = "Feature added successfully";
        }
    }
}
echo (json_encode($res));
