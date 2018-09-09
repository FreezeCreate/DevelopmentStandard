<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>培训计划</title>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_PATH; ?>/css/public.css"/>
        <link rel="stylesheet" href="<?php echo SOURCE_PATH_FRONT; ?>/kindeditor/themes/default/default.css" />
    </head>

    <body>
        <div class="Frame">
            <div class="FrameTit"><span class="FrameTitName">培训计划</span><span class="Close"></span></div>
            <div class="FrameBox">
                <form action="" method="" id="check_form" onsubmit="return false;">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>"/>
                    <div class="FrameCont">
                        <div class="FrameTable">
                            <div class="FrameTableTitl">培训计划</div>
                            <table class="FrameTableCont">
                                <tr>
                                    <td class="FrameGroupName">会议室</td>
                                    <td><?php echo $result['mRoom']; ?></td>
                                    <td class="FrameGroupName">培训师</td>
                                    <td><?php echo $result['recorder'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"> 开始日期</td>
                                    <td><?php echo $result['statdt'] ?></td>
                                    <td class="FrameGroupName"> 结束日期</td>
                                    <td><?php echo $result['enddt'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">培训主题</td>
                                    <td colspan='3'><?php echo $result['name'] ?></td>
                                </tr>

                                <tr>
                                    <td class="FrameGroupName">参与部门</td>
                                    <td colspan="3"><?php echo $result['recorder'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName"> 培训说明</td>
                                    <td colspan="3"><?php echo $result['explain'] ?></td>
                                </tr>
                                <tr>
                                    <td class="FrameGroupName">培训文件</td>
                                    <td colspan="3">
                                        <ul class="FileBox">
                                            <?php foreach ($result['files'] as $v) { ?>
                                                <li class="FileItem"><span class="FileItemNam download" itemid="<?php echo $v['id'] ?>"><?php echo $v['filename'] ?></span></li>
                                            <?php } ?>
                                        </ul>
                                    </td>
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

        $(function() {
            $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
            window.onresize = function() {
                $('.FrameBox').height($(window).height() - $('.FrameTit')[0].offsetHeight - $('.FrameTableFoot')[0].offsetHeight);
            };
            $('.addFile').click(function() {
                $(this).prev().click()
            });
        });

</script>