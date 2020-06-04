<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$user_id = $_POST['user_id'];
$group_name = $_POST['data_type'];
$tf_type = $_POST['timeframe_type'];
$res = array();



$sql = "UPDATE markets SET timeframe_type=? WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("si",$tf_type, $user_id);
    $stmt->execute();
}

$sql = "SELECT DISTINCT `value` FROM data_table WHERE group_name=? AND tf_type=?";
if($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ss",$group_name, $tf_type);
    $stmt->execute();
    $stmt->bind_result(
        $value
    );
    while ($stmt->fetch()) {
        $res[] = $value;
     }
} else {
    $res[] = array('user_id', $db_connect->error);
}


echo (json_encode($res));




// $json = "{'function':'get_ticker','data_type':'$data_type','time_type':'$timeframe_type'}";


// $command = "cd C:/wamp64/www/research_tool/assets/python/trading_script && python fill_data_parameters.py ".escapeshellarg($json);
// $data = `$command`;


// $res_py = preg_replace( "/\r|\n/", "", $data );
// $res = explode(', ' ,$res_py);



// echo (json_encode($res));

$db_connect->close();
