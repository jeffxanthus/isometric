var screenX=window.innerWidth
|| document.documentElement.clientWidth
|| document.body.clientWidth;

var screenY=window.innerHeight
|| document.documentElement.clientHeight
|| document.body.clientHeight;

var halfX = screenX / 2;
var halfY = screenY / 2;


window.onresize = function(){
    screenX=window.innerWidth
    || document.documentElement.clientWidth
    || document.body.clientWidth;
    
    screenY=window.innerHeight
    || document.documentElement.clientHeight
    || document.body.clientHeight;
    
    halfX = screenX / 2;
    halfY = screenY / 2;
}

function setHash(theHash){
    window.location.hash = theHash;
    if (document.getElementById('collapsebutton').clientHeight != 0){
        document.getElementById('collapsebutton').click();
    }
    var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    
    //reloadAbleJSFn('analysisjs', cnzz_protocol + 's95.cnzz.com/stat.php?id=1253048431&web_id=1253048431');
}

function changeHash(theHash){
    window.location.hash = theHash;
}


function selectDate(id){
    if(WdatePicker()!=true){
    }
    document.getElementById(id).blur();
    //document.getElementById('testlabel').focus();
    
}




function reloadAbleJSFn(id,newJS)
{
    //http://www.php100.com/html/webkaifa/javascript/2008/1007/1519.html
    var oldjs = null;
    var t = null;
    var oldjs = document.getElementById(id);
    if(oldjs) oldjs.parentNode.removeChild(oldjs);
    var scriptObj = document.createElement("script");
    scriptObj.src = newJS;
    scriptObj.type = "text/javascript";
    scriptObj.id   = id;
    document.getElementsByTagName("head")[0].appendChild(scriptObj);
}





function changeActiveStatus(listid) {
    for (i = 0; i<document.getElementById('naviNum').value; i++){
        if (document.getElementById('navid' + i).className == "active"){
			document.getElementById('lastNaviID').value = 'navid' + i;
			//alert('navid' + i);
		}
        document.getElementById('navid' + i).className="";
    }
    document.getElementById('navid' + listid).className="active";
}

function changeActiveStatusByName(theName) {
    for (i = 0; i<document.getElementById('naviNum').value; i++){
        if (document.getElementById('navid' + i).className == "active" && document.getElementById('lastNaviID').value != ('navid' + i)){
            document.getElementById('lastNaviID').value = 'navid' + i;
            //alert('navid' + i);
        }
        document.getElementById('navid' + i).className="";
    }
    var nameThings;
    nameThings = document.getElementsByTagName('li');
    for (i = 0; i<nameThings.length; i++){
        //alert(nameThings[i].attributes['data-name'].nodeValue);
        if (nameThings[i].attributes['data-name'].nodeValue == theName){
            nameThings[i].className = "active";
            break;
        }
    }
}
var lastHash = '';

function getBackHash(){
    var allHash = document.getElementById('thelasthash').value;
    var hashArray = Array();
    hashArray = allHash.split("|");
    if (hashArray[hashArray.length - 1] != ''){
        window.location.hash = hashArray[hashArray.length - 2];
    }else{
        window.location.hash = "mainpage";
    }
    document.getElementById('thelasthash').value = '';
    for (i = 0; i < hashArray.length - 1; i++){
        if (document.getElementById('thelasthash').value != ''){
            document.getElementById('thelasthash').value = document.getElementById('thelasthash').value + '|' + hashArray[i];
        }else{
            document.getElementById('thelasthash').value = hashArray[i];
        }
    }
}



function searchRequest(){
    var SearchString = document.getElementById('SearchString').value;
    for (i=1; i<=9; i++){
        if (document.getElementById('SearchType' + i).checked == true){
            var SearchType = document.getElementById('SearchType' + i).value;
            break;
        }
    }
    setHash('search?' + SearchType + '?' + SearchString + '?1');
    //getEditFloat("search.php?SearchString=" + SearchString + "&SearchType=" + SearchType, 'mainPage');
}


function goToPage(pagenum, pagename, region, method){
    if (pagename.indexOf('?') != -1){
        var connectchar = '&';
    }else{
        var connectchar = '?';
    }
    
    if (method == 'getEditFloat'){
        getEditFloat(pagename + connectchar + 'page=' + pagenum, region);
    }else if(method == 'getWebpage'){
        getWebpage(pagename + connectchar + 'page=' + pagenum);
    }
}



function getid(str){
    var myselect=document.getElementById(str);
    var index=myselect.selectedIndex ;
    var thevalue=myselect.options[index].value;
    var thetext=myselect.options[index].text; 
    var theid=myselect.options[index].id; 
    return theid;
}

function getvalue(str){
    var myselect=document.getElementById(str);
    var index=myselect.selectedIndex ;
    var thevalue=myselect.options[index].value;
    var thetext=myselect.options[index].text; 
    var theid=myselect.options[index].id; 
    return thevalue;
}

function getWebpage(str) {
$.ajax({
    type: "GET",
    dataType: "html",
    async: true,
    url: str,
    success: function(data){
        $('#mainArea').html(data);
        return false;
    },
     error: function (XMLHttpRequest, textStatus, errorThrown) { 
        alert(errorThrown); 
    } 
});
}

function login(){
    var username = $('#username').val();
    var password = $('#password').val();
    var captcha = $('#captcha').val();
    $.ajax({
        type: "POST",
        dataType: "html",
        async:true,
        url: "loginto.php",
        data: {
            username: username,
            password: password,
            captcha: captcha,
        },
        success: function(data){
            document.getElementById("captchaimg").click();
            $('#returnText').html(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
}


function makeMenu(side){
    var i = $('#naviNum').val();
    $.ajax({
        type: "POST",
        dataType: "html",
        async:false,
        url: "makemenu.php",
        data: {
            side: side,
            i: i,
        },
        success: function(data){
            $('#' + side + 'nav').html(data);
            $('#naviNum').val($('#' + side + 'nav').children().length);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
}


function getCalendar(){
    $.ajax({
        
        type: "POST",
        dataType: "json",
        async: true,
        url: "api.php",
        
        data: {
            c: $('#classes').val(),
            q: $('#quarter').val()
        },
        beforeSend: function(){
            $('#calendarinfo').html('<p class="middle" style="text-align:center">We\'re getting info from school server......</p>');
        },
        success: function(data){
            $('#calendarinfo').html('<p class="middle" style="text-align:center">We\'re making all possible class combos......</p>');
            var tempDateArray = [];
            var dateArray = [];
            
            var today = new Date();
            var nowDay = today.getDate();
            var nowMonth = today.getMonth() + 1;
            var nowYear = today.getFullYear();
            
            if(nowMonth < 10){  
                nowMonth = "0" + nowMonth;  
            }
            if(nowDay < 10){  
                nowDay = "0" + nowDay;  
            }
            
            for (i = 0; i < 7; i++){
                tempDate = new Date(today);
                tempDate.setDate(tempDate.getDate() - (today.getDay() - i));
                var tempDay = tempDate.getDate();
                var tempMonth = tempDate.getMonth() + 1;
                var tempYear = tempDate.getFullYear();
                
                if(tempMonth < 10){  
                    tempMonth = "0" + tempMonth;  
                }   
                if(tempDay < 10){  
                    tempDay = "0" + tempDay;  
                } 
                tempDateArray[i] = tempYear + '-' + tempMonth + '-' + tempDay;
            }
            
            dateArray['Su'] = tempDateArray[0];
            dateArray['M'] = tempDateArray[1];
            dateArray['Tu'] = tempDateArray[2];
            dateArray['W'] = tempDateArray[3];
            dateArray['Th'] = tempDateArray[4];
            dateArray['F'] = tempDateArray[5];
            dateArray['Sa'] = tempDateArray[6];
            
            classInfoArray = [];
            if (data.toString() != [].toString()){
                start = new Date().getTime();
                classArray = generate.makeinitarray(data);
                end = new Date().getTime();
                console.log('makeinitarray: ' + (end - start) / 1000 + "sec");
                $('#calendarinfo').html('<p class="middle" style="text-align:center">We\'re making all possible class combinations in the week......</p>');
                
                start = new Date().getTime();
                generate.makeConflictCache(classArray);
                end = new Date().getTime();
                console.log('makecomboarray: ' + (end - start) / 1000 + "sec");
                
                start = new Date().getTime();
                comboArray = generate.makecomboarray(classArray);
                end = new Date().getTime();
                console.log('makecomboarray: ' + (end - start) / 1000 + "sec");
                for (i = 0; i < comboArray.length; i++){
                    
                    if (comboArray[i]['info']['classconflict'] == 0 && comboArray[i]['info']['midtermconflict'] == 0 && comboArray[i]['info']['finalconflict'] == 0 && comboArray[i]['info']['midtermconflictwithclass'] == 0){
                        //console.log(comboArray[i]['info']['classconflict']);
                        //console.log(i);
                        var tempClassInfoArray = [];
                        tempClassInfoArray['class'] = [];
                        tempClassInfoArray['midterm'] = [];
                        tempClassInfoArray['final'] = [];
                        for (j = 0; j < comboArray[i].length; j++){
                            
                            for (k = 0; k < comboArray[i][j].length; k++){
                                if (comboArray[i][j][k]['days'] != 'TBA'){
                                    daysArray = generate.makedatearray(comboArray[i][j][k]['days']);
                                    for (l = 0; l < daysArray.length; l++){
                                        tempInfoArray = [];
                                        
                                        tempInfoArray['start'] = dateArray[daysArray[l]] + 'T' + comboArray[i][j][k]['startTime'];
                                        tempInfoArray['end'] = dateArray[daysArray[l]] + 'T' + comboArray[i][j][k]['endTime'];
                                        tempInfoArray['title'] = comboArray[i][j]['coursenumber'] + ' ' + comboArray[i][j][k]['meetingType'];
                                        if (comboArray[i][j][k]['meetingType'] != 'MI' && comboArray[i][j][k]['meetingType'] != 'FI'){
                                            tempInfoArray['description'] = comboArray[i][j]['coursenumber'] + '\n' + comboArray[i][j][k]['meetingType'] + '\nSection ID: ' + comboArray[i][j][k]['sectionID'] + '\nSection: ' + comboArray[i][j][k]['section'] + '\nLocation: ' + comboArray[i][j][k]['building'] + ' ' + comboArray[i][j][k]['room'] + '\nProf: ' + comboArray[i][j][k]['prof'];
                                            tempClassInfoArray['class'].push(tempInfoArray);
                                        }else if(comboArray[i][j][k]['meetingType'] == 'MI'){
                                            tempInfoArray['description'] = comboArray[i][j]['coursenumber'] + '\n' + comboArray[i][j][k]['meetingType'] + '\nDate: ' + comboArray[i][j][k]['section'] + '\nLocation: ' + comboArray[i][j][k]['building'] + ' ' + comboArray[i][j][k]['room'];
                                            tempClassInfoArray['midterm'].push(tempInfoArray);
                                        }else if(comboArray[i][j][k]['meetingType'] == 'FI'){
                                            tempInfoArray['description'] = comboArray[i][j]['coursenumber'] + '\n' + comboArray[i][j][k]['meetingType'] + '\nDate: ' + comboArray[i][j][k]['section'] + '\nLocation: ' + comboArray[i][j][k]['building'] + ' ' + comboArray[i][j][k]['room'];
                                            tempClassInfoArray['final'].push(tempInfoArray);
                                        }
                                    }
                                }
                            }
                        }
                        classInfoArray.push(tempClassInfoArray);
                    }
                }
                calendarID = 0;
                $('#calendarinfo').html('<button class="btn btn-large btn-danger" id="lastButton" onclick="lastCalendar();">Last</button>&nbsp;Combination:&nbsp;<span id="comboNo">' + (calendarID+1) + '</span>/' + classInfoArray.length + '&nbsp;<button class="btn btn-large btn-danger" id="nextButton" onclick="nextCalendar();">Next</button>');
                
                checkandmake(calendarID);
            }else{
                alert('You need to login first, or class doesn\'t exist!');
                $('#calendarinfo').html('');
            }
        },
        
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert(errorThrown);
            return false;
        }
    });
}

function checkandmake(calendarID){
    if (calendarID == 0){
        $('#lastButton').prop('disabled', true);
    }else{
        $('#lastButton').prop('disabled', false);
    }
    if (calendarID == classInfoArray.length-1){
        $('#nextButton').prop('disabled', true);
    }else{
        $('#nextButton').prop('disabled', false);
    }
    $('#comboNo').html(calendarID+1+'');
    makeCalendar(calendarID);
}


function lastCalendar(){
    calendarID--;
    checkandmake(calendarID);
}

function nextCalendar(){
    calendarID++;
    checkandmake(calendarID);
}


function appendZero(s){return ("00" + s).substr((s + "").length);}

function calendarInit(calendarDIV){
    $(calendarDIV).fullCalendar({
        header: {
            left: '',
            center: 'Weekdays',
            right: '',
        },
        defaultDate: todayDate,
        defaultView: 'agendaWeek',
        allDaySlot: false,
        editable: false,
        minTime: '7:00',
        maxTime: '22:00',
        eventLimit: true, // allow "more" link when too many events
        columnFormat: {
            week: 'dd',
        },
        height: 'auto',
        eventRender: function(event, element) {
            $(element).tooltip({title: event.description});             
        }
    });
}

function capitalizeFirstLetter(string){
    return string.substring(0, 1).toUpperCase() + string.substring(1);
}

function makeCalendar(calendarID){
    
    var d = new Date();  
    todayDate = d.getFullYear() + "-" + appendZero(d.getMonth()+1) + "-" + appendZero(d.getDate());
    
    typeArr = ["class", "midterm", "final"];
    
    for (typeID = 0; typeID < typeArr.length; typeID++){
        $('#' + typeArr[typeID] + 'calendar').fullCalendar('removeEvents');
        calendarInit('#' + typeArr[typeID] + 'calendar');
        $('#' + typeArr[typeID] + 'calendar').fullCalendar( 'addEventSource', classInfoArray[calendarID][typeArr[typeID]] );
        $('#' + typeArr[typeID] + 'calendartitle').html(capitalizeFirstLetter(typeArr[typeID]) + ' Calendar');
    }
}

function submitEditReadme(){
    var AddDate = document.getElementById('AddDate').value;
    var SmallComment = document.getElementById('SmallComment').value;
    var ReadMe = document.getElementById('ReadMe').value;
    var testlabel = document.getElementById('testlabel').value;
    var id = document.getElementById('id').value;
    var postStr = "AddDate=" + AddDate + "&SmallComment=" + SmallComment + "&ReadMe=" + ReadMe + "&testlabel=" + testlabel + "&id=" + id;
    
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById('returnValue').innerHTML = xmlhttp.responseText;
            document.getElementById('submitbutton').disabled = false;
        } else {
            document.getElementById('returnValue').innerHTML = "正在保存……";
        }
    }
    xmlhttp.open("POST", "editreadmeok.php", true);
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlhttp.send(postStr);
    return false;
}

function submitAddReadme(){
    var AddDate = document.getElementById('AddDate').value;
    var SmallComment = document.getElementById('SmallComment').value;
    var ReadMe = document.getElementById('ReadMe').value;
    var testlabel = document.getElementById('testlabel').value;
    var postStr = "AddDate=" + AddDate + "&SmallComment=" + SmallComment + "&ReadMe=" + ReadMe + "&testlabel=" + testlabel;
    
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById('returnValue').innerHTML = xmlhttp.responseText;
            document.getElementById('submitbutton').disabled = false;
        } else {
            document.getElementById('submitbutton').disabled = true;
            document.getElementById('returnValue').innerHTML = "正在保存……";
        }
    }
    xmlhttp.open("POST", "addreadmeok.php", true);
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlhttp.send(postStr);
    return false;
}







function stringToJson(stringValue)
{
   eval("var theJsonValue = "+stringValue);
   return theJsonValue;
}



function scrolltoobj(obj) {
    var objid=document.getElementById(obj);
    var objy=objid.offsetTop;  
    var objx=objid.offsetLeft;  
    var height=objid.offsetHeight;  
    while(objid=objid.offsetParent) {  
        objy+=objid.offsetTop;  
        objx+=objid.offsetLeft;  
    }
    window.scrollTo(objx, objy);
}