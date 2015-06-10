<?php
header("Content-type: text/html; charset=utf-8");
$mySqlServer="127.0.0.1";
$mySqlUsername="root";
$mySqlPassword="密码被隐去";
$confDatabase = "scheduleguide";
$mysqli = new mysqli($mySqlServer, $mySqlUsername, $mySqlPassword, $confDatabase);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->query("SET NAMES 'utf8';");
$pageSize = 20;
require_once('language.php');
?>