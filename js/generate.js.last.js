function strlen(str){
    return str.length;
}
function ord(str){
    if (str.length > 1){
        return null;
    }else{
        return str.charCodeAt(0);
    }
}
function echo(str){
    console.log(str);
}

function s(){
    
}
s.prototype = {
    arraycopy: function(src, srcPos, dest, destPos, length){
        if (dest == null || src == null){
            console.error("NullPointerException");
        }
        if ((src.constructor+'').match(/\ Array\(\)/) == null || (dest.constructor+'').match(/\ Array\(\)/) == null){
            console.error("ArrayStoreException");
        }
        
    },
    out: {
        println: function(data){
            console.log(data);
        },
        print: function(data){
            console.log(data);
        }
    }
}
var System = new s;
function Generate(){
    
}
Generate.prototype = {
    cir: 0,
    dateArrayCache: [],
    dateConflictCache: [],
    dateTimeConflictCache: [],
    classConflictCache: [],
    
    totalCallTime: 0,
    
    dateArrayCacheNum: 0,
    dateConflictCacheNum: 0,
    dateTimeConflictCacheNum: 0,
    classConflictCacheNum: 0,
    makeinitarray: function(data){
        var classArray = [];
        for(i = 0; i < data.length; i++){
            classArray.push([])
            var hadGone = 0;
            for(j = 0; j < data[i].length; j++){
                for(k = 0; k < data[i][j]["independent"].length; k++){
                    //echo(data[i][j]["independent"][k]);
                    classArray[i].push([data[i][j]["independent"][k]]);
                    classArray[i][hadGone]["courseinfo"] = data[i][j]["courseinfo"];
                    classArray[i][hadGone]["coursenumber"] = data[i][j]["coursenumber"];
                    for (l = 0; l < data[i][j]["dependent"].length; l++){
                        classArray[i][hadGone].push(data[i][j]["dependent"][l]);
                    }
                    hadGone++;
                }
            }
        }
        return classArray;
    },
    
    
    checkClassConflict: function(initarray, element1cursor, element2cursor){
        
        infoArray = [];
        infoArray['classconflict'] = 0; //冲突时间
        infoArray['classconflicttime'] = 0; //冲突时间
        infoArray['resttime'] = 0; //休息时间
        infoArray['totaldaytime'] = 0; //一共用的全天时间
        infoArray['totaldays'] = 0; //需要上课天数
        infoArray['midtermconflict'] = 0; //期中考试的冲突次数
        infoArray['midtermconflicttime'] = 0; //期中考试的冲突时间
        infoArray['midtermconflictwithclass'] = 0; //期中考试与正常上课冲突次数
        infoArray['midtermconflictwithclasstime'] = 0; //期中考试与正常上课冲突次数
        infoArray['finaldays'] = 0; //期末考试天数
        infoArray['finalhours'] = 0; //期末考试总小时数
        infoArray['finalconflict'] = 0; //期末考试冲突次数
        infoArray['finalconflicttime'] = 0; //期末考试冲突时间
        infoArray['classTBAs'] = 0;
        infoArray['midtermTBAs'] = 0;
        infoArray['finalTBAs'] = 0;
        
        newelement1 = initarray[element1cursor[0]][element1cursor[1]];
        newelement2 = initarray[element2cursor[0]][element2cursor[1]];
        
        for (l = 0; l < newelement1.length; l++){
            for (m = 0; m < newelement2.length; m++){
                this.cir++;
                if (newelement1[l]['meetingType'] != 'MI' && newelement1[l]['meetingType'] != 'FI' && newelement2[m]['meetingType'] != 'MI' && newelement2[m]['meetingType'] != 'FI'){
                    checkResult = this.checkdatetimeconflict(newelement1[l]['days'], newelement2[m]['days'], newelement1[l]['startTime'], newelement1[l]['endTime'], newelement2[m]['startTime'], newelement2[m]['endTime']);
                    if (checkResult == 'TBA'){
                        infoArray['classTBAs']++;
                    }else if(checkResult == true){
                        infoArray['classconflict']++;
                    }
                }else if(newelement1[l]['meetingType'] == 'MI' && newelement2[m]['meetingType'] == 'MI'){
                    checkResult = this.checkdatetimeconflict(newelement1[l]['section'], newelement2[m]['section'], newelement1[l]['startTime'], newelement1[l]['endTime'], newelement2[m]['startTime'], newelement2[m]['endTime']);
                    if (checkResult == 'TBA'){
                        infoArray['midtermTBAs']++;
                    }else if(checkResult == true){
                        infoArray['midtermconflict']++;
                    }
                }else if(newelement1[l]['meetingType'] == 'FI' && newelement2[m]['meetingType'] == 'FI'){
                    checkResult = this.checkdatetimeconflict(newelement1[l]['section'], newelement2[m]['section'], newelement1[l]['startTime'], newelement1[l]['endTime'], newelement2[m]['startTime'], newelement2[m]['endTime']);
                    if (checkResult == 'TBA'){
                        infoArray['finalTBAs']++;
                    }else if(checkResult == true){
                        infoArray['finalconflict']++;
                    }
                }else if(((newelement1[l]['meetingType'] != 'MI' && newelement1[l]['meetingType'] != 'FI') && newelement2[m]['meetingType'] == 'MI') || (newelement1[l]['meetingType'] == 'MI' && (newelement2[m]['meetingType'] != 'MI' && newelement2[m]['meetingType'] != 'FI'))){
                    checkResult = this.checkdatetimeconflict(newelement1[l]['days'], newelement2[m]['days'], newelement1[l]['startTime'], newelement1[l]['endTime'], newelement2[m]['startTime'], newelement2[m]['endTime']);
                    if (newelement2[m]['meetingType'] == 'MI' && checkResult == 'TBA'){
                        infoArray['midtermTBAs']++;
                    }else if(checkResult == true){
                        infoArray['midtermconflictwithclass']++;
                    }
                }else if (newelement1[l]['meetingType'] == undefined){
                    echo('old: ' + newelement1[l]['meetingType']);
                }else if (newelement2[m]['meetingType'] == undefined){
                    echo('new: ' + newelement2[m]['meetingType']);
                }
            }
        }
        
        return infoArray;
        
    },
    makeConflictCache: function(initarray){
        for (i = 0; i < initarray.length; i++){
            this.classConflictCache[i] = [];
            for (j = 0; j < initarray[i].length; j++){
                this.classConflictCache[i][j] = [];
                for (x = 0; x < initarray.length; x++){
                    if (x == i) continue;
                    this.classConflictCache[i][j][x] = [];
                    for (y = 0; y < initarray[x].length; y++){
                        this.classConflictCache[i][j][x][y] = this.checkClassConflict(initarray,[i,j],[x,y]);
                    }
                }
            }
        }
    },
    checkcomboinfo: function(array, initarray, elementcursor){
        
        infoArray = [];
        infoArray['classconflict'] = 0; //冲突时间
        infoArray['classconflicttime'] = 0; //冲突时间
        infoArray['resttime'] = 0; //休息时间
        infoArray['totaldaytime'] = 0; //一共用的全天时间
        infoArray['totaldays'] = 0; //需要上课天数
        infoArray['midtermconflict'] = 0; //期中考试的冲突次数
        infoArray['midtermconflicttime'] = 0; //期中考试的冲突时间
        infoArray['midtermconflictwithclass'] = 0; //期中考试与正常上课冲突次数
        infoArray['midtermconflictwithclasstime'] = 0; //期中考试与正常上课冲突次数
        infoArray['finaldays'] = 0; //期末考试天数
        infoArray['finalhours'] = 0; //期末考试总小时数
        infoArray['finalconflict'] = 0; //期末考试冲突次数
        infoArray['finalconflicttime'] = 0; //期末考试冲突时间
        infoArray['classTBAs'] = 0;
        infoArray['midtermTBAs'] = 0;
        infoArray['finalTBAs'] = 0;
        infoArrayKeys = Object.keys(infoArray);
        
        for (k = 0; k < array.length; k++){
            for (l = 0; l < infoArrayKeys.length; l++){
                infoArray[infoArrayKeys[l]] += this.classConflictCache[array[k][0]][array[k][1]][elementcursor[0]][elementcursor[1]][tempInfoKeys[l]];
            }
        }
        return infoArray;
    },
    makecomboarray: function(initarray){
        var totalArray = [];
        var totalArrayLen = [];
        var totalPossible = 1;
        for (i = 0; i < initarray.length; i++){
            totalArrayLen[i] = 0;
            totalPossible *= initarray[i].length;
        }
        var totalPossible;
        var bigTempArray = [];
        for (j = 0; j < totalPossible; j++){
            var tempArray = [];
            
            tempArray['info'] = [];
            tempArray['info']['classconflict'] = 0; //冲突次数
            tempArray['info']['classconflicttime'] = 0; //冲突时间
            tempArray['info']['resttime'] = 0; //休息时间
            tempArray['info']['totaldaytime'] = 0; //一共用的全天时间
            tempArray['info']['totaldays'] = 0; //需要上课天数
            tempArray['info']['midtermconflict'] = 0; //期中考试的冲突次数
            tempArray['info']['midtermconflicttime'] = 0; //期中考试的冲突时间
            tempArray['info']['midtermconflictwithclass'] = 0; //期中考试与正常上课冲突次数
            tempArray['info']['midtermconflictwithclasstime'] = 0; //期中考试与正常上课冲突次数
            tempArray['info']['finaldays'] = 0; //期末考试天数
            tempArray['info']['finalhours'] = 0; //期末考试总小时数
            tempArray['info']['finalconflict'] = 0; //期末考试冲突次数
            tempArray['info']['finalconflicttime'] = 0; //期末考试冲突时间
            tempArray['info']['classTBAs'] = 0;
            tempArray['info']['midtermTBAs'] = 0;
            tempArray['info']['finalTBAs'] = 0;
            
            for (i = 0; i < initarray.length; i++){
                if (totalArrayLen[i] >= initarray[i].length){
                    totalArrayLen[i] = 0;
                    if (i != (initarray.length-1)){
                        totalArrayLen[i+1]++;
                    }
                }
                
                tempInfo = this.checkcomboinfo(tempArray, initarray, [i, totalArrayLen[i]]);
                
                if (tempInfo['classconflict'] != 0 || tempInfo['midtermconflict'] != 0 || tempInfo['finalconflict'] != 0 || tempInfo['midtermconflictwithclass'] != 0 ){
                    break;
                }
                
                tempInfoKeys = Object.keys(tempInfo);
                
                for (l = 0; l < tempInfoKeys.length; l++){
                    tempArray['info'][tempInfoKeys[l]] += tempInfo[tempInfoKeys[l]];
                }
                
                
                tempArray.push([i, totalArrayLen[i]]);
                
            }
            totalArrayLen[0]++;
            bigTempArray.push(tempArray);
        }
        return bigTempArray;
    },
    checkdatetimeconflict: function(firstDate, secondDate, firstStart, firstEnd, secondStart, secondEnd){
        if (firstDate == 'TBA' || secondDate == 'TBA' || firstStart == 'TBA' || firstEnd == 'TBA' || secondStart == 'TBA' || secondEnd == 'TBA'){
            return 'TBA';
        }
        
        
        
        this.totalCallTime++;
        fullInfoCacheString = firstDate + secondDate + firstStart + firstEnd + secondStart + secondEnd;
        
        if (typeof(this.dateTimeConflictCache[fullInfoCacheString]) == 'undefined'){
            this.dateTimeConflictCache[fullInfoCacheString] = [];
        }else{
            this.dateTimeConflictCacheNum++;
            return this.dateTimeConflictCache[fullInfoCacheString];
        }
        
        dateCacheString = firstDate + secondDate;
        
        if (typeof(this.dateConflictCache[dateCacheString]) == "undefined"){
            conflictArr = generate.checkdateconflict(firstDate, secondDate);
            this.dateConflictCache[dateCacheString] = conflictArr;
        }else{
            conflictArr = this.dateConflictCache[dateCacheString];
            this.dateConflictCacheNum++;
        }
        
        if (conflictArr.length != 0){
            firstStartArr = firstStart.split(':');
            firstEndArr = firstEnd.split(':');
            secondStartArr = secondStart.split(':');
            secondEndArr = secondEnd.split(':');
            firstStartTime = new Date(1997, 0, 17, firstStartArr[0], firstStartArr[1], firstStartArr[2]);
            firstEndTime = new Date(1997, 0, 17, firstEndArr[0], firstEndArr[1], firstEndArr[2]);
            secondStartTime = new Date(1997, 0, 17, secondStartArr[0], secondStartArr[1], secondStartArr[2]);
            secondEndTime = new Date(1997, 0, 17, secondEndArr[0], secondEndArr[1], secondEndArr[2]);
            
            
            var a = 0;
            while (a < 2){
                if (a == 1){
                    var temp = firstStartTime;
                    firstStartTime = secondStartTime;
                    secondStartTime = temp;
                    
                    temp = firstEndTime;
                    firstEndTime = secondEndTime;
                    secondEndTime = temp;
                }
                if ((firstStartTime >= secondStartTime && firstStartTime <= secondEndTime) && (firstEndTime >= secondStartTime && firstEndTime <= secondEndTime)){
                    //时间段1在时间段2之中
                    this.dateTimeConflictCache[fullInfoCacheString] = true;
                    return true;
                }
                
                if ((firstStartTime <= secondStartTime) && (firstEndTime >= secondStartTime && firstEndTime <= secondEndTime)){
                    this.dateTimeConflictCache[fullInfoCacheString] = true;
                    return true;
                }
                
                if ((firstStartTime >= secondStartTime && firstStartTime <= secondEndTime) && (firstEndTime >= secondEndTime)){
                    this.dateTimeConflictCache[fullInfoCacheString] = true;
                    return true;
                }
                a++;
            }
            this.dateTimeConflictCache[fullInfoCacheString] = false;
            return false;
        }else{
            this.dateTimeConflictCache[fullInfoCacheString] = false;
            return false;
        }
    },
    checkdateconflict: function(firstDate, secondDate){
        if (this.regexamericandate(firstDate) == true && this.regexamericandate(secondDate) == true){
            if (firstDate == secondDate){
                return [firstDate];
            }
        }else if((this.regexamericandate(firstDate) == true && this.regexamericandate(secondDate) == false) || (this.regexamericandate(firstDate) == false && this.regexamericandate(secondDate) == true)){
            weekday = new Array();
            weekday[0] = 'Su';
            weekday[1] = 'M';
            weekday[2] = 'Tu';
            weekday[3] = 'W';
            weekday[4] = 'Th';
            weekday[5] = 'F';
            weekday[6] = 'Sa';
            
            if (this.regexamericandate(firstDate) == true){
                tempDate = new Date(firstDate);
                firstDate = tempDate.getUTCDay();
            }else if (this.regexamericandate(secondDate) == true){
                tempDate = new Date(secondDate);
                secondDate = tempDate.getUTCDay();
            }
        }
        
        var firstDateArr;
        var secondDateArr;
        
        if (typeof(this.dateArrayCache[firstDate]) != "undefined"){
            firstDateArr = this.dateArrayCache[firstDate];
            this.dateArrayCacheNum++;
            //console.log('read date from cache');
        }else{
            firstDateArr = generate.makedatearray(firstDate);
            this.dateArrayCache[firstDate] = firstDateArr;
        }
        
        if (typeof(this.dateArrayCache[secondDate]) != "undefined"){
            secondDateArr = this.dateArrayCache[secondDate];
            this.dateArrayCacheNum++;
            //console.log('read date from cache');
        }else{
            secondDateArr = generate.makedatearray(secondDate);
            this.dateArrayCache[secondDate] = secondDateArr;
        }
        var conflictArr = [];
        for (date1 = 0; date1 < firstDateArr.length; date1++){
            if (secondDateArr.indexOf(firstDateArr[date1]) != -1){
                conflictArr.push(firstDateArr[date1]);
            }
        }
        return conflictArr;
    },
    checktimeconflict: function(firstStart, firstEnd, secondStart, secondEnd){
        if (firstDate == "TBA" || secondDate == "TBA"){
            return [0, 0];
        }
        
    },
    makedatearray: function(days){
        var newArr = [];
        for (strPos = 0; strPos < days.length; strPos++){
            if (days[strPos] >= "A" && days[strPos] <= "Z"){
                if ((strPos + 1) < days.length && days[strPos+1] >= "a" && days[strPos+1] <= "z"){
                    newArr.push(days[strPos] + days[strPos+1]);
                }else{
                    newArr.push(days[strPos]);
                }
            }
        }
        return newArr;
    },
    regexamericandate: function(date){
        if (date.match(/\d{2}\/\d{2}\/\d{4}/) != null){
            return true;
        }else{
            return false;
        }
    }
}

var generate=new Generate();