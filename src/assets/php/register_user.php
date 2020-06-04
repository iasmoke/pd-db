<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$user_form = $_POST['user_form'];
$user_name = $user_form['userName'];
$password = $user_form['password'];
$confirmPassword = $user_form['confirmPassword'];
$server_name = $user_form['serverName'];
$threads_user = $user_form['threads'];

$err = array();    

$sql = mysqli_query($db_connect, "SELECT user_id FROM users WHERE user_name='" . mysqli_real_escape_string($db_connect, $user_name) . "'");
if (mysqli_num_rows($sql) > 0) {
    $err['error'] = "A user with this login already exists in the database";
    echo (json_encode($err['error']));
    exit;
}


$password_encode = base64_encode($password);

if (count($err) == 0) {

    $err['error'] = "Registration successful";

    $sql = "INSERT INTO users (user_name, password) VALUES (?,?)";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("ss", $user_name, $password_encode);
        $stmt->execute();
    }
    $sql = "SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        $user_id = (int) $result['user_id'];
    }

    $sql = "SELECT target_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name, file, def_target FROM targets WHERE user_id=0";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result(
            $target_name,
            $parameter_name,
            $value_name,
            $start_value,
            $stop_value,
            $step_value,
            $type,
            $parameter_description,
            $file_name,
            $file,
            $def_target
        );
        while ($stmt->fetch()) {
            $targets[] = array(
                'target_name' => $target_name,
                'parameter_name' => $parameter_name,
                'value_name' => $value_name,
                'start_value' => $start_value,
                'stop_value' => $stop_value,
                'step_value' => $step_value,
                'type' => $type,
                'parameter_description' => $parameter_description,
                'file_name' => $user_id . "_" . $file_name,
                'file' => $file,
                'def_target' => $def_target

            );
        }
        foreach ($targets as $row_targets) {
            $sql = "INSERT INTO targets (user_id, target_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description,select_type, file_name,file,def_target) VALUES (?,?,?,?,?,?,?,?,?,0,?,?,?)";
            if ($stmt = $db_connect->prepare($sql)) {
                $stmt->bind_param(
                    "isssdddssssi",
                    $user_id,
                    $row_targets['target_name'],
                    $row_targets['parameter_name'],
                    $row_targets['value_name'],
                    $row_targets['start_value'],
                    $row_targets['stop_value'],
                    $row_targets['step_value'],
                    $row_targets['type'],
                    $row_targets['parameter_description'],
                    $row_targets['file_name'],
                    $row_targets['file'],
                    $row_targets['def_target']
                );
                $stmt->execute();
            }
        }
    }
    $sql = "SELECT feature_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name, file, def_feature FROM features WHERE user_id=0";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result(
            $feature_name,
            $parameter_name,
            $value_name,
            $start_value,
            $stop_value,
            $step_value,
            $type,
            $parameter_description,
            $file_name,
            $file,
            $def_feature
        );
        while ($stmt->fetch()) {
            $features[] = array(
                'feature_name' => $feature_name,
                'parameter_name' => $parameter_name,
                'value_name' => $value_name,
                'start_value' => $start_value,
                'stop_value' => $stop_value,
                'step_value' => $step_value,
                'type' => $type,
                'parameter_description' => $parameter_description,
                'file_name' => $user_id . "_" . $file_name,
                'file' => $file,
                'def_feature' => $def_feature

            );
        }
        foreach ($features as $row_features) {
            $sql = "INSERT INTO features (user_id, feature_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name, file, def_feature) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            if ($stmt = $db_connect->prepare($sql)) {
                $stmt->bind_param(
                    "isssdddssssi",
                    $user_id,
                    $row_features['feature_name'],
                    $row_features['parameter_name'],
                    $row_features['value_name'],
                    $row_features['start_value'],
                    $row_features['stop_value'],
                    $row_features['step_value'],
                    $row_features['type'],
                    $row_features['parameter_description'],
                    $row_features['file_name'],
                    $row_features['file'],
                    $row_features['def_feature']
                );
                $stmt->execute();
            }
        }
    }
    $sql = "SELECT parameter_name, parameter_value, parameter_type  FROM `trading_settings` WHERE user_id=0";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result(
            $parameter_name,
            $parameter_value,
            $parameter_type
        );
        while ($stmt->fetch()) {
            $trading_settings[] = array(
                'parameter_name' => $parameter_name,
                'parameter_value' => $parameter_value,
                'parameter_type' => $parameter_type,
            );
        }
        foreach ($trading_settings as $row_trading_settings) {
            $sql = "INSERT INTO trading_settings (user_id,parameter_name, parameter_value, parameter_type) VALUES (?,?,?,?)";
            if ($stmt = $db_connect->prepare($sql)) {
                $stmt->bind_param("isss", $user_id, $row_trading_settings['parameter_name'], $row_trading_settings['parameter_value'], $row_trading_settings['parameter_type']);
                $stmt->execute();
            }
        }
    }
    // $sql = "SELECT data_type, timeframe_type, ticker, timeframe  FROM `markets` WHERE user_id=1";
    // if ($stmt = $db_connect->prepare($sql)) {
    //     $stmt->execute();
    //     $stmt->bind_result(
    //         $data_type,
    //         $timeframe_type,
    //         $ticker,
    //         $timeframe
    //     );
    //     while ($stmt->fetch()) {
    //         $markets[] = array(
    //             'data_type' => $data_type,
    //             'timeframe_type' => $timeframe_type,
    //             'ticker' => $ticker,
    //             'timeframe' => $timeframe
    //         );
    //     }
    // foreach ($markets as $row_markets) {
    $sql = "INSERT INTO markets (user_id) VALUES (?)";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }
    //     }
    // }
    $sql = "SELECT parameter_name, value_name, value, description, type  FROM `trading_logics_settings` WHERE user_id=0";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result(
            $parameter_name,
            $value_name,
            $value,
            $description,
            $type
        );
        while ($stmt->fetch()) {
            $trading_logics_settings[] = array(
                'parameter_name' => $parameter_name,
                'value_name' => $value_name,
                'value' => $value,
                'description' => $description,
                'type' => $type
            );
        }
        foreach ($trading_logics_settings as $row_trading_logics_settings) {
            $sql = "INSERT INTO trading_logics_settings (user_id,parameter_name, value_name, value, description, type) VALUES (?,?,?,?,?,?)";
            if ($stmt = $db_connect->prepare($sql)) {
                $stmt->bind_param(
                    "iisdss",
                    $user_id,
                    $row_trading_logics_settings['parameter_name'],
                    $row_trading_logics_settings['value_name'],
                    $row_trading_logics_settings['value'],
                    $row_trading_logics_settings['description'],
                    $row_trading_logics_settings['type']
                );
                $stmt->execute();
            }
        }
    }
    $sql = "INSERT INTO spread (user_id,spread_from,spread_to,spread_value) VALUES (?,0,0,0)";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    $sql = "INSERT INTO users_settings (user_id, server, user_status_research, log_error, progress_status) VALUES (?,?,0,'-','-')";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("is", $user_id, $server_name);
        $stmt->execute();
    }

    $sql = "UPDATE trading_settings SET parameter_value=? WHERE user_id=? AND parameter_name='threads'";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("ii",$threads_user, $user_id);
        $stmt->execute();
    }

}



echo (json_encode($err['error']));

$db_connect->close();
