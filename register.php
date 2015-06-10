<?php require_once('func.php'); ?>
<center>
    <div class="row">
        <div class="form-group">
            <input placeholder="<?=__('username')?>" id="registerusername" type="text" class="input-block-level form-control" style="width:auto;"/>
        </div>
        <div class="form-group">
            <input placeholder="<?=__('password')?>" id="registerpassword" type="password" class="input-block-level form-control" style="width:auto;"/>
        </div>
        <div class="form-group">
            <input placeholder="<?=__('confirmpassword')?>" type="password" id="registerconfirmpassword" class="input-block-level form-control" style="width:auto;" >
        </div>
        <div class="form-group">
            <input placeholder="<?=__('email')?>" id="registeremail" class="input-block-level form-control" style="width:auto;" >
        </div>
        <div class="form-group">
            <input placeholder="<?=__('captcha')?>" id="registercaptcha" type="text" class="input-block-level form-control" style="width:auto;"/>
        </div>
        <img id='registercaptchaimg' src="captcha.php" alt="Captcha" width="60" height="30"
        style="cursor:pointer;" onClick="this.src='captcha.php?t='+(new Date().getTime());"
        align="texttop">
        <br /><br />
    </div>
    <p align="center">
        <span style="color:#f00;" id="returnRegisterText">
        </span>
    </p>
</center>
<script>
document.getElementById("registercaptcha").addEventListener("keydown", function(e) {
        if (!e) { var e = window.event; }
        
        if (e.keyCode == 13) { <?=$onclick?>(); }
    }, false);
</script>