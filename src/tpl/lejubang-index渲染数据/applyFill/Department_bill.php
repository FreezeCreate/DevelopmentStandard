<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>部门奖金申请</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">部门奖金申请</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
				<input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">部门奖金申请</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 金额：</td>
                                    <td><input class="FrameGroupInput input-digit" type="text" name="money" value="<?php echo $result['money']?>"/>元</td>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 日期：</td>
                                    <td><input class="FrameGroupInput" type="text" name="time" value="<?php echo date('Y-m-d') ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"><span style="color:red;">*</span> 说明</td>
                                    <td colspan="3"><textarea class="FrameGroupInput" name="explain" placeholder="领取人"><?php echo $result['explain']?></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="FrameTableFoot">
                <span class="Btn Big" onclick="do_sub()">提交</span>
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

        function do_sub() {
            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo spUrl($c, "saveDepartbill"); ?>",
                data: $('#check_form').serialize(),
                dataType: "json",
                async: false,
                error: function(request) {
                    Alert('提交失败');
                },
                success: function(data) {
                    if (data.status == 1) {
                        parent.window.closHtml();
                        Refresh();
                    } else {
                        Alert(data.msg);
                    }

                }
            });
        }
</script>