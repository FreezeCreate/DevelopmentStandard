<?php require_once TPL_DIR . '/layout/header.php'; ?>
<script src="<?php echo SOURCE_PATH; ?>/js/index.js" type="text/javascript" charset="utf-8"></script>
<!--内容部分-->
<div class="Main">
    <div class="MainHeader noChoice">
        <ul class="MainNav">
            <li class="MainItem active a_01" data-clas="a_01">
                <img src="<?php echo SOURCE_PATH; ?>/images/icon/menu_mr.png"/>
                <span>工作台</span>
            </li>
        </ul>
    </div>
    <div class="MainCont">
        <iframe class="html active a_01" data-clas="a_01" src="<?php echo spUrl('main', 'home') ?>"></iframe>
    </div>
</div><!--内容部分-->

<!--修改资料-->
<div class="Tan " id="xgzl">
    <div class="TanBox ">
        <div class="TanBoxTit">修改资料 <span class="close OtPop" data-boxid="xgzl"></span></div>
        <div class="TanBoxCont">
            <div class="FrameTable">
                <div class="FrameTableTitl">修改资料</div>
                <table class="FrameTableCont">
                    <tr>
                        <td class="FrameGroupName">姓名 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                        <td class="FrameGroupName" rowspan="2">头像 ：</td>
                        <td rowspan="2">
                            <label>
                                <img class="userImg" src="<?php echo SOURCE_PATH; ?>/images/user/user.png" />
                                <input class="None upfile" type="file" name="" id="" value="" />
                                <span class="btn-xs btn btn-default xzwj">更改</span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName">登录账号 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName">编号 ：</td>
                        <td><input class="input" type="text" name="" id="" value="sadf" readonly="readonly" /></td>
                        <td class="FrameGroupName">部门 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName">职务 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                        <td class="FrameGroupName">员工状态 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName"><span class="colorRed">*</span> 入职日期 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                        <td class="FrameGroupName">转正日期 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName">手机号码 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                        <td class="FrameGroupName">短号 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName">省份证号 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                        <td class="FrameGroupName">生日 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName">邮箱 ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                        <td class="FrameGroupName">QQ ：</td>
                        <td><input class="input" type="text" name="" id="" value="" /></td>
                    </tr>
                </table>
                <div class="TanBtn">
                    <span class="btn btn-success pdX20 mg-r-30">确定</span>
                    <span class="btn btn-info pdX20 OtPop"data-boxid="xgzl">取消</span>
                </div>
            </div>
        </div>
    </div>
</div><!--修改资料-->

<!--修改密码-->
<div class="Tan " id="xgmm">
    <div class="TanBox ">
        <div class="TanBoxTit">修改密码 <span class="close OtPop" data-boxid="xgmm"></span></div>
        <div class="TanBoxCont">
            <div class="FrameTable">
                <div class="FrameTableTitl">修改密码</div>
                <table class="FrameTableCont">
                    <tr>
                        <td class="FrameGroupName">旧密码 ：</td>
                        <td><input class="input Lang" type="text" name="" id="" value="" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName">新密码 ：</td>
                        <td><input class="input Lang" type="text" name="" id="" value="" /></td>
                    </tr>
                    <tr>
                        <td class="FrameGroupName">确认密码 ：</td>
                        <td><input class="input Lang" type="text" name="" id="" value="" /></td>
                    </tr>
                </table>
                <div class="TanBtn">
                    <span class="btn btn-success pdX20 mg-r-30">确定</span>
                    <span class="btn btn-info pdX20 OtPop"data-boxid="xgmm">取消</span>
                </div>
            </div>
        </div>
    </div>
</div><!--修改密码-->
</body>
</html>
<script type="text/javascript">

    function menureq(id, name) {
        $.ajax({
            type: "POST",
            url: "main/getmenu",
            data: {pid: id},
            dataType: "json",
            success: function(res) {
                //console.log(res)
                if (res.code == 0) {
                    menuset(res.data, name)
                } else {
                    Alert(res.msg)
                }
            }
        });
    }
    ;

    function menuset(arr, name) {
        $('.MenuHead').text(name)
        $('.MenuBox.MenuBody').children().remove();
        var str = '<li class="MenuItem"><a class="MenuItemName Mitem active NewHtml" data-clas="a_01" data-url="<?php echo spUrl('main', 'home') ?>" data-name="工作台">'
                + '<img class="MenuImg" src="<?php echo SOURCE_PATH; ?>/images/icon/menu_gzt.png"/><span>工作台</span></a></li>'

        $.each(arr, function(k, v) {

            if (v.children[0]) {
                str += '<li class="MenuItem"><div class="MenuItemName Micon">'
                        + '<img class="MenuImg" src="<?php echo SOURCE_PATH; ?>/images/icon/' + v.img + '.png"/>'
                        + '<span>' + v.title + '</span></div><ul class="MenuBox">'

                $.each(v.children, function(key, val) {
                    str += '<li class="MenuItem">'
                            + '<a class="MenuItemName Mitem NewHtml" data-clas="a_' + val.id + '" data-url="' + val.href + '" data-name="' + val.title + '">'
                            + '<img class="MenuImg" src="<?php echo SOURCE_PATH; ?>/images/icon/' + val.img + '.png"/><span>' + val.title + '</span></a></li>'
                })

                str += '</ul></li>'
            } else {
                str += '<li class="MenuItem">'
                        + '<a class="MenuItemName Mitem NewHtml" data-clas="a_' + v.id + '" data-url="' + v.href + '" data-name="' + v.title + '">'
                        + '<img class="MenuImg" src="<?php echo SOURCE_PATH; ?>/images/icon/' + v.img + '.png"/><span>' + v.title + '</span></a></li>'
            }
        });
        $('.MenuBox.MenuBody').append(str)
    }
    ;
</script>