<?php
ini_set('display_errors', 'Off');
require_once('func.php');
$selectString = '<select onchange="getAPI($(\'#\'+this.id).val());" id="schools" class="middle">';
$defaultAPI = 0;

if (isset($_SESSION['school'])){
    $school = $_SESSION['school'];
}else{
    $school = $defaultSchool;
}

$query = "SELECT * FROM `school`";
if ($stmt = $mysqli->prepare($query)){
    $stmt->execute();
    $rsResult = $stmt->get_result();
    while($rs = $rsResult->fetch_assoc()){
        if ($rs['id'] == $school){
            $isDefault = ' selected="selected"';
        }else{
            $isDefault = '';
        }
        $selectString .= '<option' . $isDefault . ' value="' . $rs['id'] . '">' . $rs['acronym'] . ' (' . $rs['schoolname'] . ')' . '</option>';
        $defaultAPI = $rs['defaultapi'];
    }
    $stmt->close();
}

$selectString .= '</select>';

$selectString .= '<script>$("#defaultAPI").val(' . $defaultAPI . ');</script>';

echo $selectString;
?>

