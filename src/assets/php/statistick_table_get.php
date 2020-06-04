<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");

require_once('connect_db.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$backtest_id = $_POST['backtest_id'];




$sql = "SELECT `code`, `period`, `trading_logic`, `reverse_logic`, `pf`, `side`, `total_profit`, 
`average_profit`, `average_loss`, `probability_profit`, `probability_loss`, `quantity_of_trades`, 
`std`, `max_dd`, `time_filter`, `vola_filter`, `start_time`, `end_time`, `atr_window`, `decil_window`, 
`vola_filter_side`, `vola_filter_value`, `take_profit`, `stop_loss`, `middle_line_window`, `new_volume`, 
`step_size`, `step_quantity`, `hard_stop_loss`, `zero_line` ,`candles`
FROM `outofsample_portfolios` 
WHERE backtest_id=?";
if ($stmt = $db_connect->prepare($sql)) {
    $stmt->bind_param("i", $backtest_id);
    $stmt->execute();
    $stmt->bind_result(
        $code,
        $period,
        $trading_logic,
        $reverse_logic,
        $pf,
        $side,
        $total_profit,
        $average_profit,
        $average_loss,
        $probability_profit,
        $probability_loss,
        $quantity_of_trades,
        $std,$max_dd,$time_filter,
        $vola_filter,$start_time,
        $end_time,$atr_window,
        $decil_window,$vola_filter_side,
        $vola_filter_value,$take_profit,
        $stop_loss,$middle_line_window,
        $new_volume,$step_size,
        $step_quantity,
        $hard_stop_loss,$zero_line,
        $candles
        
    );
    while ($stmt->fetch()) {
        $res[] = array (
            'code' => (string) $code,
            'period' => (string)$period,
            'trading_logic' =>(string) $trading_logic,
            'reverse_logic' => (string)$reverse_logic,
            'pf' => (string)$pf,
            'side' => (string)$side,
            'total_profit' =>(string) $total_profit,
            'average_profit' => (string)$average_profit,
            'average_loss' =>(string) $average_loss,
            'probability_profit' =>(string) $probability_profit,
            'probability_loss' => (string)$probability_loss,
            'quantity_of_trades' =>(string) $quantity_of_trades,
            'std' => (string)$std,
            'max_dd' =>(string) $max_dd,
            'time_filter' =>(string) $time_filter,
            'vola_filter' =>(string) $vola_filter,
            'start_time' => (string)$start_time,
            'end_time' => (string)$end_time,
            'atr_window' => (string)$atr_window,
            'decil_window' => (string)$decil_window,
            'vola_filter_side' =>(string) $vola_filter_side,
            'vola_filter_value' => (string)$vola_filter_value,
            'take_profit' => (string)$take_profit,
            'stop_loss' => (string)$stop_loss,
            'middle_line_window' => (string)$middle_line_window,
            'new_volume' => (string)$new_volume,
            'step_size' => (string)$step_size,
            'step_quantity' => (string)$step_quantity,
            'hard_stop_loss' => (string)$hard_stop_loss,
            'zero_line' => (string)$zero_line,
            'candles' => (string)$candles
        );
        }
}


echo (json_encode($res));
