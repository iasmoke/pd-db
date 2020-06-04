<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set('memory_limit', '-1');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Content-Type: application/json; charset=utf-8');

require_once('connect_db.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$command = "cd C:/wamp64/www/research_tool/assets/python && python influxdb_status.py";
$data = `$command`;

echo(json_encode(trim($data, "\n")));

