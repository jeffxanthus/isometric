<?php
//main function file.

//ATTENTION!

//you need to do following things to make sure that this website can run properly:
//apt-get install gearman-job-server
//apt-get install php5-mysql
//apt-get install php5-mysqlnd
//END OF ATTENTION
session_start();
require_once('conn.php');
require_once('simple_html_dom.php');

$pageSize = 20;







function randomkeys($length){
    $key = '';
    $pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for($i=0;$i<$length;$i++){
        $key .= $pattern{mt_rand(0,strlen($pattern)-1)};    //生成php随机数
    }
    return $key;
}


function makeMenu($side, $starti){
    global $mysqli;
    $i = $starti;
    $execFunc = "SELECT * FROM `link` WHERE `side`='$side' ORDER BY `OrgID`";
    $funcresult = $mysqli->query($execFunc);
    while($rsFunc = $funcresult->fetch_array()){
        echo "<li id=\"navid$i\" data-name=\"" . $rsFunc['Name'] . "\" onmousedown=\"changeActiveStatus('$i');\"";
        if ($i == 1){ echo 'class=\"active\"'; }
        echo ">";
        $rsFunc['Link']==''?$rsFunc['Link']='javascript:void(0);':$rsFunc['Link']=$rsFunc['Link'];
        if ($rsFunc['NeedVerify'] == 'notlogin'){
            if ($_SESSION['Login'] != 'OK'){
                echo "<a href=\"" . $rsFunc['Link'] . "\" onClick=\"" . $rsFunc['OnClick'] . "\">" . $rsFunc['Menu'] . "</a>";
            }
        }
        if ($rsFunc['NeedVerify'] == 'all'){
            echo "<a href=\"" . $rsFunc['Link'] . "\" onClick=\"" . $rsFunc['OnClick'] . "\">" . $rsFunc['Menu'] . "</a>";
        }
        if ($rsFunc['NeedVerify'] == "havelogin"){
            if ($_SESSION['Login'] == "OK"){
                echo "<a href=\"" . $rsFunc['Link'] . "\" onClick=\"" . $rsFunc['OnClick'] . "\">" . $rsFunc['Menu'] . "</a>";
            }    
        }    
        if ($rsFunc['NeedVerify'] == 'root'){    
            if ($_SESSION['rights'] == 'root'){    
                echo "<a href=\"" . $rsFunc['Link'] . "\" onClick=\"" . $rsFunc['OnClick'] . "\">" . $rsFunc['Menu'] . "</a>";
            }    
        }    
        echo "</li>";
        $i++;
    }
    return $i;
}

/*
function getModal(...$args)
returns a dialog box.

parameters:
#0: String $file, the file to open
#1: String $title, the title of the dialog box
#2: String $button, the text of submit button
#3: String $onclick, the function of the submit button
#4...: Array('parameter'=>'value'), parameters to give
*/
function getModal($file,$title,$button,$onclick,$close){
    global $mysqli;
    global $pageSize;
    $numargs = func_num_args();
    $file==''?$file = func_get_arg(0):$file=$file;
    $title==''?$title = func_get_arg(1):$title=$title;
    $button==''?$button = func_get_arg(2):$button=$button;
    $onclick==''?$onclick = func_get_arg(3):$onclick=$onclick;
    $close==''?$close = func_get_arg(4):$close=$close;
    if ($numargs == 6){
        $paraArray = func_get_arg(5);
    }else{
        $paraArray = array();
    }
    
    /*$paraArray = array();
    for ($i = 4; $i < $numargs; $i++){
        $tempArr = func_get_arg($i);
        $tempArrKeys = array_keys($tempArr);
        $paraArray[$tempArrKeys[0]] = $tempArr[$tempArrKeys[0]];
    }*/
    
    require('modal.php');
}

function curl_open($url, $type, $data, $header, $referer, $getheader, $getbody){
    $ch = curl_init(); //初始化curl
    if ($type == 'POST'){
        curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//POST数据
    }else{
        $url .= '?' . $data;
    }
    
    if ($getheader == true){
        curl_setopt($ch, CURLOPT_HEADER, 1);
    }else{
        curl_setopt($ch, CURLOPT_HEADER, 0);
    }
    
    if ($getbody == true){
        curl_setopt($ch, CURLOPT_NOBODY, 0);
    }else{
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    
    
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);//设置链接
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置HTTP头
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36');
    $response = curl_exec($ch);//接收返回信息
    $cookies=array();
    
    if(curl_errno($ch)){//出错则显示错误信息
        print curl_error($ch);
    }
    
    //preg_match_all('/Set-Cookie:(?<cookie>\s{0,}.*)$/im', $response, $cookies);
    //var_dump($cookies);
    
    //$cookieParts = array();
    //preg_match_all('/Set-Cookie:\s{0,}(?P<name>[^=]*)=(?P<value>[^;]*).*?expires=(?P<expires>[^;]*).*?path=(?P<path>[^;]*).*?domain=(?P<domain>[^\s;]*).*?$/im', $response, $cookieParts);
    //var_dump($cookieParts);
    
    
    preg_match_all('/Set-Cookie:(.*);/iU',$response,$str); //正则匹配
    $cookies = $str[1]; //获得COOKIE（SESSIONID）
    $cookie = '';
    for ($i=0; $i< count($cookies); $i++){
        $cookie .= $cookies[$i]. ';';
    }
    //preg_match('/^Set-Cookie:\s*([^;]*)/mi', $result, $m);
 
    //parse_str($m[1], $cookies);
    //var_dump($cookies);

    //echo(file_get_contents('cookie.txt'));
    curl_close($ch); //关闭curl链接
    //echo $cookie;
    //echo $response;
    return array($response, $cookie);//显示返回信息
}


//function strong trim
//delete all spaces connect together
function strim($str){
    $str = trim($str);
    $str = str_replace('( ', '(', $str);
    $str = str_replace(' (', '(', $str);
    $str = str_replace(') ', ')', $str);
    $str = str_replace(' )', ')', $str);
    $str = str_replace(chr(9), '', $str);
    $str = str_replace('  ', '', $str);
    if (strpos($str, '  ') !== false){
        return strim($str);
    }else{
        $str = str_replace('( ', '(', $str);
        $str = str_replace(' (', '(', $str);
        $str = str_replace(') ', ')', $str);
        $str = str_replace(' )', ')', $str);
        $str = str_replace(chr(9), '', $str);
        $str = str_replace('  ', '', $str);
        return trim($str);
    }
}
?>