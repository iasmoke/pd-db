<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];



$sql = "SELECT data_type, timeframe_type, ticker, source_type ,timeframe FROM markets WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $data_type,
        $timeframe_type,
        $ticker,
        $source_type,
        $timeframe
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'data_type' => $data_type,
            'timeframe_type' => $timeframe_type,
            'ticker' => $ticker,
            'source' => $source_type,
            'timeframe' => $timeframe
        );
    }
    // if (count($res) > 1) {
    //     $data_type = null;
    // } else {
    //     $data_type = $res[0]['data_type'];
    // }
}


// $sql = "SELECT DISTINCT timeframe_type FROM markets WHERE user_id=? AND select_type=1";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
//     $stmt->bind_result(
//         $timeframe_type
//     );
//     while ($stmt->fetch()) {
//         $res[] = array(
//             'timeframe_type' => $timeframe_type
//         );
//     }
//     if (count($res) > 1) {
//         $timeframe_type = null;
//     } else {
//         $timeframe_type = $res[0]['timeframe_type'];
//     }
// }

// $res = array();

// $sql = "SELECT DISTINCT ticker FROM markets WHERE user_id=? AND select_type=1";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
//     $stmt->bind_result(
//         $ticker
//     );
//     while ($stmt->fetch()) {
//         $res[] = array(
//             'ticker' => $ticker
//         );
//     }
//     if (count($res) > 1) {
//         $ticker = null;
//     } else {
//         $ticker = $res[0]['ticker'];
//     }
// }

// $res = array();

// $sql = "SELECT DISTINCT timeframe FROM markets WHERE user_id=? AND select_type=1";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
//     $stmt->bind_result(
//         $timeframe
//     );
//     while ($stmt->fetch()) {
//         $res[] = array(
//             'timeframe' => $timeframe
//         );
//     }
//     if (count($res) > 1) {
//         $timeframe = null;
//     } else {
//         $timeframe = $res[0]['timeframe'];
//     }
// }

// $sql = "SELECT DISTINCT data_type FROM data WHERE user_id=? AND select_type=1";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
//     $stmt->bind_result(
//         $user_id,
//         $data_type,
//         $timeframe_type,
//         $ticker,
//         $timeframe,
//         $select_type
//     );
//     while ($stmt->fetch()) {
//         $res[] = array(
//             'user_id' => $user_id,
//             'data_type' => $data_type,
//             'timeframe_type' => $timeframe_type,
//             'ticker' => $ticker,
//             'timeframe' => $timeframe,
//             'select_type' => $select_type
//         );
//     }
// }

echo (json_encode($res));


