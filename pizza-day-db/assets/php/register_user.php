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
$first_name = $user_form['first_name'];
$last_name = $user_form['last_name'];
$user_role = $user_form['user_role'];



$sql = mysqli_query($db_connect, "SELECT user_id FROM users WHERE user_name='" . mysqli_real_escape_string($db_connect, $user_name) . "'");
switch ($sql) {
    case mysqli_num_rows($sql) > 0:
        $res = "Такой пользователь уже существует";
        echo (json_encode($res));
        break;
    default:
        $password_encode = base64_encode($password);
        $sql = "INSERT INTO users (user_name, password, first_name, last_name, user_role) VALUES (?,?,?,?,?)";
        if ($stmt = $db_connect->prepare($sql)) {
            $stmt->bind_param("sssss", $user_name, $password_encode, $first_name, $last_name, $user_role);
            $stmt->execute();
            if (count($stmt->error_list) === 0) {
                $res = 'Регистрация успешна';
            } else {
                $res = $stmt->error_list;
            }
        $sql = "SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1";
        if ($stmt = $db_connect->prepare($sql)) {
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_assoc();
            $user_id = (int) $result['user_id'];

        $sql = "INSERT INTO users_settings_content (user_id) VALUES (?)";
        if ($stmt = $db_connect->prepare($sql)) {
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            if (count($stmt->error_list) === 0) {
                $res = 'Регистрация успешна';
            } else {
                $res = $stmt->error_list;
            }
        }
    }
}
        break;
}
echo (json_encode($res));

// $sql = "SELECT * FROM db_main WHERE user_id=0";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->execute();
//     $stmt->bind_result(
//         $user_id_row,
//         $id_person,
//         $id_telegram_chat,
//         $date_create_employee,
//         $date_last_update,
//         $user_name_create_employee,
//         $user_name_last_update,
//         $first_name,
//         $last_name,
//         $second_name,
//         $type_department,
//         $department,
//         $position,
//         $number_phone,
//         $interview_date,
//         $internship_date,
//
//         $passing_score,
//         $internship_place,
//         $attraction_channel,
//         $attraction_channel_description,
//         $reason_dismissal,
//         $employee_status,
//         $date_forming,
//         $availability_doc,
//         $rejection_reason,
//         $city_residence,
//         $place_residence,
//         $test_date_1,
//         $test_number_ball_1,
//         $test_date_2,
//         $test_number_ball_2,
//         $date_birth,
//         $city_registration,
//         $address_registration,
//         $date_registration_job,
//         $available_doc,
//         $date_dismissal,
//         $description_dismissal,
//         $inn,
//         $status

//     );
//     while ($stmt->fetch()) {
//         $db_main[] = array(
//             'user_id' => $user_id,
//             'id_person' => (int) $id_person,
//             'id_telegram_chat' => $id_telegram_chat,
//             'date_create_employee' => $date_create_employee,
//             'date_last_update' => $date_last_update,
//             'user_name_create_employee' => $user_name_create_employee,
//             'user_name_last_update' => $user_name_last_update,
//             'first_name' => $first_name,
//             'last_name' => $last_name,
//             'second_name' => $second_name,
//             'type_department' => $type_department,
//             'department' => $department,
//             'position' => $position,
//             'number_phone' => $number_phone,
//             'interview_date' => $interview_date,
//             'internship_date' => $internship_date,
//
//             'passing_score' => $passing_score,
//             'internship_place' => $internship_place,
//             'attraction_channel' => $attraction_channel,
//             'attraction_channel_description'=> $attraction_channel_description,
//             'reason_dismissal' => $reason_dismissal,
//             'employee_status' => $employee_status,
//             'date_forming' => $date_forming,
//             'availability_doc' => $availability_doc,
//             'rejection_reason'=> $rejection_reason,
//             'city_residence' => $city_residence,
//             'address' => $place_residence,
//             'test_date_1'=>$test_date_1,
//             'test_number_ball_1'=>$test_number_ball_1,
//             'test_date_2'=>$test_date_2,
//             'test_number_ball_2'=>$test_number_ball_2,
//             'date_birth'=>$date_birth,
//             'city_registration'=>$city_registration,
//             'address_registration'=>$address_registration,
//             'date_registration_job'=>$date_registration_job,
//             'available_doc'=>$available_doc,
//             'date_dismissal'=>$date_dismissal,
//             'description_dismissal'=>$description_dismissal,
//             'inn'=>$inn,
//             'status'=> $status
//         );
//     }

//     foreach ($db_main as $row_db_main) {
//         $sql = "INSERT INTO db_main (`user_id`, `id_person`, `id_telegram_chat`, `date_create_employee`, `date_last_update`, `user_name_create_employee`, `user_name_last_update`, `first_name`, `last_name`, `second_name`, `type_department`, `department`, `position`, `number_phone`, `interview_date`, `internship_date`, `passing_score`, `internship_place`, `attraction_channel`, `attraction_channel_description`,`reason_dismissal`, `employee_status`, `date_forming`, `availability_doc`, `rejection_reason`, `city_residence`, `place_residence`,`test_date_1`,'test_number_ball_1',`test_date_2`,`test_number_ball_2`,`date_birth`,`city_registration`,`address_registration`,`date_registration_job`,`available_doc`,`date_dismissal`,`description_dismissal`,`inn`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
//         if ($stmt = $db_connect->prepare($sql)) {
//             $stmt->bind_param("iisssssssssssssssssssssssssssssssssssssss",
//                 $user_id,
//                 $row_db_main['id_person'],
//                 $row_db_main['id_telegram_chat'],
//                 $row_db_main['date_create_employee'],
//                 $row_db_main['date_last_update'],
//                 $row_db_main['user_name_create_employee'],
//                 $row_db_main['user_name_last_update'],
//                 $row_db_main['first_name'],
//                 $row_db_main['last_name'],
//                 $row_db_main['second_name'],
//                 $row_db_main['type_department'],
//                 $row_db_main['department'],
//                 $row_db_main['position'],
//                 $row_db_main['number_phone'],
//                 $row_db_main['interview_date'],
//                 $row_db_main['internship_date'],
//                
//                 $row_db_main['passing_score'],
//                 $row_db_main['internship_place'],
//                 $row_db_main['attraction_channel'],
//                 $row_db_main['attraction_channel_description'],
//                 $row_db_main['reason_dismissal'],
//                 $row_db_main['employee_status'],
//                 $row_db_main['date_forming'],
//                 $row_db_main['availability_doc'],
//                 $row_db_main['rejection_reason'],
//                 $row_db_main['city_residence'],
//                 $row_db_main['place_residence'],
//                 $row_db_main['test_date_1'],
//                 $row_db_main['test_number_ball_1'],
//                 $row_db_main['test_date_2'],
//                 $row_db_main['test_number_ball_2'],
//                 $row_db_main['date_birth'],
//                 $row_db_main['city_registration'],
//                 $row_db_main['address_registration'],
//                 $row_db_main['date_registration_job'],
//                 $row_db_main['available_doc'],
//                 $row_db_main['date_dismissal'],
//                 $row_db_main['description_dismissal'],
//                 $row_db_main['inn'],
//                 $row_db_main['status']
//             );
//             $stmt->execute();
//         }
//     }
// }
// $sql = "SELECT feature_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name, file, def_feature FROM features WHERE user_id=0";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->execute();
//     $stmt->bind_result(
//         $feature_name,
//         $parameter_name,
//         $value_name,
//         $start_value,
//         $stop_value,
//         $step_value,
//         $type,
//         $parameter_description,
//         $file_name,
//         $file,
//         $def_feature
//     );
//     while ($stmt->fetch()) {
//         $features[] = array(
//             'feature_name' => $feature_name,
//             'parameter_name' => $parameter_name,
//             'value_name' => $value_name,
//             'start_value' => $start_value,
//             'stop_value' => $stop_value,
//             'step_value' => $step_value,
//             'type' => $type,
//             'parameter_description' => $parameter_description,
//             'file_name' => $user_id . "_" . $file_name,
//             'file' => $file,
//             'def_feature' => $def_feature

//         );
//     }
//     foreach ($features as $row_features) {
//         $sql = "INSERT INTO features (user_id, feature_name, parameter_name, value_name, start_value, stop_value, step_value, type, parameter_description, file_name, file, def_feature)
//         VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
//         if ($stmt = $db_connect->prepare($sql)) {
//             $stmt->bind_param(
//                 "isssdddssssi",
//                 $user_id,
//                 $row_features['feature_name'],
//                 $row_features['parameter_name'],
//                 $row_features['value_name'],
//                 $row_features['start_value'],
//                 $row_features['stop_value'],
//                 $row_features['step_value'],
//                 $row_features['type'],
//                 $row_features['parameter_description'],
//                 $row_features['file_name'],
//                 $row_features['file'],
//                 $row_features['def_feature']
//             );
//             $stmt->execute();
//         }
//     }
// }
// $sql = "SELECT parameter_name, parameter_value, parameter_type  FROM `trading_settings` WHERE user_id=0";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->execute();
//     $stmt->bind_result(
//         $parameter_name,
//         $parameter_value,
//         $parameter_type
//     );
//     while ($stmt->fetch()) {
//         $trading_settings[] = array(
//             'parameter_name' => $parameter_name,
//             'parameter_value' => $parameter_value,
//             'parameter_type' => $parameter_type,
//         );
//     }
//     foreach ($trading_settings as $row_trading_settings) {
//         $sql = "INSERT INTO trading_settings (user_id,parameter_name, parameter_value, parameter_type) VALUES (?,?,?,?)";
//         if ($stmt = $db_connect->prepare($sql)) {
//             $stmt->bind_param("isss", $user_id, $row_trading_settings['parameter_name'], $row_trading_settings['parameter_value'], $row_trading_settings['parameter_type']);
//             $stmt->execute();
//         }
//     }
// }
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
// $sql = "INSERT INTO markets (user_id) VALUES (?)";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
// }
// //     }
// // }
// $sql = "SELECT parameter_name, value_name, value, description, type  FROM `trading_logics_settings` WHERE user_id=0";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->execute();
//     $stmt->bind_result(
//         $parameter_name,
//         $value_name,
//         $value,
//         $description,
//         $type
//     );
//     while ($stmt->fetch()) {
//         $trading_logics_settings[] = array(
//             'parameter_name' => $parameter_name,
//             'value_name' => $value_name,
//             'value' => $value,
//             'description' => $description,
//             'type' => $type
//         );
//     }
//     foreach ($trading_logics_settings as $row_trading_logics_settings) {
//         $sql = "INSERT INTO trading_logics_settings (user_id,parameter_name, value_name, value, description, type) VALUES (?,?,?,?,?,?)";
//         if ($stmt = $db_connect->prepare($sql)) {
//             $stmt->bind_param(
//                 "iisdss",
//                 $user_id,
//                 $row_trading_logics_settings['parameter_name'],
//                 $row_trading_logics_settings['value_name'],
//                 $row_trading_logics_settings['value'],
//                 $row_trading_logics_settings['description'],
//                 $row_trading_logics_settings['type']
//             );
//             $stmt->execute();
//         }
//     }
// }
// $sql = "INSERT INTO spread (user_id,spread_from,spread_to,spread_value) VALUES (?,0,0,0)";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
// }

// $sql = "INSERT INTO users_settings (user_id, server, user_status_research, log_error, progress_status) VALUES (?,?,0,'-','-')";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->bind_param("is", $user_id, $server_name);
//     $stmt->execute();
// }

// $sql = "UPDATE trading_settings SET parameter_value=? WHERE user_id=? AND parameter_name='threads'";
// if ($stmt = $db_connect->prepare($sql)) {
//     $stmt->bind_param("ii",$threads_user, $user_id);
//     $stmt->execute();
// }




