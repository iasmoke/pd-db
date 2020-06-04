<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);




// $json = "{'function':'get_data_type'}";

// $command = "cd C:/wamp64/www/research_tool/assets/python/trading_script && python fill_data_parameters.py ".escapeshellarg($json);
// $data = `$command`;

// $res_py = preg_replace( "/\r|\n/", "", $data );
// $res = explode(', ' ,$res_py);


// $user_id = $_POST['user_id'];
$res = array();


$sql = "SELECT DISTINCT group_name FROM data_table";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result(
        $group_name
    );
    while ($stmt->fetch()) {
        $res[] = $group_name;
    }
}


echo (json_encode($res));
