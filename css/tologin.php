<br />
<form id="mainform" class="normal-form" style="text-align:center;width:90%">
    <center>
        <h3>
            用户登录 | <a onclick="floatGetWebpage('register.php', 'mainform');" href="javascript:void(0)">注册用户</a>
        </h3>
        <div class="row">
            <div class="col-lg-1">
                <input id="username" class="form-control" name="username" type="text" placeholder="用户名"/>
            </div>
            <div class="col-lg-1">
                <input id="password" class="form-control" name="password" type="password" placeholder="密码"/>
            </div>
            <div class="col-lg-1">
                <input name="testlabel" class="form-control" type="text" id="testlabel" placeholder="验证码">
            </div>
            <img src="checkcode.php" alt="验证码,看不清楚?请点击刷新验证码" width="60" height="30"
            style="cursor:pointer;" onClick="this.src='checkcode.php?t='+(new Date().getTime());"
            align="texttop">
            <br /><br />
        </div>
        <p>
            <a href="javascript:void(0)">
                <button onclick="return submitLogin();" class="btn btn-large btn-primary">
                    登陆
                </button>
            </a>
        </p>
        <p align="center">
            <span style="color:#f00;" id="returnText">
            </span>
        </p>
    </center>
</form>