<?php

require_once('func.php');
ini_set('display_errors', 'Off');
$school = $_SESSION['school'];

$defaultSchool = 1;
$defaultAPI = 0;

$query = "SELECT * FROM `school` WHERE `id` = ?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param("d", $school);
    $stmt->execute();
    $rsResult = $stmt->get_result();
    if ($rs = $rsResult->fetch_assoc()){
        $defaultAPI = $rs['defaultapi'];
    }
    $stmt->close();
}



?>
<style>
.middlediv {
    margin: 10px auto;
    padding: 0 10px;
    vertical-align: middle;
}


#getinfo {
    margin: 10px auto;
    padding: 0 10px;
    
}

#calendars {
    margin: 10px auto;
    padding: 0 10px;
}
</style>
<br>
<div id="" class="normal-form" style="width: 98%">
    <input type="hidden" id="defaultAPI" value=""/>
    <input type="hidden" id="savedCalendarID" value=""/>
    <div id='getinfo' class="middlediv">
        <?php if($_SESSION['Login'] == 'OK'){
            
        ?>
        <p>
            <h4>Open from a saved one</h4>
            <button class="middle btn btn-large btn-danger" onclick="setHash('schedulelist?1');">Show</button>
        </p>
        <?php }?>
        <p>
            <h4>Please select a school</h4>
            <div id="schoollist">
                <?php include('getschool.php');?>
            </div>
        </p>
        <p>
            <h4>Please select an API</h4>
            <div id="apilist">
                <?php include('getapi.php');?>
            </div>
        </p>
        <p>
        <h4>Please input class you want to arrange</h4>
        <div id="quarterlist">
            <?php include('getquarter.php');?>
        </div>
        </p>
        <p>
        <textarea id="classes" style="height: 200px"></textarea>
        </p>
        <p>
        <button class="middle btn btn-large btn-danger" onclick="getCalendar();">Get</button>
        </p>
        
        <div class="row middlediv" id="saveCalendar" style="width:80%;display:none;margin-top:30px;">
            <div class="input-group">
                <input placeholder="Alias of calendar" id="calendarName" type="text" class="input-block-level form-control"/>
                <span class="input-group-btn">
                    <button class="middle btn btn-large btn-default" onclick="saveCalendar('new');">Save</button>
                </span>
            </div>
        </div>
        <div class="row middlediv" id="updateCalendar" style="width:80%;display:none;">
            <button class="middle btn btn-large btn-default" onclick="saveCalendar('update');">Save to current calendar</button>
        </div>
        <br>
        <span id="returnSaveScheduleInfo"></span>
        
        <div class="row middlediv" id="advancedOptions">
            <div id="timeLimit">
                <p>Only choose class</p>
                <p>
                    Starts Later Than:
                    <br><select id="noEarlierThanHour"></select><b> : </b><select id="noEarlierThanMinute"></select>
                </p>
                <p>
                    Ends Earlier Than:
                    <br><select id="noLaterThanHour"></select><b> : </b><select id="noLaterThanMinute"></select>
                </p>
            </div>
            <br>
            <div id="seatLimit">
                
                <form class="form-inline">
                  <div class="form-group">
                    Only choose classes with at least:
                    <div class="row">
                    <div class="col-xs-12">
                    <div class="input-group">
                      <div class="input-group-addon"><input type="checkbox" id="remainingSeatsOnly" value="" onclick=""></div>
                      <input placeholder="-5=wl5, default 1" id="atLeastSeats" type="text" class="form-control">
                      <div class="input-group-addon">Seats</div>
                    </div>
                    </div>
                    </div>
                  </div>
                  
                </form>
                
                
            </div>
            
        </div>
        
        
        
    </div>
    <div id='calendars'>
        <div id="calendarinfo"></div>
        
        <div>
            <div id="classcalendartitle"></div>
            <div id="classcalendar"></div>
        </div>
        <hr id="hr1" style="visibility: hidden;">
        <div>
            <div id="midtermcalendartitle"></div>
            <div id="midtermcalendar"></div>
        </div>
        <hr id="hr2" style="visibility: hidden;">
        <div>
            <div id="finalcalendartitle"></div>
            <div id="finalcalendar"></div>
        </div>
    </div>
</div>
<script>
function fluid(){
    thescreenX=window.innerWidth
    || document.documentElement.clientWidth
    || document.body.clientWidth;
    
    thescreenY=window.innerHeight
    || document.documentElement.clientHeight
    || document.body.clientHeight;
    
    halfX = thescreenX / 2;
    halfY = thescreenY / 2;
    
    if (thescreenX < 768){
        $('#getinfo').css('float', 'none');
        $('#calendars').css('float', 'none');
        $('#getinfo').css('width', '');
        $('#calendars').css('width', '100%');
        $('#saveCalendar').css('width', '80%');
    }
    
    if (thescreenX >= 768){
        $('#getinfo').css('float', 'left');
        $('#calendars').css('float', 'right');
        $('#getinfo').css('width', '40%');
        $('#calendars').css('width', '60%');
        $('#saveCalendar').css('width', '60%');
    }
}

$(window).resize(fluid);
window.onload = fluid();
window.onload = makeCalendar(-1);

function makeSelectTime(){
    
    for (var i = 0; i <= 24; i++){
        var temp;
        if (i < 10){
            temp = '0' + '' + i;
        }else{
            temp = i;
        }
        
        $('#noEarlierThanHour').append($("<option></option>").attr("value",temp).text(temp));
        $('#noLaterThanHour').append($("<option></option>").attr("value",temp).text(temp));
    }
    
    $('#noLaterThanHour').val('24');
    
    for (var i = 0; i <= 59; i++){
        
        var temp;
        if (i < 10){
            temp = '0' + '' + i;
        }else{
            temp = i;
        }
        
        $('#noEarlierThanMinute').append($("<option></option>").attr("value",temp).text(temp));
        $('#noLaterThanMinute').append($("<option></option>").attr("value",temp).text(temp));
    }
}
window.onload = makeSelectTime();
</script>
    
    