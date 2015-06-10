<?php
session_start();
require_once('func.php');
require 'vendor/autoload.php';
use Mailgun\Mailgun;
ini_set('display_errors', 'Off');
$username=$_POST['username'];
$password=md5(substr(md5(substr(md5($_POST['password']), 8, 16)), 8, 16) . '2zb5i9');
$email=$_POST['email'];
$registertime=date('Y-m-d H:i:s');
$rights="user";
$flag=10;
$balance=0;

if (trim($_SESSION['validateCode']) != trim(strtoupper($_POST['captcha']))){
	$errorMessage = __("captchaisincorrect");
	echo $errorMessage;
	die();
}

if (strlen($username) < 4){
	$errorMessage = __("usernamelengthshouldnotshorterthan4characters");
	echo $errorMessage;
	die();
}

if (strlen($_POST['password']) < 6){
	$errorMessage = __("passwordshouldnotshorterthan6characters");
	echo $errorMessage;
	die();
}

if ($_POST['confirmpassword'] != $_POST['password']){
	$errorMessage = __("passwordthatyouentered2timescannotmatcheachother");
	echo $errorMessage;
	die();
}
if ($email == ''){
	$errorMessage = __("pleaseenteryouremail");
	echo $errorMessage;
	die();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	$errorMessage = __('emailisinvalid');
	echo $errorMessage;
	die();
}

$errorMessage = '';
$query = "SELECT * FROM `user` WHERE `username`=? OR `email`=?";
$stmt = $mysqli->stmt_init();
if ($stmt->prepare($query)){
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    $numrows = $rsResult->num_rows;
    if ($numrows != 0){
        if ($rs = $rsResult->fetch_assoc()){
            if ($rs['username'] == $username){
                $errorMessage = sprintf(__('usernameisoccupiedbyothers'), $username);
            }elseif($rs['email'] == $email){
                $errorMessage = sprintf(__('emailisoccupiedbyothers'), $email);
            }
            echo $errorMessage;
            $stmt->close();
            die();
        }
    }
    $stmt->close();
}


$emailValidOfSchool = false;

$query = "SELECT * FROM `school`";
if ($stmt = $mysqli->prepare($query)){
    $stmt->execute();
    $rsResult = $stmt->get_result();
    while ($rs = $rsResult->fetch_assoc()){
        $matches = array();
        preg_match('/' . $rs['emailsub'] . '/i', $email, $matches, PREG_OFFSET_CAPTURE);
        if (count($matches) != 0){
            $schoolid = $rs['id'];
            $emailValidOfSchool = true;
            break;
        }
    }
    $stmt->close();
}



if ($emailValidOfSchool == false){
    echo __('yourschoolisnotsupportedbyus');
    die();
}

$randkey = randomkeys(50);

$lostpasswordvalidate = "0";
$lastlogin = "2000-01-01";

$stmt = $mysqli->stmt_init();
$stmt->prepare("INSERT INTO user (username, password, email, emailvalidatecode, lostpasswordvalidate, balance, flag, registertime, lastlogin, schoolid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sssssddssd', $username, $password, $email, $randkey, $lostpasswordvalidate, $balance, $flag, $registertime, $lastlogin, $schoolid);
$stmt->execute(); 
$stmt->close();
$newid = $mysqli->insert_id;
$body = sprintf(__("registeremailcontent"), $newid, $randkey, $newid, $randkey, date('m/d/Y H:i:s'));
//echo $body;
$subject = __("scheduleguideregistrationconfirmation");



$mgClient = new Mailgun('key-dd8c8d1987e51fcf1477b8c76940426a');
$domain = "schedule.guide";

# Make the call to the client.
$result = $mgClient->sendMessage($domain, array(
    'from'    => 'Schedule.guide() Registration <register@schedule.guide>',
    'to'      => '<' . $email . '>',
    'subject' => $subject,
    'html'    => $body
));

$sendResult = json_decode(json_encode($result), true);;

if ($sendResult["http_response_code"] == 200 && $sendResult["http_response_body"]["message"] == "Queued. Thank you."){
    echo (__("youhadregisteredsuccessfullypleaseconfirmyouremailfirst"));
}
    
    
//var_dump($result);


die();
?>

