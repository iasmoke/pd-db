<?php
function db_connect() {

    // Define connection as a static variable, to avoid connecting more than once
    static $db_connect;

    // Try and connect to the database, if a connection has not been established yet
    if(!isset($db_connect)) {

        // Load configuration as an array. Use the actual location of your configuration file
        $config = parse_ini_file('config.dev.ini');
        $db_connect = new mysqli($config['servername'].':'.$config['port'],$config['username'],$config['password'],$config['dbname']);
    }
    // If connection was not successful, handle the error
    if($db_connect === false) {

        // Handle error - notify administrator, log to a file, show an error screen, etc.
        return mysqli_connect_error();
    }
    return $db_connect;
}

// Connect to the database
$db_connect = db_connect();

// Check connection
if ($db_connect->connect_error) {
    die("Connection failed: " . $db_connect->connect_error);
}
?>
