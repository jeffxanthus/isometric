<?php
//ini_set('display_errors', 'On');
header("Content-type: text/html; charset=utf-8"); 
session_start();
require_once('func.php');
$theTitle = '';
    
    $isSpider = false;
    
    if (stripos($_SERVER["HTTP_USER_AGENT"], 'spider') != '' || stripos($_SERVER["HTTP_USER_AGENT"], 'bot') != '' || stripos($_SERVER["HTTP_USER_AGENT"], 'yahoo') != ''){
        
        $isSpider = true;
        
    }
    
    if ($_GET['type'] == 'tendencydetail' && $isSpider == false){
        echo '<script>window.location.href="http://wap.piao.today/#tendencydetail?' . $_GET['id'] . '?' . $_GET['page'] . '";</script>';
    }
    
    
    //-------标题开始
    
    
    
    
    if ($_GET['type'] == '' && $isSpider == true){
        
    }
    /*
    if ($_GET['type'] == 'tendencydetail' && $isSpider == true){
        $titleQuery = "select * from userroute where id=" . $_GET['id'];
        $titleResult = $mysqli->query($titleQuery);
        if ($mysqli->num_rows($titleResult) != 0){
            $titleArray = $mysqli->fetch_array($titleResult);
            $startStationArray = $mysqli->fetch_array($mysqli->query("SELECT * FROM stationinfo WHERE TelegraphCode = '" . $titleArray['fromstation'] . "'"));
            $toStationArray = $mysqli->fetch_array($mysqli->query("SELECT * FROM stationinfo WHERE TelegraphCode = '" . $titleArray['tostation'] . "'"));
            $theTitle = '票.今天 - ' . $titleArray['startfrom'] . ' ' . $startStationArray['StationName'] . '至' . $toStationArray['StationName'] . '余票趋势';
        }
    }
        */
    if ($_GET['type'] == 'readme'){
        
    }
    
    
    
    
    //--------标题结束
    
    
    if ($theTitle == ''){
        $theTitle = 'Schedule.guide()';
    }
    ?>
<!DOCTYPE html>
<html>
<head>

<script type="text/javascript" src="js/jquery.js"></script>
<script src="https://schedule.guide/analysis.php" type="text/javascript" id="analysisjs"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src='js/moment.min.js'></script>
<script type="text/javascript" src="js/fullcalendar.min.js"></script>
<script type="text/javascript" src="js/generate.js"></script>
<script type="text/javascript" src="js/productajax.js"></script>
<script type="text/javascript" src="js/onload.js"></script>
<script type="text/javascript" src="js/WdatePicker.js"></script>
<script type="text/javascript" src="js/lz-string.min.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>


<title><?=$theTitle?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="HandheldFriendly" content="True">
<link rel="apple-touch-icon" href="hcwiki.png"> <!--FIXME-->
<meta content="telephone=no" name="format-detection" /> 
<meta name="Title" Content="Schedule Guide">
<meta name="Keywords" content="Schedule, School Schedule, University Schedule">
<meta name="Description" content="Automatically generate your school schedule as you wish">
<meta name="Content" Content="Schedule, University Schedule, School Schedule">
<link href="./css/bootstrap.min.css" rel="stylesheet">
<link href="./css/fullcalendar.min.css" rel="stylesheet">
<link href="./css/form.css" rel="stylesheet">
<link href='../fullcalendar.print.css' rel='stylesheet' media='print' />
<link id="favicon" href="favicon.ico" rel="icon" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" >
<style>
.navbar-fixed-top, .navbar-fixed-bottom {
    position: fixed;
}
.navbar-brand {
    padding-left: 20px;
    -webkit-padding-left: 20px;
}
.navbar-toggle {
    margin-right: 20px;
    -webkit-margin-right: 20px;
}
body { -webkit-text-size-adjust: 100%; }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<input type="hidden" id="lastHash" value="" />
    
    
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button id="collapsebutton" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" type="button">
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
                <span class="icon-bar">
                </span>
            </button>
            <a style="margin-left:1%;" class="navbar-brand">
                <? echo $theTitle;?>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul id="leftnav" class="nav navbar-nav">
                <?php $nowNaviNum = makeMenu('left', 0);?>
            </ul>
            <ul id="rightnav" class="nav navbar-nav navbar-right" style="margin-right:1%;">
                <?php $nowNaviNum = makeMenu('right' , $nowNaviNum);?>
            </ul>
        </div>
    </div>
</nav>
<span id="standardSpan"></span>
<div id="modals">
<?php
getModal('register', 'register', 'register', 'register');
getModal('login', 'login', 'login', 'login');
?>
</div>
<div style="text-align:center;">
<input type="hidden" id="naviNum" value="<?=$nowNaviNum?>">
<input type="hidden" id="lastNaviID" value="navid0">
<div id="pageTop" style="text-align:left; float:left;"></div>


<span id="tempArea"></span>
<span id="uploadArea"></span>
<span id="logoutArea"></span>


<div id="mainArea" style="text-align:center;">
<?php
/*if ($_GET['type'] == '' && $isSpider == true){
    require_once('index.php');
}

if ($_GET['type'] == 'tendencydetail' && $isSpider == true){
    echo '<form class="normal-form" style="height:auto; width:60%;">';
    require_once('tendencydetail.php');
    echo '</form>';
}


    
if ($_GET['type'] == 'readme'){
    echo '<script>setHash("readme");</script>';
}
    
*/
?>
</div>
</div>


</body>
</html>