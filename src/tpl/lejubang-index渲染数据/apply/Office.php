<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>办公用品</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">办公用品</span><span class="Close"></span></div>
            <div class="FrameBox">
                <div class="FrameCont">
                    <div class="FrameTable">
                        <div class="FrameTableTitl">资料详情</div>
                        <table class="FrameTableCont">
                        <tbody>
                            <tr>
                                <td class="tit01">名称：</td>
                                <td><?php echo $result['name'] ?></td>
                                <td class="tit01">类别：</td>
                                <td><?php echo $result['type']; ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">规格：</td>
                                <td><?php echo $result['model'] ?></td>
                                <td class="tit01">型号：</td>
                                <td><?php echo $result['format']; ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">单价：</td>
                                <td><?php echo $result['price'] ?></td>
                                <td class="tit01">单位：</td>
                                <td><?php echo $result['unit']; ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">库存：</td>
                                <td><?php echo $result['stock'] ?></td>
                                <td class="tit01">操作人：</td>
                                <td><?php echo $result['optname']; ?></td>
                            </tr>
                            <tr>
                                <td class="tit01">备注</td>
                                <td colspan="3"><?php echo $result['explain'] ?></td>
                            </tr>
                        </tbody>
                    </table>

                        <div class="FrameListTable">
                            <p class="FrameListTableTit">处理记录</p>
                            <table class="FrameListTableItem">
                        <tbody>
                            <tr>
                                <td class="tit01">序号</td>
                                <td class="tit01">处理人</td>
                                <td class="tit01">处理状态</td>
                                <td class="tit01">说明</td>
                                <td class="tit01">时间</td>
                            </tr>
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
					</div>
                    <?php if (in_array($admin['id'], $bill['nowcheckid'])) { ?>
                         <p class="FrameListTableTit">审核处理</p>
                        <form id="check_form">
                            <input type="hidden" name="id" value="<?php echo $bill['id'] ?>"/>
                            <table class="FrameTableCont">
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
                                        <td>说明：</td>
                                        <td><textarea class="FrameGroupInput" name="checksm"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><a class="but but-primary Btn Big" onclick="do_subcheck()">提交处理</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    <?php } ?>
            </div>
        </div>
	</div>
</div>
    </body>

</html>

<script>
    function do_subcheck() {
        //loading();
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCheck"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                //loading('none');
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                    //loading('none');
                    parent.window.closHtml();
                    Refresh();
                } else {
                    Alert(data.msg);
                   // loading('none');
                }

            }
        });
    }
</script>