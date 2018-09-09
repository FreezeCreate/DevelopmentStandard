
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>企业注册</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/regist.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/regist.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <div class="regist"></div>
        <div class="header">
            <div class="log"><img style="height: 50px;" src="<?php echo SOURCE_PATH; ?>/images/regist/logo.png"/></div>
            <a class="intus"href="<?php echo spUrl('passport', 'login')?>">已有账号，返回登录</a>
        </div>
        <div class="main">
            <ul class="lineBox">
                <li class="lineItem active"></li>
                <li class="lineItem "></li>
            </ul>
            <div class="cont active">
                <h3>公司注册</h3>
                <div class="regBox">
                    <form id="retForm">
                        <div class="regLin">
                            <label>
                                <span class="regName">公司名称</span>
                                <input class="regVal" type="tex" name="company" value="" placeholder="请输入公司名称"/>
                            </label>
                        </div>
                        <div class="upImg">
                            <ul class="imgBox">
                                <li class="imgItem">
                                    <img src="<?php echo SOURCE_PATH; ?>/images/regist/upimg_4.png" id="logoval" onclick="$('#logoimg').click()"/>
                                    <input type="file" class="None" id="logoimg" placeholder="请上传公司LOGO"/>
                                    <input type="hidden" name="logo" id="logo" value="" placeholder="请上传公司LOGO"/>
                                </li>
                            </ul>
                        </div>
                        <div class="regLin">
                            <label>
                                <span class="regName">统一社会信用代码</span>
                                <input class="regVal" type="tex" value="" name="licensenumber" placeholder="请输入公司统一社会信用代码"/>
                            </label>
                        </div>
                        <div class="upImg">
                            <ul class="imgBox">
                                <li class="imgItem">
                                    <img src="<?php echo SOURCE_PATH; ?>/images/regist/upimg_3.png" id="licenseval" onclick="$('#licenseimg').click()"/>
                                    <input type="file"class="None" id="licenseimg" placeholder="请上传公司营业执照"/>
                                    <input type="hidden" name="license" id="license" value="" placeholder="请上传公司营业执照"/>
                                </li>
                            </ul>
                        </div>
                        <div class="regLin">
                            <label>
                                <span class="regName">法人姓名</span>
                                <input class="regVal" type="text" name="name" value="" placeholder="请输入公司法人姓名"/>
                            </label>
                        </div>
                        <div class="regLin">
                            <label>
                                <span class="regName">法人身份证号</span>
                                <input class="regVal" type="text" name="idcardnumber" id="idcardnumber" value="" placeholder="请输入法人身份证号"/>
                            </label>
                        </div>
                        <div class="upImg">
                            <ul class="imgBox">
                                <li class="imgItem">
                                    <img src="<?php echo SOURCE_PATH; ?>/images/regist/upimg_1.png" id="idcardval" onclick="$('#idcardimg').click()"/>
                                    <input type="file"class="None" id="idcardimg" value="" placeholder="请上传身份证"/>
                                    <input type="hidden" id="idcard" name="idcard" value=""  placeholder="请上传身份证"/>
                                </li>
                            </ul>
                        </div>
                        <div class="regLin gsTog">
                            <label>
                                <span class="regName">公司地址</span>
                                <div class="regVal " style="cursor: pointer;"><span class="provice"></span> <span class="city"></span> <span class="area"></span></div>
                                <input type="hidden" name="province" id="province" value="" placeholder="请选择省份"/>
                                <input type="hidden" name="city" id="city" value="" placeholder="请选择城市"/>
                                <input type="hidden" name="area" id="area" value="" placeholder="请选择区域"/>
                            </label>
                        </div>
                        <div class="gs">
                            <div class="gsBox">
                                <div class="gsNav">
                                    <ul>
                                        <li class="dzItem active">省</li>
                                        <li class="dzItem">市</li>
                                        <li class="dzItem">区</li>
                                    </ul>
                                    <span class="close"></span>
                                </div>
                                <div class="dzCon">
                                    <ul class="ItemBox">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="regLin">
                            <label>
                                <span class="regName">公司详细地址</span>
                                <input class="regVal" type="tex" name="address" value="" placeholder="请输入公司详细地址"/>
                            </label>
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
                                <input class="regVal pasd password" type="password" value="" name="password" id="password" placeholder="请输入6-12字符" />
                                <span class="eye"></span>
                            </label>
                        </div>
                        <div class="regLin">
                            <label>
                                <span class="regName">再次确认密码</span>
                                <input class="regVal pasd repassword" type="password" value="" name="confirm_password" placeholder="请再次输入您的密码"/>
                            </label>
                        </div>
                        <div class="regLin phone">
                            <label>
                                <span class="regName">输入11位手机号</span>
                                <input class="regVal" type="tex" name="phone" value="" id="phone" placeholder="请输入手机号" />
                            </label>
                        </div>
                        <span class="yzm">获取验证码</span>
                        <div class="regLin">
                            <label>
                                <span class="regName">验证码</span>
                                <input class="regVal" type="tex" value="" name="code" placeholder="请输入验证码" />
                            </label>
                        </div>
                        <div class="subm comp">注册</div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">

        var ads = {p_name: '', p_id: '', c_name: '', c_id: '', a_name: '', a_id: ''};
        var num = 0;
        function adsReq(pid) {
            $('.ItemBox').children().remove();
            $.ajax({
                type: "POST",
                url: "/basic/findAddress",
                data: {'pid': pid, 't': new Date()},
                dataType: "json",
                success: function(res) {
//			    	console.log(res)
                    setAds(res)
                }
            });
        }
        ;

        function setAds(a) {
            var str = '';
            $.each(a, function(k, v) {
                str += '<li class="Item"data-id="' + v.aid + '">' + v.name + '</li>'
            });
            $('.ItemBox').append(str)
        }
        ;
        //注册
        function requested() {
            loading()
            $.ajax({
                type: "POST",
                url: "<?php echo spUrl('passport','regCompany')?>",
                data: $('#retForm').serialize(),
                dataType: "json",
                success: function(res) {
//					console.log(res)
                    loading('none')
                    if (res.code == 0) {
                        Alert('注册成功！', function() {
                            window.location.href = '<?php echo spUrl('main','index')?>'
                        })
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
            return;
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
