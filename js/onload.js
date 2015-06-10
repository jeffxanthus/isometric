
window.onload=function(){
    setTimeout(scrollTo,0,0,0);
    var hash;
    handleHash();
}

window.onhashchange=function(){
    handleHash();
}


function handleHash(){
    hash=(!window.location.hash)?"index":window.location.hash;
    //document.getElementById('lastHash').value = hash;
    setHash(hash); 
    var handlecase;
    handlecase = hash.split('?');
    
    switch(handlecase[0]){
        case '#addplanner' :{
            getWebpage('addplanner.php');
            changeActiveStatusByName('schedule');
            break;
        }
        case '#editplanner' :{
            getWebpage('editplanner.php?id=' + handlecase[1]);
            changeActiveStatusByName('schedule');
            break;
        }
        case '#generate' :{
            getWebpage('schedule.php');
            changeActiveStatusByName('generate');
            break;
        }
        case '#scheduledetail' :{
            getWebpage('schedule.php');
            getSavedCalendar(handlecase[1],handlecase[2],handlecase[3]);
            changeActiveStatusByName('generate');
            break;
        }
        case '#manage' :{
            getWebpage('manageuser.php?page=' + handlecase[1]);
            changeActiveStatusByName('manage');
            break;
        }
        case '#schedulelist' :{
            getWebpage('schedule.php');
            showSavedCalendarList(handlecase[1]);
            changeActiveStatusByName('generate');
            break;
        }
        case '#locoidhistory' :{
            getWebpage('locoid.php?page=1');
            getEditFloat('history.php?type=locoid&id=' + handlecase[1] + '&page=' + handlecase[2], 'index');
            changeActiveStatusByName('locoid');
            break;
        }
        case '#routehistorydetail' :{
            getWebpage('manage.php?page=1');
            getEditFloat('historydetail.php?type=route&id=' + handlecase[1] + '&timestamp=' + handlecase[2], 'index');
            changeActiveStatusByName('route');
            break;
        }
        case '#locoidhistorydetail' :{
            getWebpage('locoid.php?page=1');
            getEditFloat('historydetail.php?type=locoid&id=' + handlecase[1] + '&timestamp=' + handlecase[2], 'index');
            changeActiveStatusByName('locoid');
            break;
        }
        case '#routedetail' :{
            if (lasthandlecase[0]!='route'){
                getWebpage('manage.php?page=1');
            }
            getEditFloat('routedetail.php?id=' + handlecase[1], 'index');
            changeActiveStatusByName('route');
            break;
        }
        case '#locoiddetail' :{
            if (lasthandlecase[0]!='locoid'){
                getWebpage('locoid.php?page=1');
            }
            getEditFloat('locoiddetail.php?id=' + handlecase[1], 'index');
            changeActiveStatusByName('locoid');
            break;
        }
        case '#editroutedetail' :{
            if (lasthandlecase[0]!='route'){
                getWebpage('manage.php?page=1');
            }
            getEditFloat('edit.php?id=' + handlecase[1], 'index');
            changeActiveStatusByName('route');
            break;
        }
        case '#addlocoiddetail' :{
            if (lasthandlecase[0] != 'locoid'){
                getWebpage('locoid.php?page=1');
            }
            getEditFloat('addlocoid.php', 'addID');
            changeActiveStatusByName('locoid');
            break;
        }
        case '#addroutedetail' :{
            if (lasthandlecase[0]!='route'){
                getWebpage('manage.php?page=1');
            }
            getEditFloat('add.php', 'index');
            changeActiveStatusByName('route');
            break;
        }
        case '#editlocoiddetail' :{
            if (lasthandlecase[0]!='locoid'){
                getWebpage('locoid.php?page=1');
            }
            getEditFloat('editlocoid.php?id=' + handlecase[1], 'index');
            changeActiveStatusByName('locoid');
            break;
        }
        case '#account' :{
            //getWebpage('useredit.php', 'index');
            changeActiveStatusByName('account');
            break;
        }
        case '#search' :{
            if (handlecase.length == 1){
                getFloat('tosearch.php');
            }else{
                getFloat('search.php?SearchType=' + handlecase[1] + '&SearchString=' + handlecase[2] + '&page=' + handlecase[3]);
            }
            changeActiveStatusByName('search');
            break;
        }
        case '#index' :{
            getWebpage('index.php');
            changeActiveStatusByName('index');
            break;
        }
        case '#login' :{
            document.getElementById("logincaptchaimg").click();
            $('#loginModal').modal('show');
            changeActiveStatusByName('login');
            break;
        }
        case '#register' :{
            document.getElementById("registercaptchaimg").click();
            $('#registerModal').modal('show');
            changeActiveStatusByName('register');
            break;
        }
        case '#readme' :{
            getFloat('readme.php?page=' + handlecase[1], 'index');
            changeActiveStatusByName('readme');
            break;
        }
        case '#findpassword' :{
            getFloat('preparetogetpassword.php', 'index');
            changeActiveStatusByName('findpassword');
            break;
        }
        case '#easteregg' :{
            getWebpage('easteregg.php');
            //changeActiveStatusByName('tmis');
            break;
        }
    }
    
}