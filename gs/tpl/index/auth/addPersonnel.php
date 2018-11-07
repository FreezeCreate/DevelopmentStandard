<?php require_once TPL_DIR . '/layout/con_header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/table.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var Use;
    var Pos;
    var Dep;
    $.get('<?php echo spUrl('main', "getUsers"); ?>', {id: 5}, function(data) {
        Use = {}
        Use.status = 2;
        Use.data = data.data[0].children;
    }, 'json');
    //职位
    $.get('<?php echo spUrl('main', "getPosition"); ?>', {id: 5}, function(data) {
        Pos = data;
    }, 'json');
    //部门
    $.get('<?php echo spUrl('main', "getDepartment"); ?>', {id: 5}, function(data) {
        Dep = data;
    }, 'json');
</script>
<body>
    <div class="Frame">
        <div class="FrameTit"><span class="FrameTitName">新增</span><span class="Close"></span></div>
        <div class="FrameBox">
            <div class="FrameCont">
                <div class="FrameTable">
                    <form id="check_form">
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                        <table class="FrameTableCont">
                            <tr>
                                <td class="FrameGroupName">编号</td>
                                <td><input class="FrameGroupInput" type="text" name="number" value="<?php echo $result['number'] ?>"/></td>
                                <td class="FrameGroupName" rowspan="2">头像</td>
                                <td rowspan="2">
                                    <img class="userImg userhead" onclick="$('#fileToUploadHead').click();" src="<?php echo empty($result['head']) ? SOURCE_PATH . '/images/head.png' : $result['head']; ?>"/>
                                    <input class="None upfile" type="file" name="fileToUploadHead" id="fileToUploadHead" value="" onchange="ajaxFileUpload()"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">姓名</td>
                                <td><input class="FrameGroupInput" type="text" name="name" value="<?php echo $result['name'] ?>" /></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 部门</td>
                                <td>
                                    <input class="FrameGroupInput uname" type="text" name="dname" placeholder="" value="<?php echo $result['dname'] ?>"/>
                                    <input type="hidden" class="uid" name="did" value="<?php echo $result['did'] ?>"/>
                                    <a class="Btn Btn-blue" onclick="ChousPerson(Dep, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
                                <td class="FrameGroupName">职位</td>
                                <td>
                                    <input class="FrameGroupInput uname" type="text" name="pname" placeholder="" value="<?php echo $result['pname'] ?>"/>
                                    <input type="hidden" class="uid" name="pid" value="<?php echo $result['pid'] ?>"/>
                                    <a class="Btn Btn-blue" onclick="ChousPerson(Pos, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">直属上级</td>
                                <td>
                                    <input class="FrameGroupInput uname" type="text" name="sname" placeholder="" value="<?php echo $result['sname'] ?>"/>
                                    <input type="hidden" class="uid" name="sid" value="<?php echo $result['sid'] ?>"/>
                                    <a class="Btn Btn-blue" onclick="ChousPerson(Use, 'one', '.uname', '.uid', this)">选择</a>
                                </td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 手机号</td>
                                <td><input class="FrameGroupInput" type="text" name="phone" value="<?php echo $result['phone'] ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 登录账号</td>
                                <td><input class="FrameGroupInput" type="text" name="username" value="<?php echo $result['username'] ?>" /></td>
                                <td class="FrameGroupName">密码</td>
                                <td><input class="FrameGroupInput" type="text" name="password" value="" placeholder="<?php echo empty($result['password']) ? '不填默认为123456' : '不填则不修改' ?>"/></td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName">性别</td>
                                <td><select class="FrameGroupInput" id="sex" name="sex">
                                        <option <?php echo $result['sex'] == '男' ? 'selected=""' : ''; ?> value="男">男</option>
                                        <option <?php echo $result['sex'] == '女' ? 'selected=""' : ''; ?> value="女">女</option>
                                    </select></td>
                                <td class="FrameGroupName">登录权限</td>
                                <td>
                                    <label for="q0">
                                        <span class="checkbox itm <?php echo $result['status'] == 1 ? 'active' : '' ?>" data-val="1">允许登录</span>
                                        <input type="checkbox" class="None" <?php echo $result['status'] == 1 ? 'checked=""' : '' ?> name="status" id="q0" value="1" data-type="type">
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 员工状态</td>
                                <td><select class="FrameGroupInput" name="dir">
                                        <?php foreach ($GLOBALS['USER_DIR'] as $k => $v) { ?>
                                            <option <?php echo $result['dir'] == $k ? 'selected=""' : '' ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                                        <?php } ?>
                                    </select></td>
                                <td class="FrameGroupName"><span style="color:red;">*</span> 入职日期</td>
                                <td><input class="FrameGroupInput" type="text" readonly="true" id="workdate" name="workdate" value="<?php echo $result['workdate'] ?>"/></td>
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
                                            <span class="checkbox itm <?php echo in_array($v['id'], $result['role']) ? 'active' : '' ?>" data-val="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></span>
                                            <input type="checkbox" class="None" <?php echo in_array($v['id'], $result['role']) ? 'checked=""' : '' ?> name="role[]" id="q<?php echo $v['id'] ?>" value="<?php echo $v['id'] ?>" data-type="type">
                                        </label>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="FrameTableFoot">
            <span class="Succ" onclick="do_sub()">提交</span>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    $(function() {
        $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        window.onresize = function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight)
        }
    });
    jeDate({
        dateCell: "#workdate", //isinitVal:true,
        format: "YYYY-MM-DD",
        isTime: false,
        //isClear:false,
        //minDate: "2015-10-19 00:00:00",
        //maxDate: "2016-11-8 00:00:00"
    });
    Refresh();
    function do_sub() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, 'savePersonnel'); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                Alert(data.msg);
                if (data.status == 1) {
                    loading('none');
                     
                    parent.closHtml();
                    // Refresh();
                } else {
                    loading('none');
                }

            }
        });
    }
</script>

