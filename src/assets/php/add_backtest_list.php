<?php

error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
// header("Cache-Control: no-cache");
// header("Content-Type: text/event-stream\n\n");

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$user_id = $_POST['user_id'];


$validLogic = array();



$sql = "SELECT backtest_id FROM backtests WHERE user_id=? AND backtest_status=0 ORDER BY `backtests`.`backtest_id` ASC";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $backtest_id
    );
    while ($stmt->fetch()) {
        $backtest_id_list[] = $backtest_id;
    }
}

$sql = "SELECT data_type, timeframe_type, ticker, source_type, timeframe FROM markets WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $res = $res->fetch_assoc();
    $settings['data'] = $res;
}
foreach ($settings as $row) {
    if ($row['timeframe_type'] === 'OHLC') {
    } else {
        $err = 'Run is only possible with a data time type equal to OHLC!';
        echo (json_encode(array(
            'backtest_list' => $backtest_id_list,
            'err' => $err
        )));
        return false;
    }
}



$sql = "SELECT target_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name FROM targets_set WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
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
        $file_name
    );
    while ($stmt->fetch()) {
        $targets[] = array(
            'target_name' =>  $target_name,
            'parameter_name' =>  $parameter_name,
            'value_name' => $value_name,
            'start_value' =>  $start_value,
            'stop_value' =>  $stop_value,
            'step_value'  => $step_value,
            'type' =>  $type,
            'parameter_description' =>  $parameter_description,
            'file_name' => $file_name
        );
    }
}


$settings['targets'] = $targets;




$sql = "SELECT feature_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name FROM features_set WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
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
        $file_name
    );
    while ($stmt->fetch()) {
        $features[] = array(
            'feature_name' =>  $feature_name,
            'parameter_name' =>  $parameter_name,
            'value_name' => $value_name,
            'start_value' =>  $start_value,
            'stop_value' =>  $stop_value,
            'step_value'  => $step_value,
            'type' =>  $type,
            'parameter_description' =>  $parameter_description,
            'file_name'  =>  $file_name
        );
    }
}

$settings['features'] = $features;


$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='start_date'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $start_date,
    );
    while ($stmt->fetch()) {
        $start_date = new DateTime($start_date);
    }
}


$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='end_date'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $end_date,
    );
    while ($stmt->fetch()) {
        $end_date = new DateTime($end_date);
    }
}
if ($end_date <= $start_date) {
    $err = 'The product quotation period was incorrectly selected: the end date of quotes should be strictly later than the start date of quotes.';
    echo (json_encode(array('err' => $err)));
    return false;
}

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='start_deposit'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $start_deposit
    );
    while ($stmt->fetch()) {
        if (filter_var($start_deposit, FILTER_VALIDATE_INT) === false) {
            $err = "Enter an integer 'Start deposit'!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($start_deposit > 1000000 || $start_deposit < 100) {
            $err = "Start deposit - does not match range!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($start_deposit === null) {
            $err = "Start deposit - is empty, enter the values!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
    }
}
$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='min_trade_quantity'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $min_trade_quantity
    );
    while ($stmt->fetch()) {
        if (filter_var($min_trade_quantity, FILTER_VALIDATE_INT) === false) {
            $err = "Enter an integer 'Min trade quantity value filter'!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($min_trade_quantity > 5000 || $min_trade_quantity < 1) {
            $err = "Min trade quantity value filter - does not match range!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($min_trade_quantity === null) {
            $err = "Min trade quantity value filter - is empty, enter the values!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
    }
}
$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='volume_per_lot'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $volume_per_lot
    );
    while ($stmt->fetch()) {
        if (filter_var($volume_per_lot, FILTER_VALIDATE_INT) === false) {
            $err = "Enter an integer 'Volume per lot'!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($volume_per_lot > 1000000 || $volume_per_lot < 1) {
            $err = "Volume per lot - does not match range!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($volume_per_lot === null) {
            $err = "Volume per lot - is empty, enter the values!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
    }
}
$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='commission_per_lot'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $commission_per_lot
    );
    while ($stmt->fetch()) {
        if ($commission_per_lot > 1000.0 || $commission_per_lot < 0) {
            $err = "Commission per lot - does not match range!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($commission_per_lot === null) {
            $err = "Commission per lot - is empty, enter the values!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
    }
}
$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='min_pf_to_filter'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $min_pf_to_filter
    );
    while ($stmt->fetch()) {
        if ($min_pf_to_filter > 100.0 || $min_pf_to_filter < 0) {
            $err = "Min trade quantity value filter - does not match range!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($min_pf_to_filter === null) {
            $err = "Min trade quantity value filter - is empty, enter the values!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
    }
}

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='periods_number'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $periods_number
    );
    while ($stmt->fetch()) {
        if (filter_var($periods_number, FILTER_VALIDATE_INT) === false) {
            $err = "Enter an integer 'Data split periods number'!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($periods_number > 100 || $periods_number < 2) {
            $err = "Data split periods number - does not match range!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($periods_number === null) {
            $err = "Data split periods number - is empty, enter the values!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
    }
}

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='max_dd_filter'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $max_dd_filter
    );
    while ($stmt->fetch()) {
        if (filter_var($max_dd_filter, FILTER_VALIDATE_INT) === false) {
            $err = "Enter an integer 'Max DD filter'!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($max_dd_filter > 100 || $max_dd_filter < 1) {
            $err = "Max DD filter - does not match range!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
        if ($max_dd_filter === null) {
            $err = "Max DD filter - is empty, enter the values!";
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
    }
}

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='use_vola_filter'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_value
    );
    while ($stmt->fetch()) {

        $filter_vola = (int) filter_var($parameter_value, FILTER_VALIDATE_BOOLEAN);
    }
}


if ($filter_vola === 1) {
    $sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='window_atr'";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result(
            $window_atr
        );
        while ($stmt->fetch()) {
            if (filter_var($window_atr, FILTER_VALIDATE_INT) === false) {
                $err = "Enter an integer 'Window atr'!";
                echo (json_encode(array(
                    'backtest_list' => $backtest_id_list,
                    'err' => $err
                )));
                return false;
            }
            if ($window_atr > 5000 || $window_atr < 1) {
                $err = "Window atr - does not match range!";
                echo (json_encode(array(
                    'backtest_list' => $backtest_id_list,
                    'err' => $err
                )));
                return false;
            }
            if ($window_atr === null) {
                $err = "Window atr - is empty, enter the values!";
                echo (json_encode(array(
                    'backtest_list' => $backtest_id_list,
                    'err' => $err
                )));
                return false;
            }
        }
    }
    $sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='window_decil'";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result(
            $window_decil
        );
        while ($stmt->fetch()) {
            if (filter_var($window_decil, FILTER_VALIDATE_INT) === false) {
                $err = "Enter an integer 'Window decil'!";
                echo (json_encode(array(
                    'backtest_list' => $backtest_id_list,
                    'err' => $err
                )));
                return false;
            }
            if ($window_decil > 5000 || $window_decil < 1) {
                $err = "Window decil - does not match range!";
                echo (json_encode(array(
                    'backtest_list' => $backtest_id_list,
                    'err' => $err
                )));
                return false;
            }
            if ($window_decil === null) {
                $err = "Window decil - is empty, enter the values!";
                echo (json_encode(array(
                    'backtest_list' => $backtest_id_list,
                    'err' => $err
                )));
                return false;
            }
        }
    }
    $sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='vola_filter_value'";
    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result(
            $vola_filter_value
        );
        while ($stmt->fetch()) {
            if (filter_var($vola_filter_value, FILTER_VALIDATE_INT) === false) {
                $err = "Enter an integer 'Vola filter value'!";
                echo (json_encode(array(
                    'backtest_list' => $backtest_id_list,
                    'err' => $err
                )));
                return false;
            }
            if ($vola_filter_value > 11 || $vola_filter_value < 0) {
                $err = "Vola filter value - does not match range!";
                echo (json_encode(array(
                    'backtest_list' => $backtest_id_list,
                    'err' => $err
                )));
                return false;
            }
            if ($vola_filter_value === null) {
                $err = "Vola filter value - is empty, enter the values!";
                echo (json_encode(array(
                    'backtest_list' => $backtest_id_list,
                    'err' => $err
                )));
                return false;
            }
        }
    }
}



$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='use_time_filter'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_value
    );
    while ($stmt->fetch()) {

        $filter_time = (int) filter_var($parameter_value, FILTER_VALIDATE_BOOLEAN);
    }
}


$os = array('resample_timeframe');
$vola = array('window_atr', 'window_decil', 'vola_filter_value', 'vola_filter_side');

$sql = "SELECT parameter_name, parameter_value, parameter_type FROM trading_settings WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_name,
        $parameter_value,
        $parameter_type
    );
    while ($stmt->fetch()) {
        if (($filter_time || !in_array($parameter_name, $os)) && ($filter_vola || !in_array($parameter_name, $vola))) {
            $trading_settings[] = array(
                'parameter_name' => $parameter_name,
                'parameter_value' => $parameter_value,
                'parameter_type' => $parameter_type
            );
        }
    }
}


$settings_logic_1 = array('1');

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='system_to_use_1'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_value
    );
    while ($stmt->fetch()) {

        $filter_system_logic_1 = (int) filter_var($parameter_value, FILTER_VALIDATE_BOOLEAN);
        if ($filter_system_logic_1 === 1) {
            $settings['trading_logic'][1] = array();
        }
        if ($filter_system_logic_1 === 1) {
            $validLogic[] = $filter_system_logic_1;
        }
    }
}


$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='system_to_use_2'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_value
    );
    while ($stmt->fetch()) {

        $filter_system_logic_2 = (int) filter_var($parameter_value, FILTER_VALIDATE_BOOLEAN);
        if ($filter_system_logic_2 === 1) {
            $validLogic[] = $filter_system_logic_2;
        }
    }
}

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='system_to_use_3'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_value
    );
    while ($stmt->fetch()) {

        $filter_system_logic_3 = (int) filter_var($parameter_value, FILTER_VALIDATE_BOOLEAN);
        if ($filter_system_logic_3 === 1) {
            $validLogic[] = $filter_system_logic_3;
        }
    }
}

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='system_to_use_4'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_value
    );
    while ($stmt->fetch()) {

        $filter_system_logic_4 = (int) filter_var($parameter_value, FILTER_VALIDATE_BOOLEAN);
        if ($filter_system_logic_4 === 1) {
            $validLogic[] = $filter_system_logic_4;
        }
    }
}

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='system_to_use_5'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_value
    );
    while ($stmt->fetch()) {

        $filter_system_logic_5 = (int) filter_var($parameter_value, FILTER_VALIDATE_BOOLEAN);
        if ($filter_system_logic_5 === 1) {
            $validLogic[] = $filter_system_logic_5;
        }
    }
}

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='system_to_use_6'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_value
    );
    while ($stmt->fetch()) {

        $filter_system_logic_6 = (int) filter_var($parameter_value, FILTER_VALIDATE_BOOLEAN);
        if ($filter_system_logic_6 === 1) {
            $validLogic[] = $filter_system_logic_6;
        }
    }
}

$sql = "SELECT parameter_value FROM trading_settings WHERE user_id=? and parameter_name='system_to_use_7'";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_value
    );
    while ($stmt->fetch()) {

        $filter_system_logic_7 = (int) filter_var($parameter_value, FILTER_VALIDATE_BOOLEAN);
        if ($filter_system_logic_7 === 1) {
            $validLogic[] = $filter_system_logic_7;
        }
    }
}

if ((bool) $validLogic === false) {
    $err = "Please choose any trading logic!";
    echo (json_encode(array(
        'backtest_list' => $backtest_id_list,
        'err' => $err
    )));
    return false;
}

$settings_logic_2 = array('2');
$settings_logic_3 = array('3');
$settings_logic_4 = array('4');
$settings_logic_5 = array('5');
$settings_logic_6 = array('6');
$settings_logic_7 = array('7');

$sql = "SELECT parameter_name, value_name, value, type FROM trading_logics_settings WHERE user_id=? AND parameter_name=2";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_name,
        $value_name,
        $value,
        $type
    );
    while ($stmt->fetch()) {
        if ($filter_system_logic_2 || !in_array($parameter_name, $settings_logic_2)) {
            $settings['trading_logic'][2][] = array(
                'parameter_name' => $value_name,
                'parameter_value' => $value,
                'parameter_type' =>  $type
            );
        }
    }
}

$sql = "SELECT parameter_name, value_name, value, type FROM trading_logics_settings WHERE user_id=? AND parameter_name=3";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_name,
        $value_name,
        $value,
        $type
    );
    while ($stmt->fetch()) {
        if ($filter_system_logic_3 || !in_array($parameter_name, $settings_logic_3)) {
            $settings['trading_logic'][3][] = array(
                'parameter_name' => $value_name,
                'parameter_value' => $value,
                'parameter_type' =>  $type
            );
        }
    }
}

$sql = "SELECT parameter_name, value_name, value, type FROM trading_logics_settings WHERE user_id=? AND parameter_name=4";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_name,
        $value_name,
        $value,
        $type
    );
    while ($stmt->fetch()) {
        if ($filter_system_logic_4 || !in_array($parameter_name, $settings_logic_4)) {
            $settings['trading_logic'][4][] = array(
                'parameter_name' => $value_name,
                'parameter_value' => $value,
                'parameter_type' =>  $type
            );
        }
    }
}

$sql = "SELECT parameter_name, value_name, value, type FROM trading_logics_settings WHERE user_id=? AND parameter_name=5";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_name,
        $value_name,
        $value,
        $type
    );
    while ($stmt->fetch()) {
        if ($filter_system_logic_5 || !in_array($parameter_name, $settings_logic_5)) {
            $settings['trading_logic'][5][] = array(
                'parameter_name' => $value_name,
                'parameter_value' => $value,
                'parameter_type' =>  $type
            );
        }
    }
}

$sql = "SELECT parameter_name, value_name, value, type FROM trading_logics_settings WHERE user_id=? AND parameter_name=6";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_name,
        $value_name,
        $value,
        $type
    );
    while ($stmt->fetch()) {
        if ($filter_system_logic_6 || !in_array($parameter_name, $settings_logic_6)) {
            $settings['trading_logic'][6][] = array(
                'parameter_name' => $value_name,
                'parameter_value' => $value,
                'parameter_type' =>  $type
            );
        }
    }
}
$sql = "SELECT parameter_name, value_name, value, type FROM trading_logics_settings WHERE user_id=? AND parameter_name=7";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $parameter_name,
        $value_name,
        $value,
        $type
    );
    while ($stmt->fetch()) {
        if ($filter_system_logic_7 || !in_array($parameter_name, $settings_logic_7)) {
            $settings['trading_logic'][7][] = array(
                'parameter_name' => $value_name,
                'parameter_value' => $value,
                'parameter_type' =>  $type
            );
        }
    }
}

$settings['trading_settings'] = $trading_settings;


$sql = "SELECT spread_from, spread_to, spread_value FROM spread WHERE user_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $spread_from,
        $spread_to,
        $spread_value
    );
    while ($stmt->fetch()) {
        $spreads[] = array(
            'spread_from' => $spread_from,
            'spread_to' => $spread_to,
            'spread_value' => $spread_value
        );
    }
}

if (count($spreads) > 1) {
    $array_merged = array();
    $array_of_arrays = array();
    foreach ($spreads as  $value) {
        $start = new DateTime($value['spread_from']);
        $interval = new DateInterval('PT1M');
        $end = new DateTime($value['spread_to']);
        $period = new DatePeriod($start, $interval, $end);
        $array = [];
        foreach ($period as $row) {
            $array_merged[] = $row->format('H:i:s');
            $array[] = $row->format('H:i:s');
        }
        $array_of_arrays[] = $array;
    }

    $flag = false;
    foreach ($array_of_arrays as $key1 => $array1) {
        foreach ($array_of_arrays as $key2 => $array2) {
            if ($key1 !== $key2) {
                $flag = sizeof(array_intersect($array1, $array2)) > 0;
            }
        }
    }
    $lol = array_intersect($array_merged, ...$array_of_arrays);
    // echo(json_encode(array('flag' => $flag)));
    if ($flag === true) {
        $err = 'Spread time intervals intersect. Check it out!';
        echo (json_encode(array(
            'backtest_list' => $backtest_id_list,
            'err' => $err
        )));
        return false;
    }
}
foreach ($spreads as $row_spred_value) {
    if ($row_spred_value['spread_value'] > 100.0000 || $row_spred_value['spread_value'] < 0) {
        $err = "Spread value - does not match range!";
        echo (json_encode(array(
            'backtest_list' => $backtest_id_list,
            'err' => $err
        )));
        return false;
    }
    if ($row_spred_value['spread_value'] === null) {
        $err = "Spread value - is empty, enter the values!";
        echo (json_encode(array(
            'backtest_list' => $backtest_id_list,
            'err' => $err
        )));
        return false;
    }
}


$settings['spread'] = $spreads;

$settings['info'] = date("d-M-Y | H:i:s");


foreach ($settings['data'] as $row) {
    if ($row !== '')
        if ($row === null) {

            $err = 'Filling in the data section';
            echo (json_encode(array(
                'backtest_list' => $backtest_id_list,
                'err' => $err
            )));
            return false;
        }
}

if ($settings['targets'] === null) {
    $err = 'You need to add a target or select it';
    echo (json_encode(
        array(
            'backtest_list' => $backtest_id_list,
            'err' => $err
        )
    ));
    return false;
}



$settings = json_encode($settings);

$sql = "INSERT INTO backtests (user_id, settings, description, select_type_oos, backtest_status, select_type_graphs ) VALUES (?,?,'main',0,0,0)";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("is", $user_id, $settings);
    $stmt->execute();
}

$sql = "SELECT backtest_id FROM backtests WHERE user_id=? AND backtest_status=0 ORDER BY `backtests`.`backtest_id` ASC";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result(
        $backtest_id
    );
    while ($stmt->fetch()) {
        $backtest_id_list[] = $backtest_id;
    }
    $err = "Backtest added";
}

echo (json_encode(array(
    'backtest_list' => $backtest_id_list,
    'err' => $err
)));
