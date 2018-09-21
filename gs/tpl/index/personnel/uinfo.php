<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>用户详情</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">用户详情</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
                    <input type="hidden" name="id" value="<?php echo $result['id']?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">用户详情</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName">编号</td>
                                    <td><?php echo $result['number']?></td>
                                    <td class="FrameGroupName" rowspan="2">头像</td>
                                    <td rowspan="2">
                                        <img class="userImg" src="<?php echo empty($result['head'])?SOURCE_PATH.'/images/head.png':$result['head']; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">姓名</td>
                                    <td><?php echo $result['number']?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">登录账号</td>
                                    <td><?php echo $result['username']?></td>
                                    <td class="FrameGroupName">密码</td>
                                    <td><input class="FrameGroupInput" type="text" name="password" value="" /></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">性别</td>
                                    <td><?php echo $result['sex'];?></td>
                                    <td class="FrameGroupName">登录权限</td>
                                    <td>
                                        <label for="q0">
                                            <span class="checkbox itm <?php echo $result['status']==1?'active':''?>" data-val="1">允许登录</span>
                                            <input type="checkbox" class="None" <?php echo $result['status']==1?'checked=""':''?> name="status" id="q0" value="1" data-type="type">
					</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 手机号</td>
                                    <td><?php echo $result['phone']?></td>
                                    <td class="FrameGroupName">短号</td>
                                    <td><?php echo $result['trumpet']?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">身份证号</td>
                                    <td><?php echo $result['idCard']?></td>
                                    <td class="FrameGroupName">生日</td>
                                    <td><?php echo $result['birthday']?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 部门</td>
                                    <td><?php echo $result['departmentname']; ?></td>
                                    <td class="FrameGroupName">职位</td>
                                    <td><?php echo $result['positionname']; ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">直属上级</td>
                                    <td><?php echo $result['pname'] ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 员工状态</td>
                                    <td><?php echo $GLOBALS['USER_DIR'][$result['dir']];?></td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 入职日期</td>
                                    <td><?php echo $result['workdate'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">转正日期</td>
                                    <td><?php echo $result['positivedt'] ?></td>
                                    <td class="FrameGroupName">离职日期</td>
                                    <td><?php echo $result['departure'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">邮箱</td>
                                    <td><?php echo $result['email'] ?></td>
                                    <td class="FrameGroupName">QQ</td>
                                    <td><?php echo $result['QQ'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="FrameTableFoot">
            </div>
        </div>
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/ajaxfileupload.js"></script>
</html>
<script>
        $(function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
            window.onresize = function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
            };
        });

</script>