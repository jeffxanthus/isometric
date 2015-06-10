<?php
require_once('func.php');
ini_set('display_errors', 'Off');
error_reporting(0);
ini_set('memory_limit','10000M');

$apikey = 'o3ppzaxy6eq8md3but3jc8hsg6qpwwvo7qzsxjrrdcncz7sg93w0cxda2uqog6pa';
$key = $_POST['k'];
if ($key != $apikey){
    echo json_encode(array('error' => 'api key is not correct!'));
    die();
}


$quarter = $_POST['q'];
$course = str_replace(' ', '', $_POST['c']);
$course = str_replace("\n", chr(10), $course);
$course = str_replace(chr(13) . chr(10), chr(10), $course);
$course = strtoupper(str_replace(chr(13), chr(10), $course));
//echo($course);
$tempMappingArray = array();

$courseLineArray = explode(chr(10), $course);



for ($i = 0; $i < count($courseLineArray); $i++){
    $tempInlineArray = explode(',', $courseLineArray[$i]);
    for ($j = 0; $j < count($tempInlineArray); $j++){
        if (!is_array($tempMappingArray[$tempInlineArray[$j]])){
            $tempMappingArray[$tempInlineArray[$j]] = array();
        }
        array_push($tempMappingArray[$tempInlineArray[$j]], $i);
    }
}

//var_dump($tempMappingArray);
$oldCourse = $course;

$course = str_replace(chr(10), ',', $course);





#$quarter="SP15";
#$course="CSE11,MATH20B\nMATH20C\nCSE15\nCSE12\nSDCC4";
#$quarter="FA14";
#$course="MATH20A,LIGM1A\nSDCC1";



$courseArray = explode(chr(10), $course);
$classesInRows = array();




function getVars($htmlstr, $infoLen){
    $html = str_get_html($htmlstr);
    foreach($html->find('tr') as $e){
        $nodes = count($e->children()); //tr里共有多少td
        if ($nodes <= 3){
            return '';
        }
        $realColspan = 0; //真正的tr长度
        $tempClassInfoArray = array();
        for ($i = 0; $i < count($e->children()); $i++){
            $z = $e->children($i);
            $z->colspan==''?$z->colspan=1:$z->colspan=(int)$z->colspan;
            for ($j = 0; $j < $z->colspan; $j++){
                array_push($tempClassInfoArray, trim($z->plaintext));
            }
            $realColspan+=$z->colspan;
            //echo $z->colspan;
        }
        if ($realColspan != $infoLen){
            return '';
        }
        $sectionID = $tempClassInfoArray[2];
        $meetingType = $tempClassInfoArray[3];
        $section = $tempClassInfoArray[4];
        $days = $tempClassInfoArray[5];
        
        if ($days != "TBA"){
            $newStr = "";
            for ($i = 0; $i < strlen($days); $i++){
                if (ord($days[$i]) >= ord("A") && ord($days[$i]) <= ord("Z")){
                    if (($i + 1) < strlen($days) && ord($days[$i+1]) >= ord("a") && ord($days[$i+1]) <= ord("z")){
                        $newStr .= $days[$i] . $days[$i+1];
                    }else{
                        if ($days[$i] == 'S'){
                            $newStr .= "Sa";
                        }else{
                            $newStr .= $days[$i];
                        }
                    }
                }
            }
            $days = $newStr;
        }
        if ($days == 'Ca'){
            return '';
        }
        $time = $tempClassInfoArray[6];
        $timeArr = explode('-', $time);
        $startTime = '';
        $endTime = '';
        if ($time != 'TBA'){
            for ($i = 0; $i<count($timeArr);$i++){
                $timePart = substr($timeArr[$i],-1);
                $timeArr[$i] = substr($timeArr[$i],0,-1);
                
                if ($timePart == 'p'){
                    if (substr($timeArr[$i],0,2)=='12'){
                        $timeArr[$i] = date('H:i:s', strtotime($timeArr[$i]));
                    }else{
                        $timeArr[$i] = strtotime($timeArr[$i].'+ 12 hour');
                        $timeArr[$i] = date('H:i:s', $timeArr[$i]);
                    }
                }else{
                    if (substr($timeArr[$i],0,2)=='12'){
                        $timeArr[$i] = strtotime($timeArr[$i].'- 12 hour');
                        $timeArr[$i] = date('H:i:s', $timeArr[$i]);
                    }else{
                        $timeArr[$i] = date('H:i:s', strtotime($timeArr[$i]));
                    }
                    $timeArr[$i] = date('H:i:s', strtotime($timeArr[$i]));
                }
                $startTime = $timeArr[0];
                $endTime = $timeArr[1];
            }
        }else{
            $startTime = 'TBA';
            $endTime = 'TBA';
        }
        
        
        $building = $tempClassInfoArray[7];
        $room = $tempClassInfoArray[8];
        $prof = str_replace('&nbsp;', '', $tempClassInfoArray[9]);
        return array("section"=>$section, "sectionID"=>$sectionID, "prof"=>$prof, "meetingType"=>$meetingType, "days"=>$days, "startTime"=>$startTime, "endTime"=>$endTime, "building"=>$building, "room"=>$room);
    }
}


function regexamericandate($datestr){
    if (preg_match("/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/",$datestr)){
        return true;
    }else{
        return false;
    }
}


function makecomboarray($initarray){
    $totalArray = array();
    $totalArrayLen = array();
    $totalPossible = 1;
    $arraykeys = array_keys($initarray);
    for ($i = 0; $i < count($arraykeys); $i++){
        $totalArrayLen[$i] = 0;
        $totalPossible *= count($initarray[$arraykeys[$i]]);
    }
    $bigTempArray = array();
    for ($j = 0; $j < $totalPossible; $j++){
        $tempArray = array();
        for ($i = 0; $i < count($arraykeys); $i++){
            if ($totalArrayLen[$i] >= count($initarray[$arraykeys[$i]])){
                $totalArrayLen[$i] = 0;
                if ($i != (count($initarray)-1)){
                    $totalArrayLen[$i+1]++;
                }
            }
            array_push($tempArray, $initarray[$arraykeys[$i]][$totalArrayLen[$i]]);
        }
        $totalArrayLen[0]++;
        array_push($bigTempArray, $tempArray);
    }
    return $bigTempArray;
}

function parseData($html){
    $classArrayTemp=array();
    $sectionNo = 0;
    $i = 0;
    $realInfoColspan = 0;
    //找出信息一共有多少列才对
    foreach($html->find('tr') as $e){
        if ($e->class == 'columnheadertxt'){
            $realInfoColspan = 0;
            for ($i = 0; $i < count($e->children()); $i++){
                $z = $e->children($i);
                $z->colspan==''?$z->colspan=1:$z->colspan=(int)$z->colspan;
                $realInfoColspan+=$z->colspan;
            }
            break;
        }
    }
    $tempCourse = '';
    $tempClassArray = array();
    $allClassArray = array();
    $classNum = -1;
    $tempCourseName = '';
    foreach($html->find('tr') as $e){
        if ($e->class == ''){
            foreach($e->find('h2') as $f){
                foreach($f->find('span') as $g){
                    if ($g->class=='centeralign'){
                        preg_match("/\([A-Z]{2,4}\)/i", strim(trim($g->plaintext)), $matches)?$tempCourseName = $matches[0]:die();
                        $tempCourseName = str_replace('(', '', $tempCourseName);
                        $tempCourseName = str_replace(')', '', $tempCourseName);
                    }
                }
            }
        }
        
        if ($e->class == 'sectxt' || $e->class == 'nonenrtxt'){
            $tempClassArray = getVars($e, $realInfoColspan);
            if ($tempClassArray != ''){
                if ($e->previousSibling() != NULL){
                    if ($e->previousSibling()->children(0)->class == 'crsheader'){
                        $classNum++;
                        $allClassArray[$classNum] = array();
                        $allClassArray[$classNum]['independent'] = array();
                        $allClassArray[$classNum]['dependent'] = array();
                        $allClassArray[$classNum]['others'] = array();
                        $allClassArray[$classNum]['test'] = array();
                        $allClassArray[$classNum]['restrictionID'] = strim($e->previousSibling()->children(0)->plaintext);
                        $e->previousSibling()->children(0)->children(0)===NULL?$allClassArray[$classNum]['restriction']='':$allClassArray[$classNum]['restriction'] = strim($e->previousSibling()->children(0)->children(0)->title);
                        $allClassArray[$classNum]['coursenumber'] = strim($tempCourseName . $e->previousSibling()->children(1)->plaintext);
                        $allClassArray[$classNum]['courseinfo'] = strim($e->previousSibling()->children(2)->plaintext);
                    }
                }
                
                if ($tempClassArray['sectionID'] != ''){ //若有SectID那么只能选一个上，剩下的都是其附属要上的
                    array_push($allClassArray[$classNum]['independent'], $tempClassArray);
                }elseif (!regexamericandate($tempClassArray['section'])){
                    
                    $sameSectionFlag = false;
                    
                    if (!is_array($allClassArray[$classNum]['dependent'][$tempClassArray['meetingType']])){
                        $allClassArray[$classNum]['dependent'][$tempClassArray['meetingType']] = array();
                    }else{
                        for ($i = 0; $i < count($allClassArray[$classNum]['dependent'][$tempClassArray['meetingType']]); $i++){
                            if ($allClassArray[$classNum]['dependent'][$tempClassArray['meetingType']][$i]['section'] == $tempClassArray['section']){
                                array_push($allClassArray[$classNum]['others'], $tempClassArray);
                                array_push($allClassArray[$classNum]['others'], $allClassArray[$classNum]['dependent'][$tempClassArray['meetingType']][$i]);
                                array_splice($allClassArray[$classNum]['dependent'][$tempClassArray['meetingType']], $i, 1);
                                //var_dump($allClassArray[$classNum]);
                                if (count($allClassArray[$classNum]['dependent'][$tempClassArray['meetingType']]) == 0){
                                    unset($allClassArray[$classNum]['dependent'][$tempClassArray['meetingType']]);
                                }
                                $sameSectionFlag = true;
                            }
                        }
                    }
                    if ($sameSectionFlag == false){
                        array_push($allClassArray[$classNum]['dependent'][$tempClassArray['meetingType']], $tempClassArray);
                    }
                    
                    $sameSectionFlag = false;
                }elseif (regexamericandate($tempClassArray['section'])){
                    array_push($allClassArray[$classNum]['others'], $tempClassArray);
                }
            }
        }
    }
    
    $newClassArray = array();
    for ($i = 0; $i < count($allClassArray); $i++){
        $combinations = makecomboarray($allClassArray[$i]['dependent']);
        $newTempClassArray = array();
        $newTempClassArray['independent'] = array();
        $newTempClassArray['restrictionID'] = $allClassArray[$i]['restrictionID'];
        $newTempClassArray['coursenumber'] = $allClassArray[$i]['coursenumber'];
        $newTempClassArray['courseinfo'] = $allClassArray[$i]['courseinfo'];
        
        $newTempClassArray['independent'] = $allClassArray[$i]['independent'];
        for ($j = 0; $j < count($combinations); $j++){
            $newTempClassArray['dependent'] = array();
            for ($k = 0; $k < count($combinations[$k]); $k++){
                array_push($newTempClassArray['dependent'], $combinations[$j][$k]);
            }
            /*echo(count($combinations[$k]) + '<br>');
            echo(count($allClassArray[$i]['dependent']['others']) + '<br>');
            
            var_dump($combinations[$k]);*/
            //var_dump($allClassArray[$i]['dependent']);
            for ($l = 0; $l < count($allClassArray[$i]['others']); $l++){
                array_push($newTempClassArray['dependent'], $allClassArray[$i]['others'][$l]);
            }
            array_push($newClassArray, $newTempClassArray);
        }
    }
    return $newClassArray;
}






//echo($course);
//foreach ($courseArray as $tempCourse) {
    $var="selectedTerm=$quarter&xsoc_term=&loggedIn=false&tabNum=tabs-crs&_selectedSubjects=1&schedOption1=true&_schedOption1=on&schedOption11=true&_schedOption11=on&schedOption12=true&_schedOption12=on&schedOption2=true&_schedOption2=on&schedOption4=true&_schedOption4=on&schedOption5=true&_schedOption5=on&_schedOption3=on&_schedOption7=on&_schedOption8=on&_schedOption13=on&_schedOption10=on&_schedOption9=on&schDay=M&_schDay=on&schDay=T&_schDay=on&schDay=W&_schDay=on&schDay=R&_schDay=on&schDay=F&_schDay=on&schDay=S&_schDay=on&schStartTime=12%3A00&schStartAmPm=0&schEndTime=12%3A00&schEndAmPm=0&_selectedDepartments=1&schedOption1Dept=true&_schedOption1Dept=on&_schedOption11Dept=on&_schedOption12Dept=on&schedOption2Dept=true&_schedOption2Dept=on&_schedOption4Dept=on&_schedOption5Dept=on&_schedOption3Dept=on&_schedOption7Dept=on&_schedOption8Dept=on&_schedOption13Dept=on&_schedOption10Dept=on&_schedOption9Dept=on&schDayDept=M&_schDayDept=on&schDayDept=T&_schDayDept=on&schDayDept=W&_schDayDept=on&schDayDept=R&_schDayDept=on&schDayDept=F&_schDayDept=on&schDayDept=S&_schDayDept=on&schStartTimeDept=12%3A00&schStartAmPmDept=0&schEndTimeDept=12%3A00&schEndAmPmDept=0&courses=$course&sections=&instructorType=begin&instructor=&titleType=contain&title=&hideFullSec=true&_hideFullSec=on&_showPopup=on";
        $url="https://act.ucsd.edu/scheduleOfClasses/scheduleOfClassesStudentResult.htm";
        $header = array('Cookie: ','');
        $response = curl_open($url, 'POST', $var, $header, '', true, true);
        if (strpos($response[0], 'No Result Found. Try another search.') != NULL){
            $notExistArray = array();
            $notExistArray["coursenumber"] = $tempCourse;
            $notExistArray["independent"] = array();
            $notExistArray["dependent"] = array();
        }else{
            $url="https://act.ucsd.edu/scheduleOfClasses/scheduleOfClassesStudentResultPrint.htm";
            $header = array('Cookie: ' . $response[1],'');
            $response = curl_open($url, 'GET', $var, $header, '', true, true);
            $html = str_get_html($response[0]);
            //echo($html);
            //array_push($classesInRows, parseData($html));
            $classesInRows = parseData($html);
        }
//}

$finalArray = array();

for ($i = 0; $i < count($classesInRows); $i++){
    for ($j = 0; $j < count($tempMappingArray[$classesInRows[$i]['coursenumber']]); $j++){
        if (!is_array($finalArray[(int)$tempMappingArray[$classesInRows[$i]['coursenumber']][$j]])){
            $finalArray[(int)$tempMappingArray[$classesInRows[$i]['coursenumber']][$j]] = array();
        }
        array_push($finalArray[(int)$tempMappingArray[$classesInRows[$i]['coursenumber']][$j]], $classesInRows[$i]);
    }
    
}

ksort($finalArray);
$trueFinalArray = array();
$trueFinalArray['data'] = array();
$finalArrayKeys = array_keys($finalArray);

for ($i = 0; $i < count($finalArrayKeys); $i++){
    if (count($finalArray[$finalArrayKeys[$i]]) != 0){
        array_push($trueFinalArray['data'], $finalArray[$finalArrayKeys[$i]]);
    }
}


$trueFinalArray['error'] = '';
$trueFinalArray['notice'] = '';

echo(json_encode($trueFinalArray));
die();
?>