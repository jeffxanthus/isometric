<?php
session_start();
require_once('conn.php');
?>
<style>

.index-normal-form {
 background: url(mainbg.jpg) no-repeat center center fixed;
 -webkit-background-size: cover;
 -moz-background-size: cover;
 -o-background-size: cover;
 background-size: cover;
 filter:alpha(opacity=90);
 opacity:0.9;
}
@media screen and (min-width: 500px) { 
    .index-normal-form {
     width: 100%;
     background: url(smallmainbg.jpg) no-repeat center center scroll;
     -webkit-background-size: cover;
     -moz-background-size: cover;
     -o-background-size: cover;
     background-size: cover;
     filter:alpha(opacity=90);
     opacity:0.9;
     background-size: 80%;
     background-attachment:scroll;
    }
} 


</style>
<div id="maindiv" class="index-normal-form">
<p style="filter:alpha(opacity=100);opacity:1;">
    <h2 style="color: #999; font-family:Courier; font-size:55px; margin-top:0px;">FIND YOUR</h2><h1 style="color: #65db42; font-family:Courier; font-size:60px;font-weight: 700;">PERFECT</h1><h2 style="color: #65db42; font-family:Courier; font-size:55px;">SCHOOL</h2><h2 style="color: #65db42; font-family:Courier; font-size:55px;">SCHEDULE</h2><h2 style="color: #65db42; font-family:Courier; font-size:55px;">HERE!</h2>
</p>

<p style="filter:alpha(opacity=100);opacity:1;">
    <h2 style="color: #FFF; font-family: 'Walsheim-Black', 'Arial Black', sans-serif; font-size:40px;">WHAT DO WE DO?</h2>
    <h2 style="color: #FFF; font-family: 'Walsheim-Black', 'Arial Black', sans-serif; font-size:30px;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Help you make your se/trimester calendar</h2>
    <h2 style="color: #FFF; font-family: 'Walsheim-Black', 'Arial Black', sans-serif; font-size:30px;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Find a way to arrange your classes</h2>
    <h2 style="color: #FFF; font-family: 'Walsheim-Black', 'Arial Black', sans-serif; font-size:30px;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Make sure classes' time won't overlap</h2>
    
</p>


</div>

<p>
    2015 © Xiangqun Zhang, All rights reserved.
</p>

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
    
    if (thescreenX <= 500){
        $('.index-normal-form').css('background', 'url(smallmainbg.jpg) no-repeat center center scroll');
        $('.index-normal-form').css('background-size', 'cover');
        $('.index-normal-form').css('-webkit-background-size', 'cover');
        $('.index-normal-form').css('background-size', '80%');
        
    }else{
        $('.index-normal-form').css('background', 'url(mainbg.jpg) no-repeat center center scroll');
        $('.index-normal-form').css('background-size', 'cover');
        $('.index-normal-form').css('-webkit-background-size', 'cover');
        
    }
}
window.onload = fluid();
$(window).resize(fluid);

</script>