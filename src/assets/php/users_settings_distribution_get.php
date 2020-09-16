<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];

$sql = "SELECT * FROM users_settings_content WHERE `user_id`=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt-> bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $user_id,
        $main_page,
        $settings_page,
        $list_tt_page,
        $list_tt_access,
        $distribution_page,
        $distribution_access
    );
    while ($stmt->fetch()) {
        $res[] = array(
            'main_page' => (bool) $main_page,
            'settings_page' => (bool) $settings_page,
            'list_tt_page' => (bool) $list_tt_page,
            'access_list_tt' => (bool) $list_tt_access,
            'distribution_page' => (bool) $distribution_page,
            'access_distribution' => (bool) $distribution_access
        );
    }
}


echo (json_encode($res));
    // $res = $stmt->get_result();
    // $res = $res->fetch_assoc();