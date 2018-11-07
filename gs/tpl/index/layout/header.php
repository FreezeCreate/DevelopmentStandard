<!DOCTYPE html>
<?php $company = spClass('m_company')->find(array('id'=>$admin['cid']));?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>冠晟平台</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
	<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
        <?php $color = explode(',', $company['color']);?>
        <style>
            .LeftMenu { background: linear-gradient(<?php echo empty($color[1])?'#81b1dd':$color[1]?>, <?php echo empty($color[2])?'#0d5781':$color[2]?>);}
            .Header { background:<?php echo empty($color[2])?'#0d5781':$color[2]?>}
        </style>
    </head>
    <body>
        <!--头部开始-->
        <div class="Header noChoice">
            <div class="HeaderLogo">
                <img class="HeaderLogoImg" src="<?php echo empty($company['logo'])?SOURCE_PATH.'/images/logo.png':$company['logo']; ?>" alt="" />
                <span class="HeaderLogoName"><?php echo $company['name']?></span>
            </div>
            <div class="HeaderNav">
                <ul class="HeaderNavMenu">
                    <li class="NavMenuItem hdnav">
                        <a class="Second NewHtml a_259 active" data-url="<?php echo spUrl('person','upcoming')?>" data-clas="a_259" data-img="/source/images/gai_62.png" data-name="待办事项">
                            <img class="MenuItemImg" src="<?php echo SOURCE_PATH; ?>/images/shouye_11.png" />
                            <span class="MenuItemTex">待办事项<i style="color: #e4ff00;" id="hupcoming_badge">（0）</i></span>
                        </a>
                    </li>
                    <li class="NavMenuItem hdnav User">
                        <div>
                            <img class="MenuItemImg User userhead" src="<?php echo empty($admin['head']) ? SOURCE_PATH . '/images/head.png' : $admin['head']; ?>" />
                            <span class="MenuItemTex"><?php echo $admin['name'] ?></span>
                            <div class="UserMenu">
                                <span class="UserMenuTop"></span>
                                <ul>
                                    <li class="UserMenuItem InPop" data-BoxId="xgzl">
                                        <a>
                                            <img class="UserMenuItemImg" src="<?php echo SOURCE_PATH; ?>/images/shouye_25.png" alt="" />
                                            <span class="UserMenuItemTex">修改资料</span>
                                        </a>
                                    </li>
                                    <li class="UserMenuItem InPop" data-BoxId="xgmm">
                                        <a>
                                            <img class="UserMenuItemImg" src="<?php echo SOURCE_PATH; ?>/images/shouye_29.png" alt="" />
                                            <span class="UserMenuItemTex">修改密码</span>
                                        </a>
                                    </li>
                                    <li class="UserMenuItem">
                                        <a href="<?php echo spUrl('main','logout')?>">
                                            <img class="UserMenuItemImg" src="<?php echo SOURCE_PATH; ?>/images/shouye_31.png" alt="" />
                                            <span class="UserMenuItemTex">退出登录</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div style="clear: both;"></div>
        </div>
        <!--头部结束-->

        <!--
                作者：895635200@qq.com
                时间：2017-08-11
                描述：背景图end
        -->
