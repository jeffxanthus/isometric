<?php
ini_set('session.cookie_lifetime', 0);
ini_set('session.gc_maxlifetime', 360000);
session_start();

ini_set('display_errors', 'Off');
require_once('func.php');
$username = $_POST['username'];
$password = md5(substr(md5(substr(md5($_POST['password']), 8, 16)), 8, 16) . '2zb5i9');
if ($_SESSION['validateCode'] != strtoupper($_POST["captcha"])){
    $_SESSION['validateCode'] = '';
    $errorMessage = __("captchaisincorrect");
    echo $errorMessage;
    die();
}

$query = "SELECT * FROM `user` WHERE `username`=? AND `password`=?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    if ($rs = $rsResult->fetch_assoc()){
        if ($rs['emailvalidatecode'] != "0"){
            echo (__("youhadregisteredsuccessfullypleaseconfirmyouremailfirst"));
            die();
        }
        
        $_SESSION['user'] = $rs['username'];
        $_SESSION['flag'] = $rs['Flag'];
        $_SESSION['Login'] = "OK";
        $_SESSION['school'] = $rs['schoolid'];
        $_SESSION['uid'] = $rs['id'];
        $_SESSION['lastlogin'] = date("Y-m-d H:i:s");
        $mysqli->query("UPDATE `user` SET `lastlogin`='" . $_SESSION['lastlogin'] . "' WHERE id=" . $_SESSION['uid']);
        echo '<script>alert("' . __('youhaveloggedinsuccessfully') . '");' . "$('#naviNum').val('0');makeMenu('left');makeMenu('right');$('#loginModal').modal('hide');document.getElementById('lastHash').value == ''?setHash('index'):history.back(-1);" . '</script>';
    }else{
        echo __('passwordincorrect');
    }
    $stmt->close();
}
$_SESSION['validateCode'] = '';
?>