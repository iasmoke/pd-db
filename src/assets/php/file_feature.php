<?php
$name = $_POST['name'];
$user_id = $_POST['user_id'];
if($_FILES['file']){
    $path = 'features/';
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $originalName = $_FILES['file']['name'];
    $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
    $t=time();
    $generatedName = $user_id.'_'.$originalName;
    $filePath = $path. $generatedName;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        echo json_encode(array(
            'result' => 'success',
            'status' => true,
            'user_id' => (int) $user_id,
            'name' => $generatedName
        ));
    }
}
