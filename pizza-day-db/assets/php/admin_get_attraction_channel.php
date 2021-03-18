<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$date = $_POST['date'];
$begin = date('Y-m-d', strtotime($date['date']['begin']));
$end = date('Y-m-d', strtotime($date['date']['end']));

switch ($date) {
    case null:
        $res = 'Неверные данные';
        echo (json_encode($res));
        break;
    default:
        $sql = "SELECT first_name,last_name,second_name,internship_date,attraction_channel,attraction_channel_description,employee_description FROM db_main WHERE internship_date BETWEEN ? AND ? AND attraction_channel='Рекомендация от третьих лиц'";
        if ($stmt = $db_connect->prepare($sql)) {
            $stmt->bind_param('ss', $begin, $end);
            $stmt->execute();
            $stmt->bind_result(
                $first_name,
                $last_name,
                $second_name,
                $internship_date,
                $attraction_channel,
                $attraction_channel_description,
                $employee_description
            );
            while ($stmt->fetch()) {
                $res[] = array(
                    'fio' =>  $last_name . " " . $first_name . " " . $second_name,
                    'internship_date' => $internship_date,
                    'attraction_channel' => (string) $attraction_channel,
                    'attraction_channel_description' => (string) $attraction_channel_description,
                    'employee_description' => (string) $employee_description,
                );
            }
        }
        echo (json_encode($res));
        break;
}
