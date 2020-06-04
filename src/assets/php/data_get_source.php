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
$value= $_POST['ticker'];
$res = array();




$sql = "UPDATE markets SET ticker=? WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("si",$value, $user_id);
    $stmt->execute();
}

$sql = "SELECT DISTINCT source FROM data_table WHERE group_name=? AND tf_type=? AND `value`=?";
if($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("sss", $group_name, $tf_type, $value);
    $stmt->execute();
    $stmt->bind_result(
        $source
    );
    while ($stmt->fetch()) {
        $res[] =  $source;
        }
} else {
    $res[] = array('user_id', $db_connect->error);
}


echo (json_encode($res));


// $json = "{'function':'get_data_timeframe','data_type':'$data_type','time_type':'$timeframe_type','ticker':'$ticker','source':'$source'}";


// $command = "cd C:/wamp64/www/research_tool/assets/python/trading_script && python fill_data_parameters.py ".escapeshellarg($json);
// $data = `$command`;


// $res_py = preg_replace( "/\r|\n/", "", $data );
// $res = explode(', ' ,$res_py);


// echo (json_encode($res));

$db_connect->close();
