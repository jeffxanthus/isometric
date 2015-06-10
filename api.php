<?php
require_once('func.php');
ini_set('display_errors', 'Off');
error_reporting(0);

$school = $_REQUEST['s'];
$course = str_replace(chr(13) . chr(10), chr(10), $_REQUEST['c']);
//$course = 'CSE8B,CSE15L'.PHP_EOL.'CSE20';
$quarter = $_REQUEST['q'];
$apiid = $_REQUEST['a'];
if ($apiid == '' || $school == '' || $course == '' || $quarter == ''){
    echo('[]');
    die();
}



$query = "SELECT * FROM `apilist` WHERE `schoolid` = ? AND `id` = ?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("dd", $school, $apiid);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    if ($rs = $rsResult->fetch_assoc()){
        $data = 'q=' . $quarter . '&c=' . $course . '&k=' . $rs['apikey'];
        $header = array('Cookie: ','');
        $referer = 'schedule.guide';
        $data = curl_open($rs['link'], 'POST', $data, $header, $referer, false, true);
        echo $data[0];
        $classData = json_decode($data[0], true);
    }elseif($_SESSION['school'] == ""){
        echo '<option>' . __('pleaseloginfirst') . '</option>';
    }else{
        echo '<option>' . __('thisisanerrorcontactadmin') . '</option>';
    }
    $stmt->close();
}




/*
$query = "SELECT * FROM `apilist` WHERE `id` = ? AND `school` = ?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("dd", $apiid, $school);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    if ($rs = $rsResult->fetch_assoc()){
        
        
    }else{
        echo(json_encode(array('error'=>'api not found!')));
    }
    $stmt->close();
}

*/



?>
