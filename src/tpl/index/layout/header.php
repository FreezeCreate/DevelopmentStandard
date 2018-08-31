<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>乐居邦</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body style="min-width: 1200px;">
        <!--头部-->
        <div class="Header">
            <div class="HeaderLogo"><img  src="<?php echo SOURCE_PATH; ?>/images/icon/logo.png"/></div>
            <div class="HeadM">
                <ul class="HeadMbox">
                    <li class="HeadMitem active"data-pid="1"data-name="OA管理"><a ><img class="HeadMicon" src="<?php echo SOURCE_PATH; ?>/images/icon/index_oa.png"/><span>OA管理</span></a></li>
                    <li class="HeadMitem"data-pid="2"data-name="项目管理"><a ><img class="HeadMicon" src="<?php echo SOURCE_PATH; ?>/images/icon/index_xm.png"/><span>项目管理</span></a></li>
                    <li class="HeadMitem"data-pid="3"data-name="客户管理"><a ><img class="HeadMicon" src="<?php echo SOURCE_PATH; ?>/images/icon/index_kh.png"/><span>客户管理</span></a></li>
                    <li class="HeadMitem"><a href="<?php echo spUrl('exchang', 'index') ?>"><img class="HeadMicon" src="<?php echo SOURCE_PATH; ?>/images/icon/index_jl.png"/><span>行业交流</span></a></li>
                </ul>
            </div>
            <div class="HeaderMenu noChoice">
                <ul class="HeaderMenuBox">
                    <li class="HeaderMenuItem"><img class="HeaderMenuItemImg" src="<?php echo SOURCE_PATH; ?>/images/icon/header_msg.png"/><span class="HeaderMenuItemName">新消息<span style="color: #ff4e00;">（0）</span></span></li>
                    <li class="HeaderMenuItem User">
                        <img class="HeaderMenuItemImg userImg" src="<?php echo $user['head']; ?>" />
                        <span class="userName"><?php echo $user['name'] ?></span>
                        <i class="userIcon"></i>
                        <ul class="userMenu">
                            <li class="userItem InPop" data-boxid="xgzl"><img src="<?php echo SOURCE_PATH; ?>/images/user/user_msg.png"/><span>修改资料</span></li>
                            <li class="userItem InPop" data-boxid="xgmm"><img src="<?php echo SOURCE_PATH; ?>/images/user/user_paswd.png"/><span>修改密码</span></li>
                            <li class="userItem NewPop" data-title="页面弹窗" data-url="<?php echo spUrl('main', lists) ?>"><img src="<?php echo SOURCE_PATH; ?>/images/user/user_out.png"/><span>页面弹窗</span></li>
                            <li class="userItem"><a href="<?php echo spUrl('passport', 'logout') ?>"><img src="<?php echo SOURCE_PATH; ?>/images/user/user_out.png"/><span>退出登录</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--头部结束-->
        <!--菜单导航-->
        <div class="Menu">
            <div class="MenuScroll">
                <div class="MenuHead">OA管理</div>
                <ul class="MenuBox MenuBody">
                </ul>
                <div style="height: 50px;"></div>
            </div>
        </div><!--菜单导航-->
