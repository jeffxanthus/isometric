<?php
header("Content-Type:text/html;charset=utf-8");
require_once('func.php');
$id = $_GET['id'];
$key = $_GET['key'];

$stmt = $mysqli->stmt_init();
$query = "UPDATE `user` SET `emailvalidatecode`='0' WHERE `id`=? AND `emailvalidatecode`=?";
$stmt->prepare($query);
$stmt->bind_param('ds', $id, $key);
$stmt->execute();
if ($stmt->affected_rows > 0){
    echo("<script>alert('" . __("youhadverifiedyouremailsuccessfully") . "');window.location.href='https://schedule.guide/#login';</script>");
}else{
    echo("<script>alert('" . __("verifyemailfailed") . "');window.history.back(-1);</script>");
}
die();
?>