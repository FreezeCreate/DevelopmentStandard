
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>个人注册</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/regist.css" />
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/regist.js" type="text/javascript" charset="utf-8"></script>
    </head>

    <body>
        <div class="regist"></div>
        <div class="header">
            <div class="log"><img style="height: 50px;"src="<?php echo SOURCE_PATH; ?>/images/regist/logo.png"/></div>
            <a class="intus" href="<?php echo spUrl('passport', 'login')?>">已有账号，返回登录</a>
        </div>
        <div class="main">
            <ul class="lineBox">
                <li class="lineItem active"></li>
                <li class="lineItem "></li>
            </ul>
            <div class="cont active">
                <h3>个人注册</h3>
                <div class="regBox">
                    <form id="retForm">
                        <div class="regLin">
                            <label>
                                <span class="regName">姓名</span>
                                <input class="regVal" type="tex" name="name" value="" placeholder="请输入姓名"/>
                            </label>
                        </div>
                        <div class="regLin">
                            <label>
                                <span class="regName">身份证号码</span>
                                <input class="regVal" type="tex" name="idcardnumber" id="idcardnumber" value=""  placeholder="请输入有效身份证号" />
                            </label>
                        </div>
                        <div class="upImg">
                            <ul class="imgBox">
                                <li class="imgItem">
                                    <img id="img_upload_show" onclick="$('#img_upload').click()" src="<?php echo SOURCE_PATH; ?>/images/regist/upimg_1.png" />
                                    <input type="file" name="" class="None" id="img_upload" placeholder="请上传身份证"/>
                                    <input type="hidden" name="idcard" id="img_val" value="" placeholder="请上传身份证"/>
                                </li>
                            </ul>
                        </div>
                        <div class="regLin">
                            <label>
                                <span class="regName">请输入用户名</span>
                                <input class="regVal username" type="tex" name="username" value="" placeholder="请输入8-15位用户名"/>
                            </label>
                        </div>
                        <div class="regLin">
                            <label>
                                <span class="regName">密码</span>
                                <input class="regVal pasd password" type="password" name="password" value="" placeholder="请输入6-12密码" />
                                <span class="eye"></span>
                            </label>
                        </div>
                        <div class="regLin">
                            <label>
                                <span class="regName">再次确认密码</span>
                                <input class="regVal pasd repassword" type="password" name="confirm_password" value="" placeholder="请再次输入您的密码"/>
                            </label>
                        </div>
                        <div class="regLin phone">
                            <label>
                                <span class="regName">输入11位手机号</span>
                                <input class="regVal" type="tex" name="phone" id="phone" value="" placeholder="请输入手机号" />
                            </label>
                        </div>
                        <span class="yzm">获取验证码</span>
                        <div class="regLin">
                            <label>
                                <span class="regName">验证码</span>
                                <input class="regVal" type="tex" name="code" value="" placeholder="请输入验证码" />
                            </label>
                        </div>
                        <div class="subm pers">注册</div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        //注册
        function requested() {
            loading()
            $.ajax({
                type: "POST",
                url: "<?php echo spUrl('passport','regPerson')?>",
                data: $('#retForm').serialize(),
                dataType: "json",
                success: function(res) {
//					console.log(res)
                    loading('none')
                    if (res.code == 0) {
                        Alert('注册成功！', function() {
                            window.location.href = '<?php echo spUrl('passport','bind')?>'
                        });
                    } else {
                        Alert(res.msg)
                    }
                },
                error: function(e) {
                    loading('none')
                    Alert(e.statusText)
                }
            });
        }
        ;
        //获取验证码
        function getCode(num) {
            //return;
            $.ajax({
                type: "POST",
                url: "<?php echo spUrl('passport','do_sms')?>",
                data: {phone: num},
                dataType: "json",
                success: function(res) {
                    console.log(res)
                }
            });
        }
    </script>
</html>