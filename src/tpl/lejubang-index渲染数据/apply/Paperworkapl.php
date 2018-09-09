<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>证件申请</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
        <script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
        <!--日期插件-->
        <script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">证件申请</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <form id="check_form">
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                        <div class="FrameTableTitl">证件申请</div>
                        <table class="FrameTableCont">
                            <tbody>
                                <tr>
                                    <td class="FrameGroupName">编号：</td>
                                    <td><?php echo $result['number'] ?></td>
                                    <td class="FrameGroupName">申请时间：</td>
                                    <td><?php echo $result['applydt'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">申请人：</td>
                                    <td><?php echo $result['uname'] ?></td>
                                    <td class="FrameGroupName">部门：</td>
                                    <td><?php echo $result['udeptname'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">申请证件：</td>
                                    <td><?php echo $result['gname'] ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"> 说明：</td>
                                    <td colspan="3"><?php echo $result['explain'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"> 相关文件：</td>
                                    <td colspan="3">
                                        <?php foreach ($result['files'] as $v) { ?>
                                            <div class="download"><a class="download-a" href="javascript:void(0)" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></a>
                                            <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="FrameListTableTit">处理记录</p>
                        <table class="FrameListTableItem">
                            <thead>
                                <tr>
                                    <td class="tit01">序号</td>
                                    <td class="tit01">处理人</td>
                                    <td class="tit01">处理状态</td>
                                    <td class="tit01">说明</td>
                                    <td class="tit01">时间</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $bill['uname'] ?></td>
                                    <td>提交</td>
                                    <td></td>
                                    <td><?php echo $bill['applydt'] ?></td>
                                </tr>
                                <?php foreach ($log as $k => $v) { ?>
                                    <tr>
                                        <td><?php echo $k + 2; ?></td>
                                        <td><?php echo $v['checkname']; ?></td>
                                        <td><?php echo $v['statusname']; ?></td>
                                        <td><?php echo $v['explain']; ?></td>
                                        <td><?php echo $v['optdt']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if (in_array($admin['id'], $bill['nowcheckid'])) { ?>
                            <div class="tit">审核处理</div>
                            <form id="check_form">
                                <input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
                                <table class="table01">
                                    <tbody>
                                        <tr>
                                            <td class="tit01">状态：</td>
                                            <td class="tit01">待<?php echo $bill['nowcheckname'] ?>处理</td>
                                        </tr>
                                        <tr>
                                            <td>处理流程：</td>
                                            <td><?php echo $course['name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><span style="color:red;">*</span> 处理人：</td>
                                            <td><?php echo $admin['name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><span style="color:red;">*</span> 处理动作：</td>
                                            <td>
                                                <?php foreach ($course['courseact'] as $v) { ?>
                                                    <label class="color-<?php echo $v[2] ?>"><input type="radio" name="status" value="<?php echo $v[1] ?>"/> <?php echo $v[0] ?></label>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>说明1：</td>
                                            <td><textarea class="form-control" name="checksm"></textarea></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </form>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="FrameTableFoot">
        <a class="but but-primary" ><span class="Btn Big" onclick="do_subcheck()"><?php echo empty($result['id']) ? '提交' : '重新提交'; ?></span></a>
    </div>
</div>		
</body>

</html>

<script>
    function do_subcheck() {
        loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCheck"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    loading('none');
                    window.close();
                    parent.location.replace(parent.location.href);
                } else {
                    Alert(data.msg);
                    loading('none');
                }

            }
        });
    }
</script>