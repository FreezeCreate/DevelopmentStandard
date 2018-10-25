
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>登录</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/login.css"/>
    </head>
    <body class="h-center">
        <div class="Login h-center noChoice">
            <div class="LoginBox">
                <div class="loginTit">
                    <img src="<?php echo SOURCE_PATH; ?>/images/login_logo.png"/>
                </div>
                <div class="loginCont">
                    <form action="" method="post" id="subform" onsubmit="return false">
                        <div class="loginContLeft">
                            <div class="loginGroup">
                                <label for="username">
                                    <span class="loginGroupName">账号 ：</span>
                                    <input class="loginGroupVal" type="text" name="username" id="username" value=""/>
                                </label>
                            </div>
                            <div class="loginGroup">
                                <label for="userpassword">
                                    <span class="loginGroupName">密码 ：</span>
                                    <input class="loginGroupVal" type="password" id="password" name="password" />
                                </label>
                            </div>
                            <div  class="loginRember">
                                <label for="checkbox">
                                    <span class="checkbox">记住密码</span>
                                    <input class="None" type="checkbox" id="checkbox" value="Rember"/>
                                </label>
                            </div>
                        </div>
                        <div class="loginContRight">
                            <a class="logIN">
                                <img src="<?php echo SOURCE_PATH; ?>/images/login_dl.png"/>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
</html>


<script>

                        document.onkeydown = function (event) {
                            var e = event || window.event || arguments.callee.caller.arguments[0];
                            if (e && e.keyCode == 13) { // enter 键
                                dosub();
                            }
                        };

                        var name = getCookie('name') || 0;
                        var pasd = getCookie('pasd') || 0;
                        if (name && pasd) {
                            $('.checkbox').addClass('active');
                            $('.checkbox').next().attr({'checked': 'checked'});
                            $('#username').val(name);
                            $('#password').val(pasd);
                        }
                        ;
                        $('.logIN').click(function () {
                            dosub();
                        });

                        function dosub() {
                            var username = $.trim($('#username').val());
                            var password = $.trim($('#password').val());
                            if (username == '') {
                                Alert('用户名不能为空');
                                return false;
                            }
                            if (password == '') {
                                Alert('密码不能为空');
                                return false;
                            }
                            $.ajax({
                                cache: false,
                                type: "POST",
                                url: "<?php echo spUrl($c, "login"); ?>",
                                data: $('#subform').serialize(),
                                dataType: "json",
                                async: false,
                                error: function (request) {
                                },
                                success: function (data) {
                                    if (data.status == 1) {
                                        if ($('.checkbox').hasClass('active')) {
                                            setCookie('name', username)
                                            setCookie('pasd', password)
                                        } else {
                                            deleteCookie('name')
                                            deleteCookie('pasd')
                                        }
                                        window.location.href = '/html/index.html';

                                    } else {
                                        Alert(data.msg);
                                    }

                                }
                            });

                        }
                        //保存cookie
                        function setCookie(name, value) {
                            var argv = setCookie.arguments;
                            var argc = setCookie.arguments.length;
                            var expires = (argc > 2) ? argv[2] : null;
                            if (expires != null) {
                                var LargeExpDate = new Date();
                                LargeExpDate.setTime(LargeExpDate.getTime() + (expires * 1000 * 3600 * 24));
                            }
                            document.cookie = name + "=" + escape(value) + ((expires == null) ? "" : ("; expires=" + LargeExpDate.toGMTString()));
                        }

                        //获取cookie
                        function getCookie(Name) {
                            var search = Name + "="
                            if (document.cookie.length > 0) {
                                offset = document.cookie.indexOf(search)
                                if (offset != -1) {
                                    offset += search.length
                                    end = document.cookie.indexOf(";", offset)
                                    if (end == -1)
                                        end = document.cookie.length
                                    return unescape(document.cookie.substring(offset, end))
                                } else
                                    return ""
                            }
                        }

                        //删除cookie
                        function deleteCookie(name) {
                            var expdate = new Date();
                            expdate.setTime(expdate.getTime() - (86400 * 1000 * 1));
                            setCookie(name, "", expdate);
                        }


                        function Alert(quest, callback) {
                            var Alert = document.createElement('div');
                            Alert.className = 'Alert';
                            $(Alert).append(
                                    '<div class="AlertBox"><div class="AlertTitl">系统提示<span class="close"></span></div>'
                                    + '<div class="AlertCont"><div class="AlertQuset">' + quest + '</div></div><div class="AlertBtn">'
                                    + '<span class="Succ">确认</span></div></div>'
                                    );
                            $('body').append(Alert);
                            $('.AlertBox').animate({'top': parseInt($(window).height() / 3) - parseInt($('.AlertBox').height() / 2)}, 300);
                            $(Alert).click(function (e) {

                                if (e.target == $('.Alert .close')[0]) {
                                    Remove()
                                    callback ? callback(true) : '';
                                } else if (e.target == $('.Alert .Succ')[0]) {
                                    Remove()
                                    callback ? callback(true) : '';
                                } else {
                                    return;
                                }
                            })
                            function Remove() {
                                $('.AlertBox').animate({'top': '-500px'}, 300, function () {
                                    $('.Alert').remove()
                                })
                            }
                        }
                        ;

</script>

