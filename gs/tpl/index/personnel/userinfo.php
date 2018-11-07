<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>员工信息</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
    </head>
    <body>
        <!--内容开始-->
        <div class="ContentBox">
            <div class="Tables">
                <div class="TablesHead">
                    <div class="TablesSerch">
                        <form action="<?php echo spUrl($c, $a) ?>" method="get">
                            <select class="TablesSerchInput" name="departmentid">
                                <option value="0">请选择部门</option>
                                <?php foreach ($dresults as $k => $v) { ?>
                                    <option <?php echo $page_con['departmentid'] == $k ? 'selected=""' : '' ?> value="<?php echo $k ?>"><?php echo $v ?></option>
                                <?php } ?>
                            </select>
                            <input class="TablesSerchInput" type="text" name="number" placeholder="编号" value="<?php echo $page_con['number'] ?>"/>
                            <input class="TablesSerchInput" name="name" type="text"  placeholder="姓名" value="<?php echo $page_con['name'] ?>"/>
                            <button class="Btn Btn-primary">查询</button>
                            <span class="Btn Btn-info TablesSerchReset">重置</span>
                        </form>
                    </div>
                    <a href="" class="Btn Btn-info"><i class="icon-resh"></i> 刷新</a>
                    <!--<div class="TablesAddBtn">导入</div>-->
                    <div class="TablesAddBtn" onclick="parent.window.newHtml('<?php echo spUrl($c,'addinfo')?>','员工信息');">＋ 新增员工</div>
                </div>
                <?php if (empty($results)) { ?>
                    <div class="noMsg">
                        <div class="noMsgCont">
                            <img class="" src="<?php echo SOURCE_PATH; ?>/images/noMsg.png"/>
                            <span>抱歉！暂时没有数据</span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="TablesBody top20">
                        <table>
                            <thead>
                                <tr>
                                    <td>编号</td>
                                    <td>姓名</td>
                                    <td>部门</td>
                                    <td>职位</td>
                                    <td>人员状态</td>
                                    <td>手机号</td>
                                    <td>邮箱</td>
                                    <td>生日</td>
                                    <td>入职日期</td>
                                    <td>转正日期</td>
                                    <td>允许登录</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $k => $v) { ?>
                                    <tr class="User<?php echo $v['id'] ?>">
                                        <td><?php echo $v['number'] ?></td>
                                        <td><?php echo $v['name'] ?></td>
                                        <td><?php echo $v['departmentname'] ?></td>
                                        <td><?php echo $v['positionname'] ?></td>
                                        <td><?php echo $GLOBALS['USER_DIR'][$v['dir']] ?></td>
                                        <td><?php echo $v['phone'] ?></td>
                                        <td><?php echo $v['email'] ?></td>
                                        <td><?php echo $v['birthday'] ?></td>
                                        <td><?php echo $v['workdate'] ?></td>
                                        <td><?php echo $v['positivedt'] ?></td>
                                        <td><?php echo $v['status'] == 1 ? '<a class="Btn Btn-xs Btn-primary"><i class="icon-yes"> </i> </a>' : '<a class="Btn Btn-denger"> <i class="icon-del"></i> </a>' ?></td>
                                        <td>
                                            <div class="list-menu" style="display: inline-block;">
                                            操作  ＋
                                            <ul class="menu">
                                                <li class="menu-item"><a onclick="parent.window.newHtml('<?php echo spUrl($c,'uinfo',array('id'=>$v['id']))?>','员工信息');">详情</a></li>
                                                <li class="menu-item"><a onclick="parent.window.newHtml('<?php echo spUrl($c,'addinfo',array('id'=>$v['id']))?>','编辑员工信息');">编辑</a></li>
                                                <li class="menu-item"><a class="color-red" onclick="del(<?php echo $v['id'] ?>)">删除</a></li>
                                            </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php require_once TPL_DIR . '/layout/page.php'; ?>
            </div>
        </div>
        <!--内容结束-->
    </body>
    <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
    <!--日期插件-->
    <?php require_once TPL_DIR . '/layout/apply.php'; ?>
</html>

<script>

    function do_submit() {
        $.ajaxFileUpload({
            url: '<?php echo spUrl("uplaodimage", "uploadExcel"); ?>',
            secureuri: false,
            fileElementId: 'fileToUpload',
            dataType: 'json',
            data: {name: 'fileToUpload', id: 'fileToUpload'},
            error: function(data, status, e) {
                $("#uploading").hide();
                alert(e);
            },
            success: function(data, status) {
                if (data.status == 1) {
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: "<?php echo spUrl($c, "userExcel"); ?>",
                        data: {filename: data.src},
                        dataType: "json",
                        async: false,
                        error: function(request) {
                            alert("数据提交失败！");
                        },
                        success: function(data) {
                            if (data.status == 1) {
                                alert(data.msg);
                                window.location.reload();
                            }
                        }
                    });
                } else {
                    alert(data.msg);
                }
            },
        });
        return false;

    }

    function del(id) {
        Confirm("确认删除？",function(){
            $.get("<?php echo spUrl($c, "delUserinfo"); ?>", {id: id}, function(data) {
                if (data.status == 1) {
                    $('.User' + id).remove();
                } else {
                    Alert(data.msg);
                }
            }, "json");
        });
    };
    

</script>
