<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>客户</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/Table.css"/>
		<script src="<?php echo SOURCE_PATH; ?>/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/public.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo SOURCE_PATH; ?>/js/Table.js" type="text/javascript" charset="utf-8"></script>
		<!--日期插件-->
		<script src="<?php echo SOURCE_PATH; ?>/js/jedate.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/header.js"></script>
        <script type="text/javascript" src="<?php echo SOURCE_PATH; ?>/js/apply.js"></script>
        <script src="<?php echo SOURCE_PATH_FRONT; ?>/js/ajaxfileupload.js"></script>
    </head>
    <body>
		<div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">客户合同申请</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <input type='hidden' name='saleid' value='<?php echo $sale['id'] ?>'/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">客户合同申请</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName">申请人</td>
                                    <td><?php echo $admin['name'];?></td>
                                    <td class="FrameGroupName">客户</td>
                                    <td><?php echo $sale['custname'];?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">备注</td>
                                    <td colspan="3"><textarea class="FrameGroupInput" name="explain"><?php echo $result['explain']; ?></textarea></td>
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
    <script type="text/javascript">
            $(function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                window.onresize = function() {
                    $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
                };
            });
            $('.addFile').click(function(){
                $(this).prev().click()
            })
    </script>
</html>
<script>
    function do_sub() {
        $.ajax({
            cache: false,
            type: "POST",
            url: "<?php echo spUrl($c, "saveCustractApply"); ?>",
            data: $('#check_form').serialize(),
            dataType: "json",
            async: false,
            error: function(request) {
                Alert('提交失败');
            },
            success: function(data) {
                if (data.status == 1) {
                     
                    Refresh();
                    Alert(data.msg);
                    parent.window.closHtml();
                } else {
                    Alert(data.msg);
                }

            }
        });
    }
</script>