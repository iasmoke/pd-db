<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$group_name = $_POST['data_type'];
$tf_type = $_POST['timeframe_type'];
$value = $_POST['ticker'];
$tf = $_POST['timeframe'];
$source = $_POST['source'];

$res = array();




$sql = "SELECT `start_date`, end_date FROM data_table WHERE group_name=? AND source=? AND tf=? AND `value`=? AND tf_type=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("sssss", $group_name, $source, $tf, $value, $tf_type);
    $stmt->execute();
    $stmt->bind_result(
        $minDate,
        $maxDate
    );
    while ($stmt->fetch()) {
        $res = array(
            'minDate' => $minDate,
            'maxDate' => $maxDate
        ) ;
    }
}


echo (json_encode($res));


// $json = "{'function':'get_data_timeframe','data_type':'$data_type','time_type':'$timeframe_type','ticker':'$ticker','source':'$source'}";


// $command = "cd C:/wamp64/www/research_tool/assets/python/trading_script && python fill_data_parameters.py ".escapeshellarg($json);
// $data = `$command`;


// $res_py = preg_replace( "/\r|\n/", "", $data );
// $res = explode(', ' ,$res_py);


// echo (json_encode($res));

$db_connect->close();
