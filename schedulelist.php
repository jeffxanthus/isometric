<?php
session_start();
require_once('func.php');

ini_set('display_errors', 'On');
$totalRecord = 0;

if(!isset($_SESSION['school']) || $_SESSION['school'] == ""){
    echo '' . __('pleaseloginfirst') . '';
    die();
}

$query = "SELECT * FROM `savedschedule` WHERE `user` = ?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("d", $_SESSION['uid']);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    $totalRecord = $rsResult->num_rows;
    if ($rs = $rsResult->fetch_assoc()){
        //do nothing
    }else{
        echo '<option>' . __('thisisanerrorcontactadmin') . '</option>';
    }
    $stmt->close();
}

$totalPages = ceil($totalRecord / $pageSize);


$nowPage = 0;
if (isset($_REQUEST['page'])){
    $nowPage=$_REQUEST['page'];
}else{
    $nowPage=1;
}

$lowlimit = $pageSize * ($nowPage - 1);
$uplimit = $pageSize * $nowPage;

if ($nowPage + 1 > $totalPages){
    $nextPage=$nowPage;
}else{
    $nextPage=$nowPage+1;
}
if ($nowPage - 1 == 0){
    $lastPage=1;
}else{
    $lastPage=$nowPage-1;
}
?>
<font size="2" color="#333333">

<?php printf(__("total:records"),$totalRecord)?>&nbsp;&nbsp;&nbsp;</font>
<br>
<table border="1px" bordercolor="#CCCCCC" cellspacing="0px" style="border-collapse:collapse;text-align:center;" width="100%" >
<thead>
    <tr bgcolor="#EEEEEE">
<td width="33%"> 
<font color="#333333" size="2">Alias</font></td> 
<td width="33%"> 
  <font color="#333333" size="2">Create Time</font></td>
<td width="34%" colspan="2"> 
  <font size="2" color="#333333">Functions</font></td>
</tr>
</thead>
<tbody>

<?php
$query = "SELECT * FROM `savedschedule` WHERE `user` = ? LIMIT " . $lowlimit . ", " . $pageSize;
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("d", $_SESSION['uid']);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    $totalRecord = $rsResult->num_rows;

    while ($rs = $rsResult->fetch_assoc()){
    ?>
    <tr>
    <td style="word-wrap: break-word; word-break: break-all;"><font color="#333333" size="2"><?=$rs['alias']?></font></td>
    <td style="word-wrap: break-word; word-break: break-all;"><font color="#333333" size="2"><?=$rs['lastsavetime']?></font></td>
    <td width="17%" style="border-left:none; border-right:none; word-wrap: break-word; word-break: break-all;">
    <a onClick="return confirm('<?=__('areyousuretodelete')?>');" href="delschedule.php?id=<?=$rs['id']?>"><font color="#FF0000" size="2">Del</font></a></td>
    <td width="17%" style="border-left:none; word-wrap: break-word; word-break: break-all;"><a onclick="setHash('scheduledetail?<?=$_SESSION['uid']?>?<?=$rs['id']?>?<?=$rs['certkey']?>');$('#myschedulelistModal').modal('hide');return false;" href="javascript:void(0);"><font size="2">Open</font></a></td>
    </tr>
    
    <?php
    
    }
}
?>
</tbody>
</table>
<center>
<p style="text-align:center;font-size:12px;">
<?php printf(__("total:records"),$totalRecord);?>&nbsp;<?php printf(__("currentpage:"),$nowPage);?>
<br />
<? if ($nowPage != 1){?> 
<br />
<a href="javascript:setHash('schedulelist?1');"><?=__('firstpage')?></a>
<? }else{?> 
<?=__('firstpage')?> 
<? }?>
&nbsp;&nbsp;

<? if ($nowPage > 1){?> 

<a href="javascript:setHash('schedulelist?<?=$nowPage-1?>');"><?=__('previouspage')?></a>
<? }else{?> 
<?=__('previouspage')?> 
<? }?>
&nbsp;&nbsp;


<? if ($nowPage < $totalPages){?> 

<a href="javascript:setHash('schedulelist?<?=$nowPage+1?>');"><?=__('nextpage')?></a> 
<? }else{?> 
<?=__('nextpage')?>
<? }?> 
&nbsp;&nbsp;

<? if ($nowPage != $totalPages){?> 
<a href="javascript:setHash('schedulelist?<?=$totalPages?>');"><?=__('lastpage')?></a>
<? }else{?> 
<?=__('lastpage')?>
<? }?>
&nbsp;&nbsp;
<br />
<?
if ($nowPage - 5 > 1 && $totalPages > 10){
    echo "... ";
}
if ($nowPage >= 1 && $nowPage <= 1 + 5){
    $FirstPage = 1;
    $EndPage = 10;
    if ($totalPages < 10){
        $EndPage = $totalPages;
    }
}elseif ($nowPage > 1 + 5 && $nowPage < $totalPages - 4){
    if ($nowPage - 5 > 0){
        $FirstPage = $nowPage - 5;
    }else{
        $FirstPage = 1;
    }
    $EndPage = $nowPage + 4;
    if ($EndPage > $totalPages){
        $EndPage = $totalPages;
    }
}elseif ($nowPage >= $totalPages - 4 && $nowPage <= $totalPages){
    if ($nowPage - 10 > 0){
        $FirstPage = $nowPage - 10;
    }else{
        $FirstPage = 1;
    }
    $EndPage = $totalPages;
}

for ($k = $FirstPage; $k <= $EndPage; $k++){?> 
<? if ($k != $nowPage){?>
<a href="javascript:setHash('schedulelist?<?=$k?>');"><?=$k?></a>
<? }else{?> 
<?=$k?>
<? }?> 
<? }?>
<? if ($nowPage + 4 < $totalPages && $totalPages > 10) echo " ...";?>
</p>
   
</form>