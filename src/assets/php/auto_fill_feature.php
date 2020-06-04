<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$generatedName = $_POST['file_name'];

$json = "{'filename':'$generatedName'}";
$command = "python C:/wamp64/www/research_tool/assets/python/get_json.py " . escapeshellarg($json);
$data = `$command`;
unlink('../python/'.$generatedName);
echo($data);

