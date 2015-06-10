var thescreenX=window.innerWidth
|| document.documentElement.clientWidth
|| document.body.clientWidth;

var thescreenY=window.innerHeight
|| document.documentElement.clientHeight
|| document.body.clientHeight;

var halfX = thescreenX / 2;
var halfY = thescreenY / 2;


window.onresize = function(){
    thescreenX=window.innerWidth
    || document.documentElement.clientWidth
    || document.body.clientWidth;
    
    thescreenY=window.innerHeight
    || document.documentElement.clientHeight
    || document.body.clientHeight;
    
    halfX = thescreenX / 2;
    halfY = thescreenY / 2;
}

function setHash(theHash){
    
    if (document.getElementById('lastHash').value == ''){
        console.log('1: ' + theHash.substr(1));
        if (theHash.substr(0,1) == "#"){
            document.getElementById('lastHash').value = theHash.substr(1);
        }else{
            document.getElementById('lastHash').value = theHash;
        }
        
        console.log('1: ' + document.getElementById('lastHash').value);
    }else{
        if (theHash.substr(0,1) == "#"){
            document.getElementById('lastHash').value = theHash.substr(1);
        }else{
            document.getElementById('lastHash').value = theHash;
        }
        console.log('2: ' + window.location.hash.substr(1));
        document.getElementById('lastHash').value = window.location.hash.substr(1);
        console.log('2: ' + document.getElementById('lastHash').value);
    }
    
    var tempHash = window.location.hash;
    
    window.location.hash = theHash;
    
    if (tempHash != theHash){
        ga('send', 'pageview', {'page': location.pathname + location.search  + location.hash});
    }
    
    
    
    //var cnzz_protocol = (("https:" == document.location.protocol) ? "https://" : "http://");
    
    //reloadAbleJSFn('analysisjs', cnzz_protocol + 'schedule.guide/analysis.php');
}

function clickCollapseButton(){
    if (document.getElementById('collapsebutton').clientHeight != 0){
        document.getElementById('collapsebutton').click();
    }
}




function getBackHash(){
    var lastHash = document.getElementById('lastHash').value;
    if (lastHash == window.location.hash){
        setHash('index');
    }else{
        setHash(lastHash);
    }
    
    
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




function reloadAbleJSFn(id,newJS){
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
    var username = $('#loginusername').val();
    var password = $('#loginpassword').val();
    var captcha = $('#logincaptcha').val();
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
            document.getElementById("logincaptchaimg").click();
            $('#returnLoginText').html(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
}

function logout(){
    $.ajax({
        type: "GET",
        dataType: "html",
        async:true,
        url: "logout.php",
        success: function(data){
            $('#logoutArea').html(data);
            $('#logoutArea').html("");
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
}


function register(){
    var username = $('#registerusername').val();
    var password = $('#registerpassword').val();
    var confirmpassword = $('#registerconfirmpassword').val();
    var email = $('#registeremail').val();
    var captcha = $('#registercaptcha').val();
    $.ajax({
        type: "POST",
        dataType: "html",
        async:true,
        url: "registerok.php",
        data: {
            username: username,
            password: password,
            confirmpassword: confirmpassword,
            email: email,
            captcha: captcha,
        },
        success: function(data){
            document.getElementById("registercaptchaimg").click();
            $('#returnRegisterText').html(data);
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
            $('#naviNum').val(parseInt($('#naviNum').val()) + parseInt($('#' + side + 'nav').children().length));
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
}

function getModal(filename,title,button,onclick,close){
    $('#' + title + 'Modal').remove();
    paraArray = {};
    for (i = 5; i < arguments.length; i++){
        tempArr = arguments[i];
        tempArrKeys = Object.keys(tempArr);
        paraArray[tempArrKeys[0]] = tempArr[tempArrKeys[0]];
    }
    paraArrayString = JSON.stringify(paraArray);
    $.ajax({
        type: "POST",
        dataType: "html",
        async:false,
        url: "makemodal.php",
        data: {
            file: filename,
            title: title,
            button: button,
            onclick: onclick,
            close: close,
            paraArrayString: paraArrayString
        },
        success: function(data){
            $('#modals').append(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
}

function makedaysarray(){
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
    return dateArray;
}



function getCalendar(){
    var schoolid = $('#schools').val();
    var classes = $('#classes').val();
    var quarter = $('#quarter').val();
    var apiid = $('#api').val();
    $.ajax({
        
        type: "POST",
        dataType: "json",
        async: true,
        url: "api.php",
        
        data: {
            c: classes,
            q: quarter,
            a: apiid,
            s: schoolid
        },
        beforeSend: function(){
            if (classes == '' || quarter == ''){
                alert('You should input at least one class!');
                return false;
            }
            $('#calendarinfo').html('<p class="middle" style="text-align:center">We\'re getting info from school server......</p>');
        },
        success: function(data){
            if (data['error'] != ''){
                alert(data['error']);
                return false;
            }
            
            
            $('#calendarinfo').html('<p class="middle" style="text-align:center">We\'re making all possible class combos......</p>');
            if (data['data'].toString() != [].toString()){
                start = new Date().getTime();
                classArray = generate.makeinitarray(data['data']);
                
                var noEarlierThan = $('#noEarlierThanHour').val() + ':' + $('#noEarlierThanMinute').val() + ':00';
                var noLaterThan = $('#noLaterThanHour').val() + ':' + $('#noLaterThanMinute').val() + ':00';
                classArray = generate.omitearlyandlateclasses(classArray, noEarlierThan, noLaterThan);
                
                if ($('#remainingSeatsOnly').prop('checked')){
                    classArray = generate.omitclasseswithnoseats(classArray);
                }
                
                end = new Date().getTime();
                console.log('make init array: ' + (end - start) / 1000 + "sec");
                $('#calendarinfo').html('<p class="middle" style="text-align:center">We\'re making all possible class combinations in the week......</p>');
                
                start = new Date().getTime();
                generate.makeConflictCache(classArray);
                end = new Date().getTime();
                console.log('make conflict cache: ' + (end - start) / 1000 + "sec");
                
                start = new Date().getTime();
                comboArray = generate.makecomboarray(classArray);
                end = new Date().getTime();
                console.log('make combo array: ' + (end - start) / 1000 + "sec");
                calendarID = 0;
                showSavedCalendar(calendarID);
                $('#saveCalendar').css('display', '');
                
            }else{
                alert('You need to login first, or class doesn\'t exist!');
                $('#calendarinfo').html('');
                $('#saveCalendar').css('display', 'none');
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
            $(element).tooltip({title: event.description,html:true,container:'body'});             
        }
    });
}

function capitalizeFirstLetter(string){
    return string.substring(0, 1).toUpperCase() + string.substring(1);
}

function makeCalendar(calendarID){
    $('#comboNo').html(calendarID+1+'');
    var d = new Date();  
    todayDate = d.getFullYear() + "-" + appendZero(d.getMonth()+1) + "-" + appendZero(d.getDate());
    
    typeArr = ["class", "midterm", "final"];
    
    for (typeID = 0; typeID < typeArr.length; typeID++){
        $('#' + typeArr[typeID] + 'calendar').fullCalendar('removeEvents');
        calendarInit('#' + typeArr[typeID] + 'calendar');
        if(calendarID != -1){
            $('#' + typeArr[typeID] + 'calendar').fullCalendar( 'addEventSource', classInfoArray[calendarID][typeArr[typeID]] );
        }
        $('#' + typeArr[typeID] + 'calendartitle').html(capitalizeFirstLetter(typeArr[typeID]) + ' Calendar');
    }
    
}




function getAPI(schoolid){
    $.ajax({
        type: "GET",
        dataType: "html",
        async:true,
        url: "getapi.php",
        data: {
            schoolid: schoolid
        },
        success: function(data){
            $('#apilist').html(data);
            getQuarter($('#api').val());
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
    
    
}



function getQuarter(apiid){
    var nowSchool = $('#schools').val();
    $.ajax({
        type: "GET",
        dataType: "html",
        async:true,
        url: "getquarter.php",
        data: {
            apiid: apiid,
            schoolid: nowSchool
        },
        success: function(data){
            $('#quarterlist').html(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
}

function saveCalendar(saveType){
    var alias = $("#calendarName").val();
    var id = $('#savedCalendarID').val();
    var calendarData = {};
    var apiid = $('#api').val();
    var quarter = $('#quarter').val();
    var classes = $('#classes').val();
    
    var classLaterThan = $('#noEarlierThanHour').val() + ':' + $('#noEarlierThanMinute').val();
    var classEarlierThan = $('#noLaterThanHour').val() + ':' + $('#noLaterThanMinute').val();
    
    calendarData['classArray'] = JSON.stringify(classArray);
    calendarData['comboArray'] = JSON.stringify(comboArray);
    calendarData['calendarID'] = calendarID;
    calendarData['apiid'] = apiid;
    calendarData['quarter'] = quarter;
    calendarData['classes'] = classes;
    var atLeastSeats;
    if ($('#remainingSeatsOnly').prop('checked')){
        atLeastSeats = $('#atLeastSeats').val().trim();
        if (atLeastSeats == ''){
            atLeastSeats = 1;
        }else{
            atLeastSeats = parseInt(atLeastSeats);
        }
    }else{
        atLeastSeats = 'NaN';
    }
    calendarData['atLeastSeats'] = atLeastSeats;
    
    calendarData['classLaterThan'] = classLaterThan;
    calendarData['classEarlierThan'] = classEarlierThan;
    
    calendarData['option'] = 'nothingselected';
    
    var strCalendarData = LZString.compressToEncodedURIComponent(JSON.stringify(calendarData));
    $.ajax({
        type: "POST",
        dataType: "html",
        async:true,
        url: "saveschedule.php",
        data: {
            alias: alias,
            calendar: strCalendarData,
            id: id,
            type: saveType
        },
        success: function(data){
            $('#returnSaveScheduleInfo').html(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
}



function getSavedCalendar(userID, savedCalendarID, certKey){
    $.ajax({
        type: "POST",
        dataType: "text",
        async:true,
        url: "getsavedschedule.php",
        data: {
            uid: userID,
            id: savedCalendarID,
            certKey: certKey
        },
        success: function(data){
            data = JSON.parse(data);
            content = JSON.parse(LZString.decompressFromEncodedURIComponent(data['content']));
            
            //console.log(content);
            classArray = JSON.parse(content['classArray']);
            comboArray = JSON.parse(content['comboArray']);
            calendarID = content['calendarID'];
            var classes = content['classes'];
            var schoolid = data['schoolid'];
            var apiid = content['apiid'];
            var quarter = content['quarter'];
            var classLaterThanArr = content['classLaterThan'].split(':');
            var classEarlierThanArr = content['classEarlierThan'].split(':');
            var selectOption = content['option'];
            var atLeastSeats = content['atLeastSeats'];
            
            $('#noEarlierThanHour').val(classLaterThanArr[0]);
            $('#noEarlierThanMinute').val(classLaterThanArr[1]);
            $('#noLaterThanHour').val(classEarlierThanArr[0])
            $('#noLaterThanMinute').val(classEarlierThanArr[1]);
            
            $('#classes').val(classes);
            $('#school').val(schoolid);
            $('#quarter').val(quarter);
            $('#api').val(apiid);
            
            if (atLeastSeats != 'NaN'){
                $('#remainingSeatsOnly').prop('checked', true);
                $('#atLeastSeats').val(atLeastSeats);
            }else{
                $('#remainingSeatsOnly').prop('checked', false);
            }
            
            //$('#sortWay').val(selectOption); //给选项按钮预留
            
            
            
            showSavedCalendar(calendarID)
            //$('#returnSaveScheduleInfo').html(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert('error');
            alert(textStatus + errorThrown); 
        } 
    });
}

function showSavedCalendar(calendarID){
    classInfoArray = [];
    var dateArray = makedaysarray();
    if (comboArray.length == 0){
        $('#calendarinfo').html('');
        alert('No available combination. Please try some other classes.');
        return;
    }
    for (i = 0; i < comboArray.length; i++){
        //console.log(comboArray[i]['info']['classconflict']);
        //console.log(i);
        var tempClassInfoArray = {};
        
        
        tempClassInfoArray['class'] = [];
        tempClassInfoArray['midterm'] = [];
        tempClassInfoArray['final'] = [];
        for (j = 0; j < comboArray[i].length; j++){
            nowElement = classArray[comboArray[i][j][0]][comboArray[i][j][1]];
            //console.log(nowElement);
            arrayNowElement = [];
            for( var key in nowElement ) {
                arrayNowElement[key] = nowElement[key];
            }
            for (k = 0; k < arrayNowElement.length; k++){
                if (nowElement[k]['days'] != 'TBA'){
                    daysArray = generate.makedatearray(nowElement[k]['days']);
                    for (l = 0; l < daysArray.length; l++){
                        tempInfoArray = {};
                        
                        tempInfoArray['start'] = dateArray[daysArray[l]] + 'T' + nowElement[k]['startTime'];
                        tempInfoArray['end'] = dateArray[daysArray[l]] + 'T' + nowElement[k]['endTime'];
                        tempInfoArray['title'] = nowElement['coursenumber'] + ' ' + nowElement[k]['meetingType'];
                        if (nowElement[k]['meetingType'] != 'MI' && nowElement[k]['meetingType'] != 'FI'){
                            tempInfoArray['description'] = nowElement['coursenumber'] + '  ' + nowElement[k]['meetingType'] + '<br>' + nowElement[k]['startTime'].substr(0, 5) + ' - ' + nowElement[k]['endTime'].substr(0, 5) + '<br>Section ID: ' + nowElement[k]['sectionID'] + '<br>Section: ' + nowElement[k]['section'] + '<br>Location: ' + nowElement[k]['building'] + ' ' + nowElement[k]['room'] + '<br>Prof: ' + nowElement[k]['prof'];
                            
                            if (nowElement[k]['remainingSeats'] != 'NaN' && nowElement[k]['remainingSeats'] != 'dependent' && nowElement[k]['remainingSeats'] != undefined){
                                tempInfoArray['description'] += '<br>Seat: ' + nowElement[k]['remainingSeats'] + '/' + nowElement[k]['totalSeats'];
                            }
                            
                            tempClassInfoArray['class'].push(tempInfoArray);
                        }else if(nowElement[k]['meetingType'] == 'MI'){
                            tempInfoArray['description'] = nowElement['coursenumber'] + '  ' + nowElement[k]['meetingType'] + '<br>' + nowElement[k]['startTime'].substr(0, 5) + ' - ' + nowElement[k]['endTime'].substr(0, 5) + '<br>Date: ' + nowElement[k]['section'] + '<br>Location: ' + nowElement[k]['building'] + ' ' + nowElement[k]['room'];
                            tempClassInfoArray['midterm'].push(tempInfoArray);
                        }else if(nowElement[k]['meetingType'] == 'FI'){
                            tempInfoArray['description'] = nowElement['coursenumber'] + '  ' + nowElement[k]['meetingType'] + '<br>' + nowElement[k]['startTime'].substr(0, 5) + ' - ' + nowElement[k]['endTime'].substr(0, 5) + '<br>Date: ' + nowElement[k]['section'] + '<br>Location: ' + nowElement[k]['building'] + ' ' + nowElement[k]['room'];
                            tempClassInfoArray['final'].push(tempInfoArray);
                        }
                    }
                }
            }
        }
        classInfoArray.push(tempClassInfoArray);
    }
    
    $('#calendarinfo').html('<button class="btn btn-large btn-danger" id="lastButton" onclick="lastCalendar();">Last</button>&nbsp;Combo:&nbsp;<span id="comboNo">' + (calendarID+1) + '</span>/' + classInfoArray.length + '&nbsp;<button class="btn btn-large btn-danger" id="nextButton" onclick="nextCalendar();">Next</button>');
    
    checkandmake(calendarID);
}


function showSavedCalendarList(page){
    
    
    modalIsShown = ($("#myschedulelistModal").data('bs.modal') || {}).isShown;
    if (modalIsShown == undefined){
        modalIsShown = false;
    }
    if (!modalIsShown){
        getModal('schedulelist','myschedulelist','','',"setHash('generate');",{'page': page});
        $('#myschedulelistModal').modal('show');
    }else{
        $.ajax({
            type: "GET",
            dataType: "html",
            async:true,
            url: "schedulelist.php",
            data: {
                page: page
            },
            success: function(data){
                $('#myschedulelistModalBody').html(data);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) { 
                alert('error');
                alert(textStatus + errorThrown); 
            } 
        });
    }
    
    /*
    */
    
    
    
    //
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