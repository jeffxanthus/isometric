<?php
session_start();
require_once('func.php');
require 'vendor/autoload.php';
use Mailgun\Mailgun;
ini_set('display_errors', 'Off');
$uid = $_SESSION['uid'];
$alias = $_POST['alias'];
$data = $_POST['calendar'];
$type = $_POST['type'];
$id = $_POST['id'];
$savetime = date('Y-m-d H:i:s');

if (trim($alias) == ''){
    $errorMessage = __("pleaseinputalias");
    echo $errorMessage;
    die();
}

if ($uid == ''){
    $errorMessage = __("pleaseloginfirst");
    echo $errorMessage;
    die();
}

$finalOnlyStr = '';
$errorMessage = '';

if ($type == 'new'){
    $query = "SELECT * FROM `savedschedule` WHERE `user`=? AND `alias`=?";
    
    
    $randkey1 = randomkeys(32);
    $randkey2 = randomkeys(32);
    $aliasMD5 = md5(md5(md5($alias) . $randkey1) . $randkey2);
    for($i = 0; $i < 5; $i++){
        $finalOnlyStr .= $aliasMD5[$i];
        
        if ($i % 2 != 0){
            $finalOnlyStr .= $randkey1[$i];
        }else{
            $finalOnlyStr .= $randkey2[$i];
        }
    }
    
    
}elseif($type == 'update'){
    $query = "SELECT * FROM `savedschedule` WHERE `user`=? AND `id`=?";
}
$stmt = $mysqli->stmt_init();
if ($stmt->prepare($query)){
    if ($type == 'new'){
        $stmt->bind_param("ds", $_SESSION['uid'], $alias);
    }elseif($type == 'update'){
        $stmt->bind_param("dd", $_SESSION['uid'], $id);
    }
    $stmt->execute();
    $rsResult = $stmt->get_result();
    $numrows = $rsResult->num_rows;
    
    if ($type == 'new'){
        if ($numrows != 0){
            echo(__('thisaliasisusedbyanotherschedule') . '.<br>' . __('pleasetryanotheralias') . '.');
            die();
        }
    }elseif($type == 'update'){
        if ($numrows == 0){
            echo(__("calendardoesntexist"));
            die();
        }else{
            if ($rs = $rsResult->fetch_assoc()){
                $finalOnlyStr = $rs['certkey'];
            }
        }
    }
    $stmt->close();
}

$stmt = $mysqli->stmt_init();


$returnString = '';

if ($type == 'new'){
    $stmt->prepare("INSERT INTO `savedschedule` (`user`, `content`, `firstsavetime`, `lastsavetime`, `alias`, `certkey`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('dsssss', $uid, $data, $savetime, $savetime, $alias, $finalOnlyStr);
    $stmt->execute(); 
    $stmt->close();
    $newid = $mysqli->insert_id;
    $id = $newid;
    echo("<script>$('#saveCalendar').css('display','none');</script>");
    echo("<script>$('#updateCalendar').css('display','');</script>");
    $returnString = 'Saved!';
}elseif($type == 'update'){
    $stmt->prepare("UPDATE `savedschedule` SET `content`=?, `lastsavetime`=? WHERE `user`=? AND `id`=?");
    $stmt->bind_param('ssdd', $data, $savetime, $uid, $id);
    $stmt->execute(); 
    $stmt->close();
    $returnString = 'Updated!';
}



echo('<script>$("#savedCalendarID").val("' . $id . '");</script>');
echo('<script>$("#aliasid").val("' . $alias . '");</script>');

echo($returnString);
echo('<br>');
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $proc = 'https';
}else{
    $proc = 'http';
}

$newLink = $proc . '://schedule.guide/#scheduledetail?' . $_SESSION['uid'] . '?' . $id . '?' . $finalOnlyStr;

echo('Link: <a href="' . $newLink . '">' . $newLink . '</a>');
die();
?>

