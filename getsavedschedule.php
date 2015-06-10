<?php
require_once('func.php');
ini_set('display_errors', 'On');
$user = $_POST['uid'];
$id = $_POST['id'];
$certKey = $_POST['certKey'];
$schoolid = 0;

$query = "SELECT * FROM `user` WHERE `id` = ?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("d", $user);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    if ($rs = $rsResult->fetch_assoc()){
        $schoolid = $rs['schoolid'];
    }
    $stmt->close();
}





$query = "SELECT * FROM `savedschedule` WHERE `user` = ? AND `id` = ? AND `certkey` = ?";

if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("dds", $user, $id, $certKey);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    if ($rs = $rsResult->fetch_assoc()){
        $returnArray = array();
        $returnArray['content'] = $rs['content'];
        $returnArray['schoolid'] = $schoolid;
        echo json_encode($returnArray);
    }else{
        echo '{}';
    }
    $stmt->close();
}
?>