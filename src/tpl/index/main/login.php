

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>登录</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/login.css" />
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    </head>

    <body>
        <div class="login noChoice">
            <div class="box">
                <div class="loginLeft textLeft">
                    <div class="logo">
                        <img src="<?php echo SOURCE_PATH; ?>/images/login/logo.png"/>
                    </div>
                    <div class="">
                        <img src="<?php echo SOURCE_PATH; ?>/images/login/quot_1.png"/>
                        <span class="line"></span>
                    </div>
                    <div class="banner">
                        <p>管理 、资讯、详情</p>
                        <p class="textRight">一手掌握</p>
                        <span class="lineY"></span>
                    </div>
                    <div class="textRight"><img src="<?php echo SOURCE_PATH; ?>/images/login/quot_2.png"/></div>
                </div>
                <div class="loginRight">
                    <p class="loginTit">账号登陆</p>
                    <div class="form">
                        <form id="retForm">
                            <div class="loginInp" >
                                <input type="text" class="name" name="username" placeholder="QQ号/手机号/邮箱"/>
                            </div>
                            <div class="loginInp" >
                                <input type="password" class="pasd" name="password" placeholder="密码"/>
                                <span class="eyes"></span>
                            </div>
                            <div class="remb textLeft">
                                <span class="checkbox">记住密码</span>
                                <input type="checkbox" class="None" />
                                <a class="colorBlu float-right" href="<?php echo spUrl('passport', 'forget') ?>">忘记密码</a>
                            </div>
                            <div class="subm">登录</div>
                        </form>
                    </div>
                    <div class="regis colorBlu">
                        <span class="regist">立即注册 > </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="chous">
            <div class="chousBox">
                <span class="close"></span>
                <ul class="floatBox">
                    <li class="chousItem">
                        <a href="<?php echo spUrl('passport', 'regist_person') ?>">
                            <div class="img1"></div>
                            <p>个人注册</p>
                        </a>
                    </li>
                    <li class="chousItem">
                        <a href="<?php echo spUrl('passport', 'regist_company') ?>">
                            <div class="img2"></div>
                            <p>公司注册</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        $('.eyes').click(function() {
            $(this).toggleClass('active');
            if ($(this).hasClass('active')) {
                $('.pasd').attr({'type': 'text'})
            } else {
                $('.pasd').attr({'type': 'password'})
            }
        })
        var name = getCookie('name');
        var pasd = getCookie('pasd');
        console.log(name, pasd)
        if (name && pasd) {
            $('.checkbox').addClass('active');
            $('.checkbox').next().attr({'checked': 'checked'});
            $('.name').val(name);
            $('.pasd').val(pasd);
        }
        ;
        $('.subm').click(function() {
            var name = $('.name').val().trim();
            var pasd = $('.pasd').val().trim();
            if (name == '') {
                return Alert('请输入用户名')
            }
            ;
            if (pasd == '') {
                return Alert('请输入密码')
            }
            ;
            loading()
            $.ajax({
                type: "POST",
                url: "<?php echo spUrl($c,$a)?>",
                data: $('#retForm').serialize(),
                dataType: "json",
                success: function(res) {
                    //console.log(res)
                    loading('none')
                    if (res.code == 0) {
                        if ($('.checkbox').hasClass('active')) {
                            setCookie('name', name)
                            setCookie('pasd', pasd)
                        } else {
                            deleteCookie('name')
                            deleteCookie('pasd')
                        }
                        window.location.href = '<?php echo spUrl('main','index')?>';
                    } else {
                        Alert(res.msg)
                    }
                },
                error: function(e) {
                    loading('none')
                    Alert(e.statusText)
                }
            });

        });
        $('.regist').click(function() {
            $('.chous').addClass('active');
            $('.chousBox').css({'animation': 'boxIn .3s forwards'})
        });
        $('.close').click(function() {
            $('.chousBox').css({'animation': 'boxOut .3s forwards'})
            setTimeout(function() {
                $('.chous').removeClass('active')
            }, 300)
        })
    </script>
</html>
