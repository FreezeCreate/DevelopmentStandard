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
                                    <td><input class="FrameGroupInput" type="text" name="number" value="<?php echo $result['number']?>"/></td>
                                    <td class="FrameGroupName" rowspan="2">头像</td>
                                    <td rowspan="2">
                                        <img class="userImg" src="<?php echo empty($result['head'])?SOURCE_PATH.'/images/head.png':$result['head']; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">姓名</td>
                                    <td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name']?>" /></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">登录账号</td>
                                    <td><input class="FrameGroupInput" type="text" name="username" value="<?php echo $result['username']?>" /></td>
                                    <td class="FrameGroupName">密码</td>
                                    <td><input class="FrameGroupInput" type="text" name="password" value="" placeholder="<?php echo empty($result['password'])?'不填默认为123456':'不填则不修改'?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">性别</td>
                                    <td><select class="FrameGroupInput" id="sex" name="sex">
                                            <option <?php echo $result['sex']=='男'?'selected=""':'';?> value="男">男</option>
                                            <option <?php echo $result['sex']=='女'?'selected=""':'';?> value="女">女</option>
                                        </select></td>
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
                                    <td><input class="FrameGroupInput" type="text" name="phone" value="<?php echo $result['phone']?>"/></td>
                                    <td class="FrameGroupName">短号</td>
                                    <td><input class="FrameGroupInput" type="text" name="trumpet" value="<?php echo $result['trumpet']?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">身份证号</td>
                                    <td><input class="FrameGroupInput" type="text" name="idCard" value="<?php echo $result['idCard']?>"/></td>
                                    <td class="FrameGroupName">生日</td>
                                    <td><input class="FrameGroupInput" type="text" readonly="true" id="birthday" name="birthday" value="<?php echo $result['birthday']?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 部门</td>
                                    <td><select class="FrameGroupInput" id="departmentid" name="departmentid">
                                            <?php foreach ($result['department'] as $k => $v) { ?>
                                                <option <?php echo $result['departmentid']==$v['id']?'selected=""':''?> value="<?php echo $v['id'] ?>"><?php echo $v['department'] ?></option>
                                            <?php } ?>
                                        </select></td>
                                    <td class="FrameGroupName">职位</td>
                                    <td><select class="FrameGroupInput" id="positionid" name="positionid">
                                            <?php foreach ($result['position'] as $k => $v) { ?>
                                                <option <?php echo $result['positionid']==$v['id']?'selected=""':''?> value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                            <?php } ?>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">直属上级</td>
                                    <td>
                                        <input class="FrameGroupInput uname" type="text" name="uname" placeholder="" value="<?php echo $result['pname'] ?>"/>
                                        <input type="hidden" class="uid" name="uid" value="<?php echo $result['pid'] ?>"/>
                                        <a class="Btn" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 员工状态</td>
                                    <td><select class="FrameGroupInput" name="dir">
                                            <?php foreach ($GLOBALS['USER_DIR'] as $k => $v) { ?>
                                                <option <?php echo $result['dir']==$k?'selected=""':''?> value="<?php echo $k ?>"><?php echo $v ?></option>
                                            <?php } ?>
                                        </select></td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 入职日期</td>
                                    <td><input class="FrameGroupInput" type="text" readonly="true" id="workdate" name="workdate" value="<?php echo $result['workdate'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">转正日期</td>
                                    <td><input class="FrameGroupInput" type="text" readonly="true" id="positivedt" name="positivedt" value="<?php echo $result['positivedt'] ?>"/></td>
                                    <td class="FrameGroupName">离职日期</td>
                                    <td><input class="FrameGroupInput" type="text" readonly="true" id="departure" name="departure" value="<?php echo $result['departure'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">邮箱</td>
                                    <td><input class="FrameGroupInput" type="text" name="email" value="<?php echo $result['email'] ?>"/></td>
                                    <td class="FrameGroupName">QQ</td>
                                    <td><input class="FrameGroupInput" type="text" name="QQ" value="<?php echo $result['QQ'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">菜单角色</td>
                                    <td colspan="3" style="text-align:left;">
                                        <?php foreach ($role as $v) { ?>
                                        <label for="q<?php echo $v['id'] ?>">
                                            <span class="checkbox itm <?php echo in_array($v['id'], $result['role'])?'active':''?>" data-val="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></span>
                                            <input type="checkbox" class="None" <?php echo in_array($v['id'], $result['role'])?'checked=""':''?> name="role[]" id="q<?php echo $v['id'] ?>" value="<?php echo $v['id'] ?>" data-type="type">
					</label>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="FrameTableFoot">
                <span class="Btn Big" onclick="do_sub()">保存</span>
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
<script type="text/javascript">
        var Use;
        var Pos;
        var Dep;
        $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
            Use = {}
            Use.status = 2;
            Use.data = data.data[0].children;
        }, 'json');
//            //职位
//            $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
//                    Pos = data;
//            }, 'json');
//            //部门
//            $.get('<?php  echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
//                    Dep = data;
//            }, 'json');
    </script>
<script>
                    jeDate({
                        dateCell: "#birthday", //isinitVal:true,
                        format: "YYYY-MM-DD",
                        isTime: false,
                        //isClear:false,
                        //minDate: "2015-10-19 00:00:00",
                        //maxDate: "2016-11-8 00:00:00"
                    });
                    jeDate({
                        dateCell: "#workdate", //isinitVal:true,
                        format: "YYYY-MM-DD",
                        isTime: false,
                        //isClear:false,
                        //minDate: "2015-10-19 00:00:00",
                        //maxDate: "2016-11-8 00:00:00"
                    });
                    jeDate({
                        dateCell: "#positivedt", //isinitVal:true,
                        format: "YYYY-MM-DD",
                        isTime: false,
                        //isClear:false,
                        //minDate: "2015-10-19 00:00:00",
                        //maxDate: "2016-11-8 00:00:00"
                    });
                    jeDate({
                        dateCell: "#departure", //isinitVal:true,
                        format: "YYYY-MM-DD",
                        isTime: false,
                        //isClear:false,
                        //minDate: "2015-10-19 00:00:00",
                        //maxDate: "2016-11-8 00:00:00"
                    });
                    $(function() {
                        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                        window.onresize = function() {
                            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                        };
                        $('.addFile').click(function() {
                            $(this).prev().click()
                        });
                    });

                    function do_sub() {
                        $.ajax({
                            cache: false,
                            type: "POST",
                            url: "<?php echo spUrl('personnel', "saveUserinfo"); ?>",
                            data: $('#check_form').serialize(),
                            dataType: "json",
                            async: false,
                            error: function(request) {
                                Alert('提交失败');
                            },
                            success: function(data) {
                                if (data.status == 1) {
                                     
                                    Refresh();
                                } else {
                                    Alert(data.msg);
                                }

                            }
                        });
                    }
</script>