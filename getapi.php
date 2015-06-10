<?php
ini_set('display_errors', 'Off');
require_once('func.php');
echo '<select onchange="getQuarter($(\'#\'+this.id).val());" id="api" class="middle">';

if (isset($_GET['schoolid'])){
    $school = $_GET['schoolid'];
}

if($school == ""){
    echo '<option>' . __('pleaseloginfirst') . '</option>';
}
$query = "SELECT * FROM `apilist` WHERE `schoolid` = ?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("d", $school);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    while($rs = $rsResult->fetch_assoc()){
        if ($rs['id'] == $defaultAPI){
            $isDefault = ' selected="selected"';
        }else{
            $isDefault = '';
        }
        echo '<option' . $isDefault . ' value="' . $rs['id'] . '">' . $rs['alias'] . '</option>';
    }
    $stmt->close();
}
echo '</select>';
?>