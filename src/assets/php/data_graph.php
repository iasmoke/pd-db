<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);


$user_id = $_POST['user_id'];
$group_name = $_POST['data_type'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$value = $_POST['ticker'];
$tf = $_POST['timeframe'];
$source = $_POST['source'];

$json = "{'data_type':'".$group_name."','ticker':'".$value."','source_type': '".$source."','timeframe':'".$tf."','start_date':'".$start_date."','end_date':'".$end_date."','user_id':".$user_id."}";


     
   $command = "cd C:/wamp64/www/research_tool/assets/python/trading_script && python get_data_for_product_graph.py " . escapeshellarg($json);
   $data = `$command`;

$sql = "SELECT `date`, `open`, high, low, `close` FROM product_graph WHERE user_id=? ORDER BY `product_graph`.`date` ASC";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $date,
        $open,
        $high,
        $low,
        $close
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'date' => $date,
            'open' => $open,
            'high' => $high,
            'low' => $low,
            'close' => $close
        ) ;
    }
}


echo (json_encode($res));




