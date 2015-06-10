<?php
require_once('func.php');
echo '<select id="quarter" class="middle">';
if (isset($_GET['schoolid'])){
    $school = $_GET['schoolid'];
}

if (isset($_GET['apiid'])){
    $apiid = $_GET['apiid'];
}else{
    $apiid = $defaultAPI;
}



$query = "SELECT * FROM `apilist` WHERE `schoolid` = ? AND `id` = ?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("dd", $school, $apiid);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    if ($rs = $rsResult->fetch_assoc()){
        $quarterArr = explode('|', $rs['quarter']);
        for ($i = 0; $i < count($quarterArr); $i++){
            if ($quarterArr[$i] != ''){
                $tempArray = explode('-', $quarterArr[$i]);
                echo '<option value="' . $tempArray[0] . '">' . $tempArray[1] . '</option>';
            }
        }
    }elseif($_SESSION['school'] == ""){
        echo '<option>' . __('pleaseloginfirst') . '</option>';
    }else{
        echo '<option>' . __('thisisanerrorcontactadmin') . '</option>';
    }
    $stmt->close();
}
echo '</select>';
?>