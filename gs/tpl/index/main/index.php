<?php require_once TPL_DIR . '/layout/header.php'; ?>

<div class="Body">
    <?php require_once TPL_DIR . '/layout/left.php'; ?>
    <!--内容开始-->
    <div class="Content">
        <div class="ContentTitl">
            <ul class="ContentTitlNav">
                <li class="ContentTitlNavItem active a_01"data-clas="a_01">
                    <a>
                        <img class="ContentTitlNavItemImg" src="<?php echo SOURCE_PATH; ?>/images/shouye_16.png"/>
                        <span class="ContentTitlNavItemText">首页</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="ContentCont">
            <iframe src="<?php echo spUrl('main', 'bench') ?>" class="html active a_01" name="a_01"></iframe>
        </div>
    </div>
    <!--内容结束-->
</div>
<!--Body结束-->
<div class="Pop"></div>
<div class="Tan " id="xgzl">
    <div class="TanBox ">
        <div class="TanBoxTit">修改资料 <span class="close OtPop" data-BoxId="xgzl"></span></div>
        <div class="TanBoxCont">
            <div class="FrameTable">
                <form id="myInfo_form" method="post" action="" onsubmit="return false;">
                    <div class="FrameTableTitl">修改资料</div>
                    <table class="FrameTableCont">
                        <tr>
                            <td class="FrameGroupName">姓名  ：</td>
                            <td><input class="FrameGroupInput" type="text" readonly="true" value="<?php echo $admin['name'] ?>" /></td>
                            <td class="FrameGroupName" rowspan="2">头像 ：</td>
                            <td rowspan="2">
                                <img class="userImg userhead" onclick="$('#fileToUploadHead').click();" src="<?php echo empty($admin['head']) ? SOURCE_PATH . '/images/head.png' : $admin['head']; ?>"/>
                                <input class="None upfile" type="file" name="fileToUploadHead" id="fileToUploadHead" value="" onchange="ajaxFileUpload()"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">编号</td>
                            <td><input class="FrameGroupInput notenter" type="text" readonly="true" value="<?php echo $admin['number'] ?>"/></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">登录账号</td>
                            <td><input class="FrameGroupInput notenter" type="text" readonly="true" value="<?php echo $admin['username'] ?>"/></td>
                            <td class="FrameGroupName">部门</td>
                            <td><?php echo $admin['dname'] ?></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">职位</td>
                            <td><?php echo $admin['pname'] ?></td>
                            <td class="FrameGroupName"><span style="color:red;">*</span> 员工状态</td>
                            <td><?php foreach ($GLOBALS['USER_DIR'] as $k => $v) { ?>
                                    <?php echo $k == $admin['dir'] ? $v : ''; ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">入职日期</td>
                            <td><input class="FrameGroupInput notenter" type="text" readonly="true" value="<?php echo $admin['workdate'] ?>"/></td>
                            <td class="FrameGroupName">转正日期</td>
                            <td><input class="FrameGroupInput notenter" type="text" readonly="true" value="<?php echo $admin['positivedt'] ?>"/></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName"><span style="color:red;">*</span> 手机号</td>
                            <td><input class="FrameGroupInput" type="text" name="phone" value="<?php echo $admin['phone'] ?>"/></td>
                            <td class="FrameGroupName">短号</td>
                            <td><input class="FrameGroupInput" type="text" name="trumpet" value="<?php echo $admin['trumpet'] ?>"/></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">身份证号</td>
                            <td><input class="FrameGroupInput" type="text" name="idCard" value="<?php echo $admin['idCard'] ?>"/></td>
                            <td class="FrameGroupName">生日</td>
                            <td><input class="FrameGroupInput" type="text" readonly="true" id="mybirthday" name="birthday" value="<?php echo $admin['birthday'] ?>"/></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">邮箱</td>
                            <td><input class="FrameGroupInput" type="text" name="email" value="<?php echo $admin['email'] ?>"/></td>
                            <td class="FrameGroupName">QQ</td>
                            <td><input class="FrameGroupInput" type="text" name="QQ" value="<?php echo $admin['QQ'] ?>"/></td>
                        </tr>
                    </table>
                    <div class="TanBtn">
                        <span class="Btn Btn-green" onclick="do_myInfo()">确定</span>
                        <span class="Btn Btn-blue OtPop" data-BoxId="xgzl">取消</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="Tan " id="xgmm">
    <div class="TanBox ">
        <div class="TanBoxTit">修改密码 <span class="close OtPop"data-BoxId="xgmm"></span></div>
        <div class="TanBoxCont">
            <div class="FrameTable">
                <form id="Password_form" method="post" action="" onsubmit="return false;">
                    <div class="FrameTableTitl">修改密码</div>
                    <table class="FrameTableCont">
                        <tr>
                            <td class="FrameGroupName">旧密码  ：</td>
                            <td><input class="FrameGroupInput Lang" type="password" name="password" value="" /></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">新密码  ：</td>
                            <td><input class="FrameGroupInput Lang" type="password" name="new_password" value="" /></td>
                        </tr>
                        <tr>
                            <td class="FrameGroupName">确认密码  ：</td>
                            <td><input class="FrameGroupInput Lang" type="password" name="confirm_password" value="" /></td>
                        </tr>
                    </table>
                    <div class="TanBtn">
                        <span class="Btn Btn-green" onclick="do_Password()">确定</span>
                        <span class="Btn Btn-blue OtPop" data-BoxId="xgmm">取消</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="Tan " id="ckzl">
    <div class="TanBox ">
        <div class="TanBoxTit">资料详情 <span class="close OtPop"data-BoxId="ckzl"></span></div>
        <div class="TanBoxCont">
            <div class="FrameTable">
                <div class="FrameTableTitl">资料详情</div>
                <table class="FrameTableCont">
                    <tr>
                        <td class="FrameGroupName" style="padding: 10px;">姓名  ：</td>
                        <td class="name" style="padding: 10px;"><?php echo $admin['name'] ?></td>
                        <td class="FrameGroupName" rowspan="2" style="padding: 10px;">头像 ：</td>
                        <td rowspan="2" class="head" style="padding: 10px;">
                            <img class="userImg userhead" src="<?php echo empty($admin['head']) ? SOURCE_PATH . '/images/head.png' : $admin['head']; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName" style="padding: 10px;">登录账号 ：</td>
                        <td class="username" style="padding: 10px;"><?php echo $admin['username'] ?></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName" style="padding: 10px;">编号  ：</td>
                        <td class="number" style="padding: 10px;"><?php echo $admin['number'] ?></td>
                        <td class="FrameGroupName" style="padding: 10px;">部门 ：</td>
                        <td class="departmentname" style="padding: 10px;"><?php echo $admin['departmentname'] ?></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName" style="padding: 10px;">职务  ：</td>
                        <td class="positionname" style="padding: 10px;"><?php echo $admin['positionname'] ?></td>
                        <td class="FrameGroupName" style="padding: 10px;">员工状态 ：</td>
                        <td class="dirname" style="padding: 10px;"><?php echo $GLOBALS['USER_DIR'][$admin['dir']] ?></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName" style="padding: 10px;">入职日期 ：</td>
                        <td class="workdate" style="padding: 10px;"><?php echo $admin['workdate'] ?></td>
                        <td class="FrameGroupName" style="padding: 10px;">转正日期 ：</td>
                        <td class="positivedt" style="padding: 10px;"><?php echo $admin['positivedt'] ?></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName" style="padding: 10px;">手机号码  ：</td>
                        <td class="phone" style="padding: 10px;"><?php echo $admin['phone'] ?></td>
                        <td class="FrameGroupName" style="padding: 10px;">短号 ：</td>
                        <td class="trumpet" style="padding: 10px;"><?php echo $admin['trumpet'] ?></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName" style="padding: 10px;">身份证号  ：</td>
                        <td class="idCard" style="padding: 10px;"><?php echo $admin['idCard'] ?></td>
                        <td class="FrameGroupName" style="padding: 10px;">生日 ：</td>
                        <td class="birthday" style="padding: 10px;"><?php echo $admin['birthday'] ?></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName" style="padding: 10px;">邮箱  ：</td>
                        <td class="email" style="padding: 10px;"><?php echo $admin['email'] ?></td>
                        <td class="FrameGroupName" style="padding: 10px;">QQ ：</td>
                        <td class="QQ" style="padding: 10px;"><?php echo $admin['QQ'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    function ajaxFileUpload() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadhead"); ?>',
            secureuri: false,
            fileElementId: 'fileToUploadHead',
            dataType: 'json',
            data: {name: 'fileToUploadHead', id: 'fileToUploadHead'},
            success: function(data, status) {
                if (data.status == 1) {
                    $('.userhead').attr('src', data.src);
                } else {
                    Alert(data.msg);
                }
            },
            error: function(data, status, e) {
                Alert(e);
            }
        });
        return false;
    }
    function do_myInfo() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('main', "editMyinfo"); ?>",
            data: $('#myInfo_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    $('#xgzl .close').click();
                } else {
                    loading('none');
                    Alert(data.msg);
                }

            }
        });
    }
    ;

    function do_Password() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl('main', "edit_password"); ?>",
            data: $('#Password_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    Alert(data.msg);
                    $('#xgmm .close').click();
                } else {
                    loading('none');
                    Alert(data.msg);
                }

            }
        });
    }
    ;
    
    function findMyinfo(){
        $.get('<?php echo spUrl('main','myinfo')?>',{},function(re){
            if(re.status==1){
                $('#ckzl td.name').text(re.data.name);
                $('#ckzl td.username').text(re.data.username);
                $('#ckzl td.number').text(re.data.number);
                $('#ckzl td.departmentname').text(re.data.departmentname);
                $('#ckzl td.positionname').text(re.data.positionname);
                $('#ckzl td.dirname').text(re.data.dirname);
                $('#ckzl td.workdate').text(re.data.workdate);
                $('#ckzl td.positivedt').text(re.data.positivedt);
                $('#ckzl td.phone').text(re.data.phone);
                $('#ckzl td.trumpet').text(re.data.trumpet);
                $('#ckzl td.idCard').text(re.data.idCard);
                $('#ckzl td.birthday').text(re.data.birthday);
                $('#ckzl td.email').text(re.data.email);
                $('#ckzl td.QQ').text(re.data.QQ);
            }
        },'json');
    }
</script>


