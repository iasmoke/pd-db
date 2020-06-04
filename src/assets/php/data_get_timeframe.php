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
$value = $_POST['ticker'];
$source = $_POST['source'];
$res = array();



$sql = "UPDATE markets SET source_type=? WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("si",$source, $user_id);
    $stmt->execute();  
}

$sql = "SELECT DISTINCT tf FROM data_table WHERE group_name=? AND tf_type=? AND `value`=? AND source=? and tf='price_1m'";
if($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ssss", $group_name,$tf_type,$value,$source);
    $stmt->execute();
    $stmt->bind_result(
        $price_1m
    );
    while ($stmt->fetch()) {
        $res['price_1m'] = $price_1m;
    }
} 
$sql = "SELECT DISTINCT tf FROM data_table WHERE group_name=? AND tf_type=? AND `value`=? AND source=? and tf='price_5m'";
if($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ssss", $group_name,$tf_type,$value,$source);
    $stmt->execute();
    $stmt->bind_result(
        $price_5m
    );
    while ($stmt->fetch()) {
        $res['price_5m'] = $price_5m;
    }
}
$sql = "SELECT DISTINCT tf FROM data_table WHERE group_name=? AND tf_type=? AND `value`=? AND source=? and tf='price_15m'";
if($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ssss", $group_name,$tf_type,$value,$source);
    $stmt->execute();
    $stmt->bind_result(
        $price_15m
    );
    while ($stmt->fetch()) {
        $res['price_15m'] = $price_15m;
    }
}
$sql = "SELECT DISTINCT tf FROM data_table WHERE group_name=? AND tf_type=? AND `value`=? AND source=? and tf='price_30m'";
if($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ssss", $group_name,$tf_type,$value,$source);
    $stmt->execute();
    $stmt->bind_result(
        $price_30m
    );
    while ($stmt->fetch()) {
        $res['price_30m'] = $price_30m;
    }
}
$sql = "SELECT DISTINCT tf FROM data_table WHERE group_name=? AND tf_type=? AND `value`=? AND source=? and tf='price_1h'";
if($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ssss", $group_name,$tf_type,$value,$source);
    $stmt->execute();
    $stmt->bind_result(
        $price_1h
    );
    while ($stmt->fetch()) {
        $res['price_1h'] = $price_1h;
    }
}
$sql = "SELECT DISTINCT tf FROM data_table WHERE group_name=? AND tf_type=? AND `value`=? AND source=? and tf='price_1d'";
if($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("ssss", $group_name,$tf_type,$value,$source);
    $stmt->execute();
    $stmt->bind_result(
        $price_1d
    );
    while ($stmt->fetch()) {
        $res['price_1d'] = $price_1d;
    }
}
$list_sort[0] = $res['price_1m'];
$list_sort[1] = $res['price_5m'];
$list_sort[2] = $res['price_15m'];
$list_sort[3] = $res['price_30m'];
$list_sort[4] = $res['price_1h'];
$list_sort[5] = $res['price_1d'];

echo (json_encode($list_sort));

// $json = "{'function':'get_sourses','data_type':'$data_type','time_type':'$timeframe_type','ticker':'$ticker'}";


// $command = "cd C:/wamp64/www/research_tool/assets/python/trading_script && python fill_data_parameters.py ".escapeshellarg($json);
// $data = `$command`;


// $res_py = preg_replace( "/\r|\n/", "", $data );
// $res = explode(', ' ,$res_py);




// echo (json_encode($res));

$db_connect->close();
